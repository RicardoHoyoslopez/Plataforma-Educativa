<?php
session_start();
require '../includes/Conexion.php';

/**
 * Verifica que el usuario esté autenticado y sea docente.
 * Si no cumple, redirige a la página de login y detiene la ejecución.
 */
function verificarAcceso() {
    if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
        header("Location: ../login/Index.php");
        exit;
    }
}

/**
 * Recibe una acción y devuelve el estado correspondiente.
 * Devuelve null si la acción no es válida.
 */
function obtenerNuevoEstado($accion) {
    if ($accion === 'aceptar') {
        return 'Aprobada';
    } elseif ($accion === 'rechazar') {
        return 'Rechazada';
    } else {
        return null;
    }
}

/**
 * Actualiza el estado de una inscripción en la base de datos.
 * Devuelve verdadero si se actualizó correctamente, falso en caso contrario.
 */
function actualizarEstadoInscripcion($conexion, $id_inscripcion, $nuevo_estado) {
    $sql = "UPDATE inscripciones SET estado = ? WHERE id_inscripcion = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("si", $nuevo_estado, $id_inscripcion);
    $stmt->execute();
    return $stmt->affected_rows > 0;
}

// --- Código principal ---

// Comprueba que el usuario tiene acceso permitido
verificarAcceso();

$conexion = conectarBD();

// Valida que existan los parámetros necesarios en la URL
if (isset($_GET['id']) && isset($_GET['accion'])) {
    $id_inscripcion = intval($_GET['id']);
    $accion = $_GET['accion'];

    // Obtiene el nuevo estado según la acción solicitada
    $nuevo_estado = obtenerNuevoEstado($accion);

    // Si la acción no es válida, redirige con mensaje de error
    if (!$nuevo_estado) {
        header("Location: perfil_profesor.php?error=accion_invalida");
        exit;
    }

    // Actualiza el estado en la base de datos y redirige con el resultado
    if (actualizarEstadoInscripcion($conexion, $id_inscripcion, $nuevo_estado)) {
        header("Location: ../docente/perfil_profesor.php?mensaje=estado_actualizado");
    } else {
        header("Location: ../docente/perfil_profesor.php?error=no_actualizado");
    }
} else {
    // Si faltan datos, redirige con error
    header("Location: ../docente/perfil_profesor.php?error=datos_incompletos");
}
?>
