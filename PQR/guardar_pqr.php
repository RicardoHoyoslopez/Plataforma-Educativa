<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_POST['id_usuario'];
    $tipo = $_POST['tipo'];
    $asunto = $_POST['asunto'];
    $descripcion = $_POST['descripcion'];
    $fecha_creacion = date('Y-m-d H:i:s');
    $estado = 'Abierto';

    $stmt = $conexion->prepare("INSERT INTO pqrs (id_usuario, tipo, asunto, descripcion, fecha_creacion, estado) 
                                VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("isssss", $id_usuario, $tipo, $asunto, $descripcion, $fecha_creacion, $estado);

    if ($stmt->execute()) {
        // Redirigir según el rol con un parámetro en la URL
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
