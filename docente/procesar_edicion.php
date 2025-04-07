<?php
session_start();
require '../includes/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $estado = trim($_POST['estado']);
    $docente_id = $_SESSION['usuario_id'];

    $sql = "UPDATE clases SET titulo = ?, descripcion = ?, estado = ? WHERE id_clase = ? AND profesor_id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "sssii", $titulo, $descripcion, $estado, $id, $docente_id);
    mysqli_stmt_execute($stmt);

    header("Location: perfil_profesor.php?mensaje=Clase actualizada");
    exit();
}
?>
