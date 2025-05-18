<?php

function correoExiste($email, $conexion) {
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE Email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    return $stmt->get_result()->num_rows > 0;
}

function registrarUsuario($data, $files, $conexion) {
    // Campos comunes
    $usuario = $data['Usuario'];
    $clave = password_hash($data['Clave'], PASSWORD_DEFAULT);
    $nombre = $data['Nombre_Completo'];
    $telefono = $data['Telefono'];
    $direccion = $data['Direccion'];
    $email = $data['Email'];
    $rol_id = (int)$data['Rol'];

    // Campos opcionales para docente
    $experiencia = $rol_id === 3 ? $data['Experiencia'] : null;
    $titulo = $rol_id === 3 ? $data['Titulo'] : null;
    $hoja_vida_path = null;

    // Manejar archivo hoja de vida solo si rol es docente y archivo existe
    if ($rol_id === 3 && isset($files['hoja_vida_path']) && $files['hoja_vida_path']['error'] === 0) {
        $nombreArchivo = uniqid() . '_' . basename($files['hoja_vida_path']['name']);
        $rutaDestino = '../uploads/hojas_vida/' . $nombreArchivo;
        move_uploaded_file($files['hoja_vida_path']['tmp_name'], $rutaDestino);
        $hoja_vida_path = $nombreArchivo;
    }

    // Preparar y ejecutar insert
    $stmt = $conexion->prepare("INSERT INTO usuarios (Usuario, Clave, Nombre_Completo, Telefono, Direccion, Email, rol_id, experiencia_laboral, titulo_profesional, hoja_vida_path) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssiss", $usuario, $clave, $nombre, $telefono, $direccion, $email, $rol_id, $experiencia, $titulo, $hoja_vida_path);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}
