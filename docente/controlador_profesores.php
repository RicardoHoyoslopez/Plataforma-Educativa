<?php
session_start();
require '../includes/Conexion.php';

// Seguridad para estudiantes
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
    header("Location: ../login/Index.php?error=Acceso denegado");
    exit();
}

// Inicializar variables
$clases = null;
$profesor = null;
$profesores = null;
$clases_con_horarios = [];

// Consultar clases si hay un profesor seleccionado
if (isset($_GET['id_profesor'])) {
    $id_profesor = intval($_GET['id_profesor']); // Validar como entero para evitar inyecciones SQL

    // Consultar clases activas del profesor seleccionado
    $sql = "SELECT * FROM clases WHERE profesor_id = ? AND estado = 'Activa'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_profesor);
    mysqli_stmt_execute($stmt);
    $resultado_clases = mysqli_stmt_get_result($stmt);

    while ($clase = mysqli_fetch_assoc($resultado_clases)) {
        $id_clase = $clase['id_clase'];

        // Consultar horarios asociados a la clase
        $sql_horarios = "SELECT dia, hora_inicio, hora_fin FROM horarios WHERE id_clase = ?";
        $stmt_horarios = mysqli_prepare($conexion, $sql_horarios);
        mysqli_stmt_bind_param($stmt_horarios, "i", $id_clase);
        mysqli_stmt_execute($stmt_horarios);
        $resultado_horarios = mysqli_stmt_get_result($stmt_horarios);

        $clase['horarios'] = [];
        while ($horario = mysqli_fetch_assoc($resultado_horarios)) {
            $clase['horarios'][] = $horario;
        }

        $clases_con_horarios[] = $clase;
    }

    // Obtener nombre del profesor
    $sql_prof = "SELECT Nombre_Completo, titulo_profesional FROM usuarios WHERE id = ?";
$stmt_prof = mysqli_prepare($conexion, $sql_prof);
mysqli_stmt_bind_param($stmt_prof, "i", $id_profesor);
mysqli_stmt_execute($stmt_prof);
$res_prof = mysqli_stmt_get_result($stmt_prof);
$profesor = mysqli_fetch_assoc($res_prof);
} else {
    // Mostrar todos los profesores que han publicado clases
    $sql = "SELECT DISTINCT u.id AS profesor_id, u.Nombre_Completo, u.titulo_profesional
        FROM usuarios u
        JOIN clases c ON c.profesor_id = u.id
        WHERE c.estado = 'Activa'";


    // Preparar y ejecutar la consulta
    $stmt_profesores = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($stmt_profesores);
    $resultado_profesores = mysqli_stmt_get_result($stmt_profesores);

    // Obtener los profesores
    $profesores = [];
    while ($profesor = mysqli_fetch_assoc($resultado_profesores)) {
        $profesores[] = $profesor;
    }
}
?>
