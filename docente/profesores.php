<?php require 'controlador_profesores.php'; ?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Profesores y Clases</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <h1>Profesores Disponibles</h1>

        <?php if ($profesores && count($profesores) > 0): ?>
            <ul>
                <?php foreach ($profesores as $row): ?>
                    <li>
                        <a href="profesores.php?id_profesor=<?= $row['profesor_id'] ?>"> 
                            <?= htmlspecialchars($row['Nombre_Completo']) ?> 
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>

        <?php elseif ($profesor): ?>
            <h2>Clases de <?= htmlspecialchars($profesor['Nombre_Completo']) ?></h2>

            <?php if (!empty($clases_con_horarios)): ?>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Título</th>
                            <th>Descripción</th>
                            <th>Horarios</th>
                            <th>Accion</th>
                            
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
                                <td><a href="inscripsion.php?id_clase=<?=$clase['id_clase']?>" class="btn btn-primary">Inscribirse a clase</a></td>
                                
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>Este profesor aún no tiene clases activas.</p>
            <?php endif; ?>

            <p><a href="profesores.php" class="btn btn-success">← Volver a la lista de profesores</a></p>

        <?php else: ?>
            <p>No hay profesores con clases activas por ahora.</p>
        <?php endif; ?>
    </div>
</body>
</html>
