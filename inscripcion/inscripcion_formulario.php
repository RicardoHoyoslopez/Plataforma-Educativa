<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header('Location: ../login/index.php');
    exit;
}

// Obtener ID de clase (de GET o de sesión)
$id_clase = isset($_GET['id']) ? intval($_GET['id']) : (isset($_SESSION['inscripcion_id_clase']) ? $_SESSION['inscripcion_id_clase'] : 0);

// Obtener mensaje de resultado (si existe)
$mensaje = null;
$alert_class = 'alert-info';
if (isset($_SESSION['inscripcion_resultado'])) {
    $resultado = $_SESSION['inscripcion_resultado'];
    $mensaje = $resultado['message'];
    $alert_class = $resultado['success'] ? 'alert-success' : 'alert-danger';
    
    // Limpiar los datos de sesión después de usarlos
    unset($_SESSION['inscripcion_resultado']);
    unset($_SESSION['inscripcion_id_clase']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscripción a la Clase</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Formulario de Inscripción</h2>

    <?php if ($mensaje): ?>
        <div class="alert <?= $alert_class ?>"><?= htmlspecialchars($mensaje) ?></div>
    <?php endif; ?>

    <?php if ($id_clase > 0): ?>
        <form method="POST" action="inscripcion_logica.php">
            <input type="hidden" name="id_clase" value="<?= $id_clase ?>">
            <div class="mt-3">
                <button type="submit" class="btn btn-success me-2">Confirmar inscripción</button>
                <a href="clases_disponibles.php" class="btn btn-secondary">Cancelar</a>
            </div>
        </form>
    <?php else: ?>
        <div class="alert alert-warning">No se especificó una clase válida.</div>
        <a href="clases_disponibles.php" class="btn btn-primary mt-2">Volver</a>
    <?php endif; ?>
</div>
</body>
</html>