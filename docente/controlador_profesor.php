<?php
session_start();
require '../includes/Conexion.php';

if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
    header("Location: ../login/Index.php?error=Acceso denegado");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre_completo'];
$usuario = $_SESSION['usuario'];

// Traer clases con sus horarios
$sql = "SELECT c.id_clase, c.titulo, c.descripcion, c.estado, c.fecha_creacion, h.dia, h.hora_inicio, h.hora_fin 
        FROM clases c
        JOIN horarios h ON c.id_clase = h.id_clase
        WHERE c.profesor_id = ? AND c.estado = 'activa'
        ORDER BY c.fecha_creacion DESC";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>
