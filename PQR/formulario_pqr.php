<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: ../login/IniciarSesion.php");
    exit;
}
$id_usuario = $_SESSION['usuario_id'];

?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Formulario de PQR</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5">
    <h2>Formulario de PQR</h2>
    <form action="guardar_pqr.php" method="POST">
        <input type="hidden" name="id_usuario" value="<?= $id_usuario ?>">

        <div class="mb-3">
            <label for="tipo" class="form-label">Tipo de PQR:</label>
            <select name="tipo" class="form-select" required>
                <option value="">Seleccione</option>
                <option value="Petición">Petición</option>
                <option value="Queja">Queja</option>
                <option value="Reclamo">Reclamo</option>
                <option value="Sugerencia">Sugerencia</option>
            </select>
        </div>

        <div class="mb-3">
            <label for="asunto" class="form-label">Asunto:</label>
            <input type="text" name="asunto" class="form-control" maxlength="200" required>
        </div>

        <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción:</label>
            <textarea name="descripcion" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Enviar PQR</button>
    </form>
</div>
</body>
</html>
