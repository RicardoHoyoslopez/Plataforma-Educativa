<?php
session_start(); // Inicia la sesión para acceder a las variables de sesión
require '../includes/Conexion.php'; // Incluye el archivo de conexión a la base de datos

$conexion = conectarBD(); // Establece la conexión con la base de datos

/**
 * Verifica que el usuario tenga rol de estudiante (rol_id = 2)
 * Redirige al login si no tiene permiso
 */
function verificarAccesoEstudiante() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 2) {
        header("Location: ../login/Index.php?error=Acceso denegado");
        exit();
    }
}

/**
 * Obtiene todas las clases activas de un profesor específico, junto con sus horarios
 * @param mysqli $conexion - conexión activa a la BD
 * @param int $id_profesor - ID del profesor
 * @return array - lista de clases con sus horarios
 */
function obtenerClasesConHorarios($conexion, $id_profesor) {
    $clases_con_horarios = [];

    // Consulta las clases activas del profesor
    $sql = "SELECT * FROM clases WHERE profesor_id = ? AND estado = 'Activa'";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_profesor);
    mysqli_stmt_execute($stmt);
    $resultado_clases = mysqli_stmt_get_result($stmt);

    // Para cada clase, se obtienen los horarios asociados
    while ($clase = mysqli_fetch_assoc($resultado_clases)) {
        $id_clase = $clase['id_clase'];
        $clase['horarios'] = obtenerHorariosClase($conexion, $id_clase); // Agrega los horarios a la clase
        $clases_con_horarios[] = $clase;
    }

    return $clases_con_horarios;
}

/**
 * Obtiene los horarios de una clase específica
 * @param mysqli $conexion - conexión activa a la BD
 * @param int $id_clase - ID de la clase
 * @return array - horarios (día, hora_inicio, hora_fin)
 */
function obtenerHorariosClase($conexion, $id_clase) {
    $horarios = [];

    $sql = "SELECT dia, hora_inicio, hora_fin FROM horarios WHERE id_clase = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_clase);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    while ($horario = mysqli_fetch_assoc($resultado)) {
        $horarios[] = $horario;
    }

    return $horarios;
}

/**
 * Obtiene la información básica del profesor (nombre y título)
 * @param mysqli $conexion - conexión activa a la BD
 * @param int $id_profesor - ID del profesor
 * @return array|null - datos del profesor o null si no se encuentra
 */
function obtenerProfesor($conexion, $id_profesor) {
    $sql = "SELECT Nombre_Completo, titulo_profesional FROM usuarios WHERE id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $id_profesor);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultado);
}

/**
 * Obtiene una lista de todos los profesores que tienen clases activas
 * @param mysqli $conexion - conexión activa a la BD
 * @return array - lista de profesores con nombre y título
 */
function obtenerProfesoresConClases($conexion) {
    $profesores = [];

    $sql = "SELECT DISTINCT u.id AS profesor_id, u.Nombre_Completo, u.titulo_profesional, u.experiencia_laboral
            FROM usuarios u
            JOIN clases c ON c.profesor_id = u.id
            WHERE c.estado = 'Activa'";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    while ($profesor = mysqli_fetch_assoc($resultado)) {
        $profesores[] = $profesor;
    }

    return $profesores;
}


// — EJECUCIÓN PRINCIPAL —

verificarAccesoEstudiante(); // Verifica que el usuario sea un estudiante válido

// Inicializa las variables a usar
$clases_con_horarios = [];
$profesor = null;
$profesores = null;

// Si se ha seleccionado un profesor, se cargan sus clases y datos
if (isset($_GET['id_profesor'])) {
    $id_profesor = intval($_GET['id_profesor']); // Sanear la entrada
    $clases_con_horarios = obtenerClasesConHorarios($conexion, $id_profesor);
    $profesor = obtenerProfesor($conexion, $id_profesor);
} else {
    // Si no hay profesor seleccionado, se cargan todos los profesores con clases activas
    $profesores = obtenerProfesoresConClases($conexion);
}
?>
