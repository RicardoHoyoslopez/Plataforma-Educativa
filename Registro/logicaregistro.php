<?php
session_start();
require '../includes/Conexion.php';
require 'helpers.php';

$conexion = conectarBD();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $usuario = $_POST['Usuario'];
    $email = $_POST['Email'];

    // Validar existencia de usuario o correo
    if (usuarioExiste($usuario, $conexion)) {
        $_SESSION['error_registro'] = 'El nombre de usuario ya está registrado.';
        header("Location: RegistroUsuarios.php");
        exit;
    }

    if (correoExiste($email, $conexion)) {
    $_SESSION['error_registro'] = 'El correo electrónico ya está registrado.';
    header("Location: RegistroUsuarios.php");
    exit;
}

    // Registrar usuario si no hay duplicados
    $resultado = registrarUsuario($_POST, $_FILES, $conexion);
    
    if ($resultado['estado'] === 'error') {
        $_SESSION['error_registro'] = $resultado['mensaje'];
        header("Location: RegistroUsuario.php");
        exit;
    } else {
        header("Location: ../login/index.php");
        exit;
    }
} else {
    $_SESSION['error_registro'] = "Acceso no permitido.";
    header("Location: RegistroUsuario.php");
    exit;
}
