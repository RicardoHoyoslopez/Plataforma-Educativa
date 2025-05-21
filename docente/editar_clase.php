<?php
session_start();
require '../includes/Conexion.php';

$conexion = conectarBD();

/**
 * Verifica que exista el parámetro 'id' en la URL.
 */
function verificarId() {
    if (!isset($_GET['id'])) {
        header("Location: perfil_profesor.php?error=ID inválido");
        exit();
    }
    return intval($_GET['id']);
}

/**
 * Obtiene la información de la clase si pertenece al docente.
 */
function obtenerClase($conexion, $id_clase, $docente_id) {
    $sql = "SELECT * FROM clases WHERE id_clase = ? AND profesor_id = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_clase, $docente_id);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultado);
}

// --- Ejecución principal ---
$id = verificarId();
$docente_id = $_SESSION['usuario_id'];

$clase = obtenerClase($conexion, $id, $docente_id);

if (!$clase) {
    header("Location: perfil_profesor.php?error=Clase no encontrada");
    exit();
}
?>

<!-- Formulario para editar la clase con Bootstrap -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

<form method="POST" action="procesar_edicion.php" class="container mt-4" style="max-width: 600px;">
    <input type="hidden" name="id" value="<?php echo $clase['id_clase']; ?>">

    <div class="mb-3">
        <label for="titulo" class="form-label">Título:</label>
        <input type="text" id="titulo" name="titulo" class="form-control" value="<?php echo htmlspecialchars($clase['titulo']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="descripcion" class="form-label">Descripción:</label>
        <textarea id="descripcion" name="descripcion" class="form-control" rows="4" required><?php echo htmlspecialchars($clase['descripcion']); ?></textarea>
    </div>

    <div class="mb-3">
        <label for="estado" class="form-label">Estado:</label>
        <input type="text" id="estado" name="estado" class="form-control" value="<?php echo htmlspecialchars($clase['estado']); ?>" required>
    </div>

    <div class="mb-3">
        <label for="precio" class="form-label">Precio:</label>
        <input type="number" id="precio" name="precio" step="0.01" class="form-control" value="<?php echo htmlspecialchars($clase['precio']); ?>" required>
    </div>

    <button type="submit" class="btn btn-primary">Guardar cambios</button>
</form>
