<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

/**
 * Elimina los horarios asociados a una clase.
 */
function eliminarHorarios($conexion, $id_clase) {
    $sql = "DELETE FROM horarios WHERE id_clase = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_clase);
    mysqli_stmt_execute($stmt);
}

/**
 * Elimina una clase siempre que pertenezca al docente.
 */
function eliminarClase($conexion, $id_clase, $docente_id) {
    $sql = "DELETE FROM clases WHERE id_clase = ? AND profesor_id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_clase, $docente_id);
    mysqli_stmt_execute($stmt);
}

// --- Ejecución principal ---
if (isset($_GET['id'])) {
    $clase_id = intval($_GET['id']);
    $docente_id = $_SESSION['usuario_id'];

    eliminarHorarios($conexion, $clase_id);
    eliminarClase($conexion, $clase_id, $docente_id);

    header("Location: perfil_profesor.php?mensaje=Clase eliminada");
    exit();
} else {
    header("Location: perfil_profesor.php?error=ID inválido");
    exit();
}
?>
