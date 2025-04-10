<?php
session_start();
require '../includes/Conexion.php';


// ===== [INICIO DE DEPURACIÓN] ===== //
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo '<div style="background:#f0f0f0; padding:20px; margin:20px; border:1px solid red; font-family:monospace;">';
    echo '<h3 style="color:red;">📦 DATOS RECIBIDOS (DEBUG)</h3>';
    
    echo '<h4>$_POST:</h4>';
    echo '<pre>' . print_r($_POST, true) . '</pre>';
    
    if (!empty($_FILES)) {
        echo '<h4>$_FILES:</h4>';
        echo '<pre>' . print_r($_FILES, true) . '</pre>';
    }
    
    echo '</div>';
    // exit(); // Descomenta esta línea si solo quieres ver los datos sin procesar
}
// ===== [FIN DE DEPURACIÓN] ===== //

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Función para la validación
    function limpiarDato($dato, $conexion) {
        $dato = trim($dato);
        $dato = stripslashes($dato);
        $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');
        return mysqli_real_escape_string($conexion, $dato);
    }

    // captura los datos y luego valida los datos básicos----------------------
    $camposRequeridos = [
        'Nombre_Completo' => $_POST['Nombre_Completo'] ?? '',
        'Usuario' => $_POST['Usuario'] ?? '',
        'Email' => $_POST['Email'] ?? '',
        'Clave' => $_POST['Clave'] ?? '',
        'Rol' => $_POST['Rol'] ?? ''
    ];

    foreach ($camposRequeridos as $campo => $valor) {
        if (empty($valor)) {
            header("Location: ../Registro/RegistroUsuarios.php?error=El campo $campo es requerido");
            exit();
        }
    }

    // Asignar datos básicos------------------
    $Nombre_Completo = limpiarDato($_POST['Nombre_Completo'], $conexion);
    $Usuario = limpiarDato($_POST['Usuario'], $conexion);
    $Email = filter_var(limpiarDato($_POST['Email'], $conexion), FILTER_SANITIZE_EMAIL);
    $Direccion = limpiarDato($_POST['Direccion'] ?? '', $conexion);
    $Telefono = limpiarDato($_POST['Telefono'] ?? '', $conexion);
    $Rol = (int)$_POST['Rol'];
    $ClaveHash = password_hash($_POST['Clave'], PASSWORD_BCRYPT);

    // Inicializar campos de docente---------------------
    $hoja_vida_path = null;
    $Titulo = null;
    $Experiencia = null;

    // Validar campos de docente si el rol es 3--------------------------
    if ($Rol == 3) {
        // Procesar hoja de vida
        if (isset($_FILES['hoja_vida']) && $_FILES['hoja_vida']['error'] === UPLOAD_ERR_OK) {
            $directorio = "../uploads/hojas_vida/";
            
            // Crear directorio si no existe
            if (!file_exists($directorio)) {
                mkdir($directorio, 0777, true);
            }
            
            // Sanitizar el nombre del archivo
            $nombreOriginal = basename($_FILES['hoja_vida']['name']);
            $extension = strtolower(pathinfo($nombreOriginal, PATHINFO_EXTENSION));
            $nombreUnico = uniqid() . '_' . preg_replace('/[^A-Za-z0-9\.\-]/', '', $nombreOriginal);
            $rutaCompleta = $directorio . $nombreUnico;
            
            // Validar extensión
            $extensionesPermitidas = ['pdf', 'doc', 'docx'];
            if (!in_array($extension, $extensionesPermitidas)) {
                header("Location: ../Registro/RegistroUsuarios.php?error=Solo se permiten archivos PDF, DOC o DOCX");
                exit();
            }
            
            // Validar tamaño (5MB máximo)
            if ($_FILES['hoja_vida']['size'] > 5000000) {
                header("Location: ../Registro/RegistroUsuarios.php?error=El archivo es demasiado grande (máximo 5MB)");
                exit();
            }
            
            // Mover archivo al directorio
            if (!move_uploaded_file($_FILES['hoja_vida']['tmp_name'], $rutaCompleta)) {
                header("Location: ../Registro/RegistroUsuarios.php?error=Error al subir el archivo");
                exit();
            }
            
            $hoja_vida_path = $rutaCompleta;
        } else {
            header("Location: ../Registro/RegistroUsuarios.php?error=La hoja de vida es requerida para docentes");
            exit();
        }

        $Titulo = limpiarDato($_POST['Titulo'] ?? '', $conexion);
        $Experiencia = limpiarDato($_POST['Institucion'] ?? '', $conexion);

        if (empty($Titulo)) {
            header("Location: ../Registro/RegistroUsuarios.php?error=El título es requerido para docentes");
            exit();
        }
    }

    // Verificar en la base de datos si el usuario ya existe--------------------
    $sql_check = "SELECT id FROM usuarios WHERE Usuario = ? OR Email = ?";
    $stmt_check = mysqli_prepare($conexion, $sql_check);
    mysqli_stmt_bind_param($stmt_check, "ss", $Usuario, $Email);
    mysqli_stmt_execute($stmt_check);
    $result_check = mysqli_stmt_get_result($stmt_check);

    if (mysqli_num_rows($result_check) > 0) {
        header("Location: ../Registro/RegistroUsuarios.php?error=El usuario o email ya están registrados");
        exit();
    }

    // TRANSACCIÓN PARA INSERTAR-------------------------------------
    mysqli_begin_transaction($conexion);

    try {
        // Consulta SQL unificada
        $sql = "INSERT INTO usuarios (
            Usuario, 
            Clave, 
            Nombre_Completo, 
            Telefono, 
            Direccion, 
            Email, 
            rol_id,
            hoja_vida_path,
            titulo_profesional,
            experiencia_laboral
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = mysqli_prepare($conexion, $sql);
        mysqli_stmt_bind_param(
            $stmt,
            "ssssssisss",
            $Usuario,
            $ClaveHash,
            $Nombre_Completo,
            $Telefono,
            $Direccion,
            $Email,
            $Rol,
            $hoja_vida_path,
            $Titulo,
            $Experiencia
        );

        if (!mysqli_stmt_execute($stmt)) {
            throw new Exception("Error al guardar usuario: " . mysqli_error($conexion));
        }

        mysqli_commit($conexion);
        $_SESSION['registro_exitoso'] = true;
        header("Location: ../login/index.php?registro=exitoso");
        exit();

    } catch (Exception $e) {
        // Si hay error, eliminar el archivo subido si existe
        if ($Rol == 3 && !empty($hoja_vida_path) && file_exists($hoja_vida_path)) {
            unlink($hoja_vida_path);
        }
        
        mysqli_rollback($conexion);
        error_log("Error en registro: " . $e->getMessage());
        header("Location: ../Registro/RegistroUsuarios.php?error=Error al procesar el registro");
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
?>