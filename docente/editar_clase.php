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

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Clase</title>
    <!-- Agregar enlace a Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
</head>

<body>

<div class="container">
    <div class="form-container">
        <h2 class="text-center">Editar Clase</h2>
        <form method="POST" action="procesar_edicion.php">
            <input type="hidden" name="id" value="<?php echo $clase['id_clase']; ?>">

            <div class="mb-3">
                <label class="form-label" for="titulo">Título:</label>
                <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($clase['titulo']); ?>" required>
            </div>

            <div class="mb-3">
                <label class="form-label" for="descripcion">Descripción:</label>
                <textarea id="descripcion" name="descripcion" class="form-control" required><?php echo htmlspecialchars($clase['descripcion']); ?></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label" for="estado">Estado:</label>
                <textarea id="estado" name="estado" class="form-control" required><?php echo htmlspecialchars($clase['estado']); ?></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar cambios</button>
        </form>
    </div>
</div>

<!-- Agregar enlace a los scripts de Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
