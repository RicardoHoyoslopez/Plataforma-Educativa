<?php
session_start(); // Inicia la sesión (si es necesario)
require '../includes/Conexion.php'; // Asegúrate de que la ruta sea correcta

// Consulta para obtener las materias con información del profesor
$sql = "SELECT materias.id, materias.nombre, materias.descripcion, usuarios.Nombre_Completo AS profesor 
        FROM materias 
        LEFT JOIN usuarios ON materias.profesor_id = usuarios.id
        WHERE materias.estado = 'activo'"; // Solo materias activas
$result = mysqli_query($conexion, $sql);
// Verificar si hay resultados
if (!$result) {
    die("Error al obtener las materias: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>

<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary fixed-top">
        <div class="container">
            <a href="#" class="navbar-brand">
                <span class="text-light border-box">Educardo</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarS"
                aria-controls="navbarS" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarS">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a href="paginaprincipale.php" class="nav-link text-light">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="clases.php" class="nav-link text-light">Prácticas</a>
                    </li>
                    <li class="nav-item">
                        <a href="PaginaProfesor.php" class="nav-link text-light">Profesores</a>
                    </li>
                    <li class="nav-item">
                        <?php if (isset($_SESSION['usuario'])): ?>
                            <a href="../login/cerrar_sesion.php" class="btn btn-light">Cerrar Sesión</a>
                        <?php else: ?>
                            <a href="../login/IniciarSesion.php" class="btn btn-light">Iniciar Sesión</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <section class="materias-section section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Materias Disponibles</h2>
            <div class="row">
                <?php while ($materia = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($materia['nombre']) ?></h5>
                                <p class="card-text">
                                    <strong>Descripción:</strong> <?= htmlspecialchars($materia['descripcion']) ?><br>
                                    <strong>Profesor:</strong> <?= htmlspecialchars($materia['profesor']) ?>
                                </p>
                                <a href="detalle_materia.php?id=<?= $materia['id'] ?>" class="btn btn-primary">Ver detalles</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center p-3">
        <div class="container">
            <p>&copy; 2025 Plataforma Educativa. Todos los derechos reservados.</p>
            <p>
                <a href="#" class="text-white">Política de Privacidad</a> | 
                <a href="#" class="text-white">Términos y Condiciones</a>
            </p>
            <div class="social-links">
                <a href="#" class="text-white me-3"><i class="bi bi-facebook"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-twitter"></i></a>
                <a href="#" class="text-white me-3"><i class="bi bi-instagram"></i></a>
            </div>
        </div>
    </footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>