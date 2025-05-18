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
    echo "<script>alert('PQR enviada correctamente');</script>";
    // direccionamiento segun el rol
    if ($_SESSION['rol_id'] == 2) {
        echo "<script>window.location.href = '../dashboard/paginaprincipale.php';</script>";
    } elseif ($_SESSION['rol_id'] == 3) {
        echo "<script>window.location.href = '../docente/perfil_profesor.php';</script>";
    } else {
        echo "<script>window.location.href = '../index.php';</script>"; 
    }
}


    $stmt->close();
    $conexion->close();
}
?>
