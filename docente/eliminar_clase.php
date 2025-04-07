<?php
session_start();
require '../includes/Conexion.php';

if (isset($_GET['id'])) {
    $clase_id = intval($_GET['id']);
    $docente_id = $_SESSION['usuario_id']; // Asegúrate de que esto esté seteado

    $sql = "DELETE FROM clases WHERE id_clase = ? AND profesor_id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $clase_id, $docente_id);
    mysqli_stmt_execute($stmt);

    header("Location: perfil_profesor.php?mensaje=Clase eliminada");
    exit();
} else {
    header("Location: perfil_profesor.php?error=ID inválido");
    exit();
}
?>
