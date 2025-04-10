<?php
session_start();
require '../includes/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $estado = "Activa";


    // Convertir fecha de creación al formato correcto
    $fecha_creacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));

    $dia = $_POST['dia'];
    $hora_inicio = $_POST['hora_inicio'];
    $hora_fin = $_POST['hora_fin'];

    $profesor_id = $_SESSION['usuario_id'];

    // Insertar clase
    $sql_clase = "INSERT INTO clases (titulo, descripcion, fecha_creacion, estado, profesor_id) VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql_clase);
    mysqli_stmt_bind_param($stmt, "ssssi", $titulo, $descripcion, $fecha_creacion, $estado, $profesor_id);
    mysqli_stmt_execute($stmt);

    // Obtener el ID de la clase insertada
    $id_clase = mysqli_insert_id($conexion);

    // Insertar horario relacionado con la clase
    $sql_horario = "INSERT INTO horarios (id_clase, dia, hora_inicio, hora_fin) VALUES (?, ?, ?, ?)";
    $stmt2 = mysqli_prepare($conexion, $sql_horario);
    mysqli_stmt_bind_param($stmt2, "isss", $id_clase, $dia, $hora_inicio, $hora_fin);
    mysqli_stmt_execute($stmt2);

    header("Location: perfil_profesor.php?mensaje=Clase creada exitosamente");
    exit();
}
?>
