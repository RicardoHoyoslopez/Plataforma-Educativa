<?php

// Verifica si el nombre de usuario ya existe en la base de datos
function usuarioExiste($usuario, $conexion)
{
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE Usuario = ?");
    $stmt->bind_param("s", $usuario);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

// Verifica si el correo electrónico ya existe en la base de datos
function correoExiste($email, $conexion)
{
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

// Función principal que registra un nuevo usuario
function registrarUsuario($data, $files, $conexion)
{
    // Extraer los campos comunes del formulario
    $usuario = $data['Usuario'];
    $clave = password_hash($data['Clave'], PASSWORD_DEFAULT); // Encriptar la clave
    $nombre = $data['Nombre_Completo'];
    $telefono = $data['Telefono'];
    $direccion = $data['Direccion'];
    $email = $data['Email'];
    $rol_id = (int)$data['Rol']; // Convertir el rol a número entero

    // Validar si el usuario ya existe
    if (usuarioExiste($usuario, $conexion)) {
        return ['estado' => 'error', 'mensaje' => 'El nombre de usuario ya está en uso.'];
    }

    // Validar si el correo ya existe
    if (correoExiste($email, $conexion)) {
        return ['estado' => 'error', 'mensaje' => 'El correo electrónico ya está registrado.'];
    }

    // Si es docente (rol 3), extraer campos adicionales
    $experiencia = $rol_id === 3 ? $data['Experiencia'] : null;
    $titulo = $rol_id === 3 ? $data['Titulo'] : null;
    $hoja_vida_path = null;

    // Si es docente y subió un archivo de hoja de vida
    if ($rol_id === 3 && isset($files['hoja_vida_path']) && $files['hoja_vida_path']['error'] === 0) {
        $nombreArchivo = uniqid() . '_' . basename($files['hoja_vida_path']['name']); // Generar nombre único
        $rutaDestino = '../uploads/hojas_vida/' . $nombreArchivo;
        move_uploaded_file($files['hoja_vida_path']['tmp_name'], $rutaDestino); // Mover el archivo al servidor
        $hoja_vida_path = $nombreArchivo;
    }

    // Insertar el nuevo usuario en la base de datos
    $stmt = $conexion->prepare("INSERT INTO usuarios (Usuario, Clave, Nombre_Completo, Telefono, Direccion, Email, rol_id, experiencia_laboral, titulo_profesional, hoja_vida_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssisss", $usuario, $clave, $nombre, $telefono, $direccion, $email, $rol_id, $experiencia, $titulo, $hoja_vida_path);
    $stmt->execute();

    // Verificar si se insertó correctamente
    if ($stmt->affected_rows > 0) {
        return ['estado' => 'ok'];
    } else {
        return ['estado' => 'error', 'mensaje' => 'Error al registrar el usuario.'];
    }
}