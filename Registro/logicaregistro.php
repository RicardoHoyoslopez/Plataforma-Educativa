<?php
session_start();
require '../includes/Conexion.php';

// Configuración para desarrollo--------------
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Verificación de conexión y tabla------------
if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

// Verificación EXPLÍCITA de la estructura de la tabla----------------
$result = mysqli_query($conexion, "SHOW COLUMNS FROM usuarios");
if (!$result) {
    die("Error al verificar estructura de tabla: " . mysqli_error($conexion));
}

$columns = [];
while ($row = mysqli_fetch_assoc($result)) {
    $columns[$row['Field']] = $row;
}

// Verificación específica de columnas requeridas-------------------------
$required_columns = ['hoja_vida_path', 'titulo_profesional', 'experiencia_laboral'];
foreach ($required_columns as $col) {
    if (!isset($columns[$col])) {
        die("ERROR CRÍTICO: La columna '$col' no existe en la tabla usuarios");
    }
}


// ===== [INICIO DE DEPURACIÓN] ===== //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función de validación mejorada
    function validate($data, $conexion) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return mysqli_real_escape_string($conexion, $data);
    }

    // Validar datos comunes
    $Nombre_Completo = validate($_POST['Nombre_Completo'], $conexion);
    $Usuario = validate($_POST['Usuario'], $conexion);
    $Email = filter_var(validate($_POST['Email'], $conexion), FILTER_SANITIZE_EMAIL);
    $Direccion = validate($_POST['Direccion'], $conexion);
    $Telefono = validate($_POST['Telefono'], $conexion);
    $Clave = $_POST['Clave']; // No aplicar validate para no afectar el hash
    $Rol = (int)validate($_POST['Rol'], $conexion);

    // Verificar campos obligatorios
    $camposRequeridos = [
        'Nombre_Completo' => $_POST['Nombre_Completo'] ?? '',
        'Usuario' => $_POST['Usuario'] ?? '',
        'Email' => $_POST['Email'] ?? '',
        'Clave' => $_POST['Clave'] ?? '',
        'Rol' => $_POST['Rol'] ?? ''
    ];

    foreach ($camposRequeridos as $campo => $valor) {
        if (empty($valor)) {
            $_SESSION['error_registro'] = "El campo $campo es requerido";
            header("Location: ../Registro/RegistroUsuarios.php");
            exit();
        }
    }

    // Verificar rol válido
    $query_rol = "SELECT id FROM roles WHERE id = ?";
    $stmt_rol = mysqli_prepare($conexion, $query_rol);
    mysqli_stmt_bind_param($stmt_rol, "i", $Rol);
    mysqli_stmt_execute($stmt_rol);
    $result_rol = mysqli_stmt_get_result($stmt_rol);

    if (mysqli_num_rows($result_rol) == 0) {
        header("Location: ../Registro/RegistroUsuarios.php?error=Rol no válido");
        exit();
    }

    // Verificar usuario existente (CONSULTA PREPARADA)
    $sql_check = "SELECT id FROM usuarios WHERE Usuario = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ss", $Usuario, $Email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        header("Location: ../Registro/RegistroUsuarios.php?error=El usuario ya existe");
        exit();
    }

    // Hash de la contraseña
    $ClaveHash = password_hash($Clave, PASSWORD_BCRYPT);

    // TRANSACCIÓN PARA INSERTAR DATOS
    mysqli_begin_transaction($conexion);

    try {
        // Insertar usuario (CONSULTA PREPARADA)
        $sql_usuario = "INSERT INTO usuarios (Usuario, Clave, Nombre_Completo, Telefono, Direccion, Email, rol_id) 
                       VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt_usuario = mysqli_prepare($conexion, $sql_usuario);
        mysqli_stmt_bind_param($stmt_usuario, "ssssssi", $Usuario, $ClaveHash, $Nombre_Completo, $Telefono, $Direccion, $Email, $Rol);
        mysqli_stmt_execute($stmt_usuario);
        
        $usuario_id = mysqli_insert_id($conexion);

        // Si es docente, insertar datos adicionales
        if ($Rol == 3) { // ID de docente
            $Especialidad = validate($_POST['Especialidad'] ?? '', $conexion);
            $Titulo = validate($_POST['Titulo'] ?? '', $conexion);
            $Institucion = validate($_POST['Institucion'] ?? '', $conexion);
            
            if (empty($Especialidad) || empty($Titulo)) {
                throw new Exception("Todos los campos de docente son requeridos");
            }

            $sql_docente = "INSERT INTO docentes (usuario_id, especialidad, titulo, institucion) 
                            VALUES (?, ?, ?, ?)";
            $stmt_docente = mysqli_prepare($conexion, $sql_docente);
            mysqli_stmt_bind_param($stmt_docente, "isss", $usuario_id, $Especialidad, $Titulo, $Institucion);
            mysqli_stmt_execute($stmt_docente);
        }

        // Confirmar transacción
        mysqli_commit($conexion);
        
        // Redirección exitosa
        $_SESSION['registro_exitoso'] = true;
        header("Location: ../login/index.php?registro=exitoso");
        exit();

    } catch (Exception $e) {
        // Revertir transacción en caso de error
        mysqli_rollback($conexion);
        header("Location: ../Registro/RegistroUsuarios.php?error=" . urlencode($e->getMessage()));
        exit();
    } finally {
        if (isset($stmt)) mysqli_stmt_close($stmt);
        if (isset($stmt_check)) mysqli_stmt_close($stmt_check);
        mysqli_close($conexion);
    }
} else {
    header("Location: ../Registro/RegistroUsuarios.php");
    exit();
}