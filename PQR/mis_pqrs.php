<?php
session_start();
// Establecer la zona horaria correcta (ej: Bogotá)
date_default_timezone_set('America/Bogota');  // Ajusta según tu ubicación
require '../includes/conexion.php';
$conexion = conectarBD();


$id_docente = $_SESSION['usuario_id']; // Asegúrate de que este valor esté en sesión

$sql = "SELECT id_pqrs, asunto, descripcion, 
               DATE_FORMAT(fecha_creacion, '%d/%m/%Y') AS fecha_creacion,  -- Solo día/mes/año
               estado, 
               IFNULL(DATE_FORMAT(fecha_resolucion, '%d/%m/%Y'), 'Pendiente') AS fecha_resolucion, 
               solucion
        FROM pqrs
        WHERE id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_docente);
$stmt->execute();
$resultado = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Mis PQRS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>


<body class="bg-light">

    <div class="container mt-5">
        <h2 class="mb-4 text-primary">Mis PQRS</h2>

        <?php if ($resultado->num_rows > 0): ?>
            <div class="table-responsive">
                <table class="table table-bordered bg-white shadow text-center">
                    <thead class="table-primary">
                        <tr>
                            <th>Asunto</th>
                            <th>Descripción</th>
                            <th>Fecha de Creación</th>
                            <th>Fecha de Resolución</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $resultado->fetch_assoc()): ?>
                            <tr>
                                <td><?= htmlspecialchars($row['asunto']) ?></td>
                                <td><?= nl2br(htmlspecialchars($row['descripcion'])) ?></td>
                                <td><?= $row['fecha_creacion'] ?></td>
                                <td><?= $row['fecha_resolucion'] ?></td>
                                <td>
                                    <span class="badge bg-<?= $row['estado'] == 'Resuelto' ? 'success' : ($row['estado'] == 'No resuelto' ? 'danger' : 'warning') ?>">
                                        <?= htmlspecialchars($row['estado']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                        <a href="actualizar_estado_pqrs.php?id=<?= $row['id_pqrs'] ?>&estado=Resuelto" class="btn btn-success btn-sm">
                                            <i class="bi bi-check-circle"></i> Resuelta
                                        </a>
                                        <a href="actualizar_estado_pqrs.php?id=<?= $row['id_pqrs'] ?>&estado=No%20resuelto" class="btn btn-danger btn-sm">
                                            <i class="bi bi-x-circle"></i> No resuelta
                                        </a>
                                        <a href="eliminar_pqr.php?id=<?= $row['id_pqrs'] ?>" class="btn btn-sm btn-danger"
                                            onclick="return confirm('¿Eliminar esta pqr?');">
                                            <i class="bi bi-trash3-fill"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="alert alert-info text-center" role="alert">
                <i class="bi bi-info-circle-fill"></i> No has realizado ninguna PQR.
            </div>
        <?php endif; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    

</body>

</html>