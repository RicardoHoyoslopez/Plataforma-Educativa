<?php
session_start();
require '../includes/Conexion.php';

if (!isset($_GET['id'])) {
    header("Location: perfil_profesor.php?error=ID inválido");
    exit();
}

$id = intval($_GET['id']);
$docente_id = $_SESSION['usuario_id'];

$sql = "SELECT * FROM clases WHERE id_clase = ? AND profesor_id = ?";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id, $docente_id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
$clase = mysqli_fetch_assoc($resultado);

if (!$clase) {
    header("Location: perfil_profesor.php?error=Clase no encontrada");
    exit();
}
?>


<form method="POST" action="procesar_edicion.php">
    <input type="hidden" name="id" value="<?php echo $clase['id_clase']; ?>">
    <label>Título:</label>
    <input type="text" name="titulo" value="<?php echo htmlspecialchars($clase['titulo']); ?>" required>
    <br>
    <label>Descripción:</label>
    <textarea name="descripcion" required><?php echo htmlspecialchars($clase['descripcion']); ?></textarea>
    <br>
    <label>Estado:</label>
    <textarea name="estado" required><?php echo htmlspecialchars($clase['estado']); ?></textarea>
    ><br>
    <button type="submit">Guardar cambios</button>
</form>
