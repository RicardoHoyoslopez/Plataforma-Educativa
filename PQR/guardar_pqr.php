<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $tipo = $_POST['tipo'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];
    $fecha_creacion = $_POST['fecha_creacion'] . ' 00:00:00'; // ← Usamos la fecha del usuario
    $estado = 'Abierto';
     if (!isset($_POST['fecha_creacion']) || empty($_POST['fecha_creacion'])) {
        die("Error: La fecha de creación no fue enviada.");
    }

    $stmt = $conexion->prepare("INSERT INTO pqrs (id_usuario, tipo, asunto, descripcion, fecha_creacion, estado) 
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_usuario, $tipo, $asunto, $descripcion, $fecha_creacion, $estado);

    if ($stmt->execute()) {
        if ($_SESSION['rol_id'] == 2) {
            header("Location: ../dashboard/paginaprincipale.php?pqrs=enviado");
        } elseif ($_SESSION['rol_id'] == 3) {
            header("Location: ../docente/perfil_profesor.php?pqrs=enviado");
        } else {
            header("Location: ../index.php?pqrs=enviado");
        }
        exit();
    }

    $stmt->close();
    $conexion->close();
}