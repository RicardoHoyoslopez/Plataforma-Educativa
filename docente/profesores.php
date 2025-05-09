<?php require 'controlador_profesores.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesores y Clases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        h1, h2 {
            font-weight: bold;
        }

        .table th {
            background-color: #f8f9fa;
        }

        .btn-primary {
            background-color: #198754;
            border: none;
        }

        .btn-primary:hover {
            background-color: #157347;
        }

        .btn-success {
            background-color: #0d6efd;
            border: none;
        }

        .btn-success:hover {
            background-color: #0b5ed7;
        }

        .profesor-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease, background-color 0.2s ease;
            background-color: #f8f9fa;
            border-radius: 12px;
        }

        .profesor-card:hover {
            transform: scale(1.03);
            box-shadow: 0 10px 20px rgba(0, 123, 255, 0.2);
            background: linear-gradient(135deg, #0d6efd 0%, #6f42c1 100%);
            color: white;
        }

        .profesor-card:hover .card-title,
        .profesor-card:hover svg,
        .profesor-card:hover .card-text {
            color: white !important;
        }

        .card-text {
            font-size: 0.95rem;
            color: #6c757d;
        }
    </style>
</head>
<body>
    <div class="container mt-4">
        <h1 class="text-center text-primary mb-4">Profesores Disponibles</h1>

        <?php if ($profesores && count($profesores) > 0): ?>
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                <?php foreach ($profesores as $row): ?>
                    <div class="col">
                        <a href="profesores.php?id_profesor=<?= $row['profesor_id'] ?>" class="text-decoration-none">
                            <div class="card h-100 text-center border-0 shadow-sm profesor-card">
                                <div class="card-body">
                                    <div class="mb-3 text-primary">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" fill="currentColor" class="bi bi-person-circle" viewBox="0 0 16 16">
                                            <path d="M13.468 12.37C12.758 11.226 11.482 10.5 10 10.5H6c-1.482 0-2.758.726-3.468 1.87A6.978 6.978 0 0 0 8 15a6.978 6.978 0 0 0 5.468-2.63z"/>
                                            <path fill-rule="evenodd" d="M8 9a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8 1a7 7 0 1 1 0 14A7 7 0 0 1 8 1z"/>
                                        </svg>
                                    </div>
                                    <h5 class="card-title text-dark"><?= htmlspecialchars($row['Nombre_Completo']) ?></h5>
                                    <p class="card-text">Haz clic para ver sus clases</p>
                                    <p class="card-text"><?= htmlspecialchars($row['titulo_profesional']) ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php endforeach; ?>
            </div>

        <?php elseif ($profesor): ?>
            <h2 class="text-info mb-4">Clases de <?= htmlspecialchars($profesor['Nombre_Completo']) ?></h2>

            <?php if (!empty($clases_con_horarios)): ?>
                <table class="table table-bordered table-hover">
                    <thead class="table-light">
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Horarios</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($clases_con_horarios as $clase): ?>
                            <tr>
                                <td><?= htmlspecialchars($clase['titulo']) ?></td>
                                <td><?= htmlspecialchars($clase['descripcion']) ?></td>
                                <td>
                                    <?php if (!empty($clase['horarios'])): ?>
                                        <ul class="mb-0">
                                            <?php foreach ($clase['horarios'] as $horario): ?>
                                                <li><?= htmlspecialchars($horario['dia']) ?>: <?= substr($horario['hora_inicio'], 0, 5) ?> - <?= substr($horario['hora_fin'], 0, 5) ?></li>
                                            <?php endforeach; ?>
                                        </ul>
                                    <?php else: ?>
                                        <em>Sin horarios registrados</em>
                                    <?php endif; ?>
                                </td>
                                <td><a href="inscripsion.php?id_clase=<?= $clase['id_clase'] ?>" class="btn btn-primary">Inscribirse a clase</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p class="text-muted">Este profesor aún no tiene clases activas.</p>
            <?php endif; ?>

            <p><a href="profesores.php" class="btn btn-success">← Volver a la lista de profesores</a></p>

        <?php else: ?>
            <p class="text-danger">No hay profesores con clases activas por ahora.</p>
        <?php endif; ?>
    </div>
</body>
</html>
