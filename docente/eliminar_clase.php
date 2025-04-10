<?php
session_start();
require '../includes/Conexion.php';

if (isset($_GET['id'])) {
    $clase_id = intval($_GET['id']);
    $docente_id = $_SESSION['usuario_id'];

    // Primero eliminamos los horarios relacionados con la clase
    $sql_horarios = "DELETE FROM horarios WHERE id_clase = ?";
    $stmt_horarios = mysqli_prepare($conexion, $sql_horarios);
    mysqli_stmt_bind_param($stmt_horarios, "i", $clase_id);
    mysqli_stmt_execute($stmt_horarios);

    // Luego eliminamos la clase
    $sql_clase = "DELETE FROM clases WHERE id_clase = ? AND profesor_id = ?";
    $stmt_clase = mysqli_prepare($conexion, $sql_clase);
    mysqli_stmt_bind_param($stmt_clase, "ii", $clase_id, $docente_id);
    mysqli_stmt_execute($stmt_clase);

    header("Location: perfil_profesor.php?mensaje=Clase eliminada");
    exit();
} else {
    header("Location: perfil_profesor.php?error=ID inválido");
    exit();
}
?>
