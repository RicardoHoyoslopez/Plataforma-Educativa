<?php
session_start();
require '../includes/Conexion.php';

function registrarEnClase($conexion, $id_usuario, $id_clase) {
    // Verificar inscripción previa
    $sql_verificar = "SELECT 1 FROM inscripciones WHERE id_usuario = ? AND id_clase = ?";
    $stmt = $conexion->prepare($sql_verificar);
    $stmt->bind_param("ii", $id_usuario, $id_clase);
    $stmt->execute();
    $stmt->store_result();
    
    if ($stmt->num_rows > 0) {
        return ["success" => false, "message" => "Ya estás inscrito en esta clase."];
    }

    // Valores por defecto
    $estado = "Pendiente";
    $puntos = 0;
    $calificacion = null;
    $comentario = null;

    $sql_insert = "INSERT INTO inscripciones (id_usuario, id_clase, estado, puntos_obtenidos, calificacion_docente, comentario) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql_insert);
    $stmt->bind_param("iissss", $id_usuario, $id_clase, $estado, $puntos, $calificacion, $comentario);

    if ($stmt->execute()) {
        return ["success" => true, "message" => "Te has inscrito exitosamente a la clase."];
    } else {
        return ["success" => false, "message" => "Ocurrió un error al registrar tu inscripción."];
    }
}

// Procesar POST del formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['usuario_id'])) {
        header('Location: ../auth/login.php');
        exit;
    }

    $conexion = conectarBD();
    $id_usuario = $_SESSION['usuario_id'];
    $id_clase = intval($_POST['id_clase']);

    $resultado = registrarEnClase($conexion, $id_usuario, $id_clase);
    
    // Guardar resultado en sesión
    $_SESSION['inscripcion_resultado'] = $resultado;
    $_SESSION['inscripcion_id_clase'] = $id_clase;
    
    // Redirigir sin parámetros en URL
    header("Location: ../dashboard/paginaprincipale.php");
    exit;
}