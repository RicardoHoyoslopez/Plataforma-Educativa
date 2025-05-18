<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $estado = "Activa";
    $fecha_creacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));
    $precio = floatval($_POST['precio']);
    $dia = $_POST['dia'];
    $profesor_id = $_SESSION['usuario_id'];

    // Insertar clase con el nuevo campo de precio
    $sql_clase = "INSERT INTO clases (titulo, descripcion, fecha_creacion, estado, precio, profesor_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql_clase);
    mysqli_stmt_bind_param($stmt, "ssssdi", $titulo, $descripcion, $fecha_creacion, $estado, $precio, $profesor_id);
    mysqli_stmt_execute($stmt);

    // Obtener el ID de la clase insertada
    $id_clase = mysqli_insert_id($conexion);

    // Insertar el día de la clase en la tabla horarios
    $sql_horario = "INSERT INTO horarios (id_clase, dia) VALUES (?, ?)";
    $stmt2 = mysqli_prepare($conexion, $sql_horario);
    mysqli_stmt_bind_param($stmt2, "is", $id_clase, $dia);
    mysqli_stmt_execute($stmt2);

    header("Location: perfil_profesor.php?mensaje=Clase creada exitosamente");
    exit();
}
