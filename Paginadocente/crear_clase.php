<?php
session_start();
require '../includes/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $estado = $_POST['estado'];
    
    // Convertir el datetime-local a formato MySQL
    $horario = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));
    
    $profesor_id = $_SESSION['usuario_id'];

    $sql = "INSERT INTO clases (titulo, descripcion, fecha_creacion, estado, profesor_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssi", $titulo, $descripcion, $horario, $estado, $profesor_id);
    mysqli_stmt_execute($stmt);

    header("Location: perfil_profesor.php?mensaje=Clase creada exitosamente");
    exit();
}

