<?php
session_start();
require '../includes/Conexion.php';
require 'helpers.php';

$conexion = conectarBD();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
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
