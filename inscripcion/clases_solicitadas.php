<?php
session_start();
require '../includes/Conexion.php';
require '../inscripcion/obtener_clases.php';

$conexion = conectarBD(); 

// Verifica si el usuario está autenticado y es cliente
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol'] !== 'Cliente') {
    header("Location: ../login/Index.php");
    exit;
}

$id_usuario = $_SESSION['usuario_id'];
$resultado = obtenerClasesSolicitadas($conexion, $id_usuario);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Clases solicitadas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">📚 Tus Clases Solicitadas</h4>
            </div>
            <div class="card-body">

                <?php if ($resultado->num_rows > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-light">
                                <tr>
                                    <th>Clase</th>
                                    <th>Profesor</th>
                                    <th>Fecha de inscripción</th>
                                    <th>Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($fila = $resultado->fetch_assoc()): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($fila['clase']); ?></td>
                                        <td><?php echo htmlspecialchars($fila['profesor']); ?></td>

                                        <td><?php echo date('d/m/Y', strtotime($fila['fecha_inscripcion'])); ?></td>
                                        <td>
                                            <?php
                                                if ($fila['estado'] === 'Activa') {
                                                    echo '<span class="badge bg-warning text-dark">⏳ Pendiente</span>';
                                                } elseif ($fila['estado'] === 'Aprobada') {
                                                    echo '<span class="badge bg-success">✅ Aprobada</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($fila['estado']) . '</span>';
                                                }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    </div>
                <?php else: ?>
                    <div class="alert alert-info text-center" role="alert">
                        No has solicitado clases aún. ¡Explora el catálogo y anótate!
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</body>
</html>
