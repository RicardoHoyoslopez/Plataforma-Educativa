<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

if (isset($_GET['id'])) {
    $pqr_id = intval($_GET['id']);
    $usuario_id = $_SESSION['usuario_id'];

    // Eliminamos la PQR si pertenece al usuario que la intenta eliminar
    $sql = "DELETE FROM pqrs WHERE id_pqrs = ? AND id_usuario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $pqr_id, $usuario_id);
    mysqli_stmt_execute($stmt);

    // Redirigir con mensaje de éxito
    header("Location: ../docente/perfil_profesor.php?mensaje=PQR eliminada");
    exit();
} else {
    // Redirigir con error si no se envió ID
    header("Location: ../docente/perfil_profesor.php?error=ID inválido");
    exit();
}
?>
