<?php
require '../docente/controlador_profesor.php';
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Perfil del Docente</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a class="navbar-brand" href="PaginaProfesor.php">
                <i class="bi bi-mortarboard-fill"></i> Educardo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarDocente">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarDocente">
                <form class="d-flex me-auto" role="search" action="buscar_clases.php" method="GET">
                    <input class="form-control me-2" type="search" name="q" placeholder="Buscar clases..." aria-label="Buscar">
                    <button class="btn btn-outline-light" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link text-light" href="PaginaProfesor.php"><i class="bi bi-house-door-fill"></i> Inicio</a></li>
                    <li class="nav-item"><a class="nav-link text-light" href="pqrs.php"><i class="bi bi-question-circle-fill"></i> PQRS</a></li>
                    <?php if (isset($_SESSION['usuario_id'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle"></i> <?php echo $_SESSION['nombre_completo']; ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li class="dropdown-item text-muted"><i class="bi bi-person-badge-fill"></i> Docente</li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item text-danger" href="../login/CerrarSesion.php"><i class="bi bi-box-arrow-right"></i> Cerrar Sesión</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5 pt-5">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2 class="text-primary"><i class="bi bi-journal-text"></i> Tus Clases</h2>
            <a href="fcrear_clase.php" class="btn btn-success"><i class="bi bi-plus-circle"></i> Crear nueva clase</a>
        </div>

        <div class="table-responsive">
            <table class="table table-bordered bg-white shadow">
                <thead class="table-primary text-center">
                    <tr>
                        <th>Clase</th>
                        <th>Descripción</th>
                        <th>Fecha de Creación</th>
                        <th>Día</th>
                        <th>Hora de Inicio</th>
                        <th>Hora de Fin</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($clase = mysqli_fetch_assoc($resultado)): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($clase['titulo']); ?></td>
                            <td><?php echo nl2br(htmlspecialchars($clase['descripcion'])); ?></td>
                            <td><?php echo htmlspecialchars(date('Y-m-d', strtotime($clase['fecha_creacion']))); ?></td>
                            <td><?php echo htmlspecialchars($clase['dia']); ?></td>
                            <td><?php echo htmlspecialchars($clase['hora_inicio']); ?></td>
                            <td><?php echo htmlspecialchars($clase['hora_fin']); ?></td>
                            <td>
                                <span class="badge bg-<?php echo strtolower($clase['estado']) === 'activo' ? 'success' : 'secondary'; ?>">
                                    <?php echo htmlspecialchars($clase['estado']); ?>
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="d-flex justify-content-center">
                                    <a href="editar_clase.php?id=<?php echo $clase['id_clase']; ?>" class="btn btn-sm btn-warning me-2" title="Editar">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>
                                    <a href="eliminar_clase.php?id=<?php echo $clase['id_clase']; ?>" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm('¿Estás seguro que deseas eliminar esta clase?');">
                                        <i class="bi bi-trash3-fill"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- JS de Bootstrap y SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="alertas.js"></script>

    <!-- Mostrar mensaje de éxito si se creó la clase -->
    
</body>

</html>
