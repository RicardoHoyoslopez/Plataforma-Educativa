<?php
function obtenerClasesSolicitadas($conexion, $id_usuario) {
    $sql = "SELECT c.titulo AS clase, i.fecha_inscripcion, i.estado,
                   u.Nombre_completo AS profesor
            FROM inscripciones i
            JOIN clases c ON i.id_clase = c.id_clase
            JOIN usuarios u ON c.profesor_id = u.id
            WHERE i.id_usuario = ?";

    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    return $stmt->get_result();
}

