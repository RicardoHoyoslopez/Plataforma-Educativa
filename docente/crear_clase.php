<?php
session_start();
require '../includes/Conexion.php';

$conexion = conectarBD();

/*
 * Inserta una nueva clase en la base de datos y devuelve el ID generado.
 */
function insertarClase($conexion, $titulo, $descripcion, $fecha_creacion, $estado, $precio, $profesor_id)
{
    $sql = "INSERT INTO clases (titulo, descripcion, fecha_creacion, estado, precio, profesor_id) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ssssdi", $titulo, $descripcion, $fecha_creacion, $estado, $precio, $profesor_id);
    mysqli_stmt_execute($stmt);
    return mysqli_insert_id($conexion);
}

/*
 * Inserta el horario asociado a una clase.
 */
function insertarHorario($conexion, $id_clase, $dia)
{
    $sql = "INSERT INTO horarios (id_clase, dia) VALUES (?, ?)";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "is", $id_clase, $dia);
    mysqli_stmt_execute($stmt);
}

// Procesa el formulario al enviarse vía POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $titulo = trim($_POST['titulo']);
    $descripcion = trim($_POST['descripcion']);
    $fecha_creacion = date('Y-m-d H:i:s', strtotime($_POST['fecha_creacion']));
    $estado = "Activa";
    $precio = floatval($_POST['precio']);
    $dia = $_POST['dia'];
    $profesor_id = $_SESSION['usuario_id'];

    // Inserta la clase y luego el horario correspondiente
    $id_clase = insertarClase($conexion, $titulo, $descripcion, $fecha_creacion, $estado, $precio, $profesor_id);
    insertarHorario($conexion, $id_clase, $dia);

    // Redirige al perfil del profesor con confirmación
    header("Location: perfil_profesor.php?creado=1");
    exit();
}
