<?php
session_start();
require '../includes/Conexion.php';
$conexion = conectarBD();

// Consulta para obtener las clases activas con información del profesor
$sql = "SELECT clases.id_clase, clases.titulo, clases.descripcion, clases.precio, usuarios.Nombre_Completo AS profesor 
        FROM clases 
        LEFT JOIN usuarios ON clases.profesor_id = usuarios.id
        WHERE clases.estado = 'Activa'";
$resultado = mysqli_query($conexion, $sql);

if (!$resultado) {
    die("Error al obtener las clases: " . mysqli_error($conexion));
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clases Disponibles</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

   <!-- Navbar -->
      <?php include '../includes/navbar.php'; ?> <!-- O ajusta la ruta según tu estructura -->
      
  <!-- Mostrar las clases disponibles que estan guardadas en la base de datos     -->
<section class="clases-section section-padding" style="margin-top: 80px;">
    <div class="container">
        <h2 class="text-center mb-5">Clases Disponibles</h2>
        <div class="row">
            <?php if (mysqli_num_rows($resultado) === 0): ?>
                <p class="text-center">No hay clases activas registradas.</p>
            <?php else: ?>
                <?php while ($clases = mysqli_fetch_assoc($resultado)): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($clases['titulo']) ?></h5>
                                <p class="card-text">
                                    <strong>Descripción:</strong> <?= htmlspecialchars($clases['descripcion']) ?><br>
                                    <strong>Profesor:</strong> <?= htmlspecialchars($clases['profesor']) ?><br>
                                    <strong>Valor:</strong> $<?= number_format($clases['precio'], 3, ',', '.') ?>
                                </p>
                                <a href="registro_clase.php?id=<?= $clase['id_clase'] ?>" class="btn btn-success">Registrarse</a>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php endif; ?>
        </div>
    </div>
</section>

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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
