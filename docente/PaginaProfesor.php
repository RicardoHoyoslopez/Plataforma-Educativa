<?php
session_start(); // Inicia la sesión 
require '../includes/Conexion.php'; // Conecion base de datos
$conexion = conectarBD();

// Consulta para obtener los profesores
$sql = "SELECT * FROM usuarios WHERE rol_id = 3"; // el rol_id de los profesores es 3
$result = mysqli_query($conexion, $sql);

// Verificar si hay resultados
if (!$result) {
    die("Error al obtener los datos de los profesores: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Perfiles de Profesores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css"> 
</head>

<body>
    <!-- aqui comienza el navbar -------------------------------------------------------------------------------------------------->
        <?php include '../includes/navbar.php'; ?> <!-- ruta del navbar -->

    <!-- Contenido mostrado en informacion de docente traido desde la base de datos---------------------------------  -->
    <section class="profesores-section section-padding">
        <div class="container">
            <h2 class="text-center mb-4">Perfiles de Profesores</h2>
            <div class="row">
                <?php while ($profesor = mysqli_fetch_assoc($result)): ?>
                    <div class="col-md-3 mb-3">
                        <div class="card h-100">
                            <img src="../assets/img/perfil.jpg" class="card-img-top" alt="Foto de perfil">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($profesor['Nombre_Completo']) ?></h5>
                                <p class="card-text">
                                    <strong>Profesion:</strong> <?= htmlspecialchars($profesor['titulo_profesional']) ?><br>
                                    <strong>Email:</strong> <?= htmlspecialchars($profesor['Email']) ?><br>
                                    <strong>Teléfono:</strong> <?= htmlspecialchars($profesor['Telefono']) ?><br>
                                    <strong>Experiencia:</strong> <?= htmlspecialchars($profesor['experiencia_laboral']) ?>
                                </p>
                                <a href="#" class="btn btn-primary">Ver perfil completo</a>
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