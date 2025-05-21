<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

// 1. Verificar que el usuario es docente (rol_id = 3)
function verificarAccesoDocente() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
        header("Location: ../login/Index.php?error=Acceso denegado");
        exit();
    }
}

// 2. Obtener datos de sesión
function obtenerDatosSesion() {
    return [
        'usuario_id'      => $_SESSION['usuario_id'],
        'nombre_completo' => $_SESSION['nombre_completo'],
    ];
}

// 3. Traer las clases del docente
function obtenerClasesDocente($conexion, $profesor_id) {
    $sql = "SELECT c.id_clase, c.titulo, c.descripcion, c.estado, c.precio, c.fecha_creacion, h.dia, h.hora_inicio, h.hora_fin
            FROM clases c
            JOIN horarios h ON c.id_clase = h.id_clase
            WHERE c.profesor_id = ? AND c.estado = 'activa'
            ORDER BY c.fecha_creacion DESC";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $profesor_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// 4. Traer solicitudes pendientes (fecha + hora completas)
function obtenerSolicitudesPendientes($conexion, $profesor_id) {
    $sql = "SELECT ins.id_inscripcion,
                   u.Nombre_Completo AS cliente,
                   c.titulo         AS clase,
                   DATE_FORMAT(ins.fecha_inscripcion, '%d/%m/%Y %H:%i:%s') AS fecha_solicitud
            FROM inscripciones ins
            JOIN usuarios u ON ins.id_usuario = u.id
            JOIN clases c   ON ins.id_clase   = c.id_clase
            WHERE c.profesor_id = ? AND ins.estado = 'pendiente'
            ORDER BY ins.fecha_inscripcion DESC";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "i", $profesor_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// — EJECUCIÓN —
verificarAccesoDocente();
$datosSesion         = obtenerDatosSesion();
$profesor_id         = $datosSesion['usuario_id'];
$resultado_clases    = obtenerClasesDocente      ($conexion, $profesor_id);
$resultado_solicitudes = obtenerSolicitudesPendientes($conexion, $profesor_id);