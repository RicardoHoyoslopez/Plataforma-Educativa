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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Procesamiento seguro de datos
    function limpiarDato($dato, $conexion) {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
        return mysqli_real_escape_string($conexion, $dato);
    }

    // Validación de campos obligatorios---------------
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

    // Procesar datos básicos-----------------------
    $Nombre_Completo = limpiarDato($_POST['Nombre_Completo'], $conexion);
    $Usuario = limpiarDato($_POST['Usuario'], $conexion);
    $Email = filter_var(limpiarDato($_POST['Email'], $conexion), FILTER_SANITIZE_EMAIL);
    $Direccion = limpiarDato($_POST['Direccion'] ?? '', $conexion);
    $Telefono = limpiarDato($_POST['Telefono'] ?? '', $conexion);
    $Rol = (int)$_POST['Rol'];
    $ClaveHash = password_hash($_POST['Clave'], PASSWORD_BCRYPT);

    // Procesar datos específicos de docentes--------------------------------
    $hoja_vida_path = null;
    $Titulo = null;
    $Experiencia = null;

    if ($Rol == 3) {
        if (isset($_FILES['hoja_vida_path']) && $_FILES['hoja_vida_path']['error'] === UPLOAD_ERR_OK) {
            $directorio = "../uploads/hojas_vida/";
            
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            
            $nombreOriginal = basename($_FILES['hoja_vida_path']['name']);
            $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
            $nombreUnico = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\.\-]/', '', $nombreOriginal);
            $rutaCompleta = $directorio . $nombreUnico;
            
            $extensionesPermitidas = ['pdf', 'doc', 'docx'];
            if (!in_array($extension, $extensionesPermitidas)) {
                $_SESSION['error_registro'] = "Solo se permiten archivos PDF, DOC o DOCX";
                header("Location: ../Registro/RegistroUsuarios.php");
                exit();
            }
            
            if ($_FILES['hoja_vida_path']['size'] > 5000000) {
                $_SESSION['error_registro'] = "El archivo es demasiado grande (máximo 5MB)";
                header("Location: ../Registro/RegistroUsuarios.php");
                exit();
            }
            
            if (!move_uploaded_file($_FILES['hoja_vida_path']['tmp_name'], $rutaCompleta)) {
                $_SESSION['error_registro'] = "Error al subir el archivo";
                header("Location: ../Registro/RegistroUsuarios.php");
                exit();
            }
            
            $hoja_vida_path = "uploads/hoja_vida_path/" . $nombreUnico;
        } else {
            $_SESSION['error_registro'] = "La hoja de vida es requerida para docentes";
            header("Location: ../Registro/RegistroUsuarios.php");
            exit();
        }

        $Titulo = limpiarDato($_POST['Titulo'] ?? '', $conexion);
        $Experiencia = limpiarDato($_POST['Especialidad'] ?? '', $conexion);

        if (empty($Titulo)) {
            $_SESSION['error_registro'] = "El título es requerido para docentes";
            header("Location: ../Registro/RegistroUsuarios.php");
            exit();
        }
    }

    // Verificar si el usuario o email ya existen--------------------------
    $sql_check = "SELECT id FROM usuarios WHERE Usuario = ? OR Email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ss", $Usuario, $Email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        $_SESSION['error_registro'] = "El usuario o email ya están registrados";
        header("Location: ../Registro/RegistroUsuarios.php");
        exit();
    }

    // SOLUCIÓN DEFINITIVA: Consulta alternativa probada--------------------------------
    $sql = "INSERT INTO usuarios (
        Usuario, Clave, Nombre_Completo, Telefono, Direccion, 
        Email, rol_id, hoja_vida_path, titulo_profesional, 
        experiencia_laboral, estado_verificacion
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $estado_verificacion = 'pendiente';
    
    // Verificación final antes de ejecutar-------------------------------------------------
    if (!$stmt = mysqli_prepare($conexion, $sql)) {
        error_log("Error preparando consulta: " . mysqli_error($conexion));
        $_SESSION['error_registro'] = "Error técnico al preparar registro";
        header("Location: ../Registro/RegistroUsuarios.php");
        exit();
    }

    mysqli_stmt_bind_param(
        $stmt,
        "ssssssissss",
        $Usuario,
        $ClaveHash,
        $Nombre_Completo,
        $Telefono,
        $Direccion,
        $Email,
        $Rol,
        $hoja_vida_path,
        $Titulo,
        $Experiencia,
        $estado_verificacion
    );

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['registro_exitoso'] = true;
        header("Location: ../login/index.php?registro=exitoso");
        exit();
    } else {
        error_log("Error ejecutando consulta: " . mysqli_stmt_error($stmt));
        $_SESSION['error_registro'] = "Error al guardar los datos";
        header("Location: ../Registro/RegistroUsuarios.php");
        exit();
    }
} else {
    header("Location: ../Registro/RegistroUsuarios.php");
    exit();
}