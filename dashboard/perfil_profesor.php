<?php
session_start(); // Inicia la sesión (si es necesario)
require '../includes/Conexion.php'; // Asegúrate de que la ruta sea correcta

// Verificar si se ha proporcionado un ID de profesor
if (!isset($_GET['id'])) {
    header("Location: PaginaProfesor.php");
    exit();
}

$profesor_id = $_GET['id'];

// Consulta para obtener los datos del profesor
$sql = "SELECT * FROM usuarios WHERE id = ? AND rol_id = 3"; // Solo profesores
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $profesor_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($profesor = mysqli_fetch_assoc($result)) {
    // Mostrar los datos del profesor
} else {
    header("Location: PaginaProfesor.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfil de Profesor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css"> <!-- Asegúrate de que la ruta sea correcta -->
</head>

<body>
    <!-- Navbar (igual que en PaginaProfesor.php) -->
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
                        <a href="../index.php" class="nav-link text-light">Inicio</a>
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
    <section class="perfil-section section-padding">
        <div class="container">
            <h2 class="text-center mb-5">Perfil de <?= htmlspecialchars($profesor['Nombre_Completo']) ?></h2>
            <div class="row">
                <div class="col-md-6">
                    <img src="../assets/img/profesor.jpg" class="img-fluid rounded" alt="Foto de perfil">
                </div>
                <div class="col-md-6">
                    <h3>Información Personal</h3>
                    <p>
                        <strong>Usuario:</strong> <?= htmlspecialchars($profesor['Usuario']) ?><br>
                        <strong>Email:</strong> <?= htmlspecialchars($profesor['Email']) ?><br>
                        <strong>Teléfono:</strong> <?= htmlspecialchars($profesor['Telefono']) ?><br>
                        <strong>Dirección:</strong> <?= htmlspecialchars($profesor['Direccion']) ?>
                    </p>
                    <h3>Biografía</h3>
                    <p>
                        <?= htmlspecialchars($profesor['biografia'] ?? 'No hay biografía disponible.') ?>
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer (igual que en PaginaProfesor.php) -->
    <footer class="bg-dark text-white text-center p-3 mt-auto"> <!-- Agregada clase mt-auto -->
    <div class="container">
        <p>&copy; 2025 Plataforma Educativa. Todos los derechos reservados.</p>
        <p class="mb-5"> 
            <a href="#" class="text-white text-decoration-none">Política de Privacidad</a> | 
            <a href="#" class="text-white text-decoration-none">Términos y Condiciones</a>
        </p>
        <div class="social-links">
            <a href="#" class="text-white me-3"><i class="fab fa-facebook-f"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-twitter"></i></a>
            <a href="#" class="text-white me-3"><i class="fab fa-instagram"></i></a>
        </div>
    </div>
</footer>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>