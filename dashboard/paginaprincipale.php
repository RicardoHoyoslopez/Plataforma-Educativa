<?php
session_start(); // Inicia la sesión

// Verifica si el usuario ha iniciado sesión
$usuario_autenticado = isset($_SESSION['usuario']);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plataforma Educativa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <link rel="stylesheet" href="stylee.css">
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
                        <a href="#" class="nav-link text-light">Inicio</a>
                    </li>
                    <li class="nav-item">
                        <a href="clases.php" class="nav-link text-light">Practicas</a>
                    </li>
                    <li class="nav-item">
                        <a href="PaginaProfesor.php" class="nav-link text-light">Profesores</a>
                    </li>
                    <li class="nav-item">
                        <?php if ($usuario_autenticado): ?>
                            <!-- Botón de Cerrar Sesión-------------------------------------------------------- -->
                            <a href="../login/CerrarSesion.php" class="btn btn-light">Cerrar Sesión</a>
                        <?php else: ?>
                            <!-- Botón de Iniciar Sesión------------------------------------------------------ -->
                            <a href="../login/IniciarSesion.php" class="btn btn-light">Iniciar Sesión</a>
                        <?php endif; ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Carousel -->
    <div id="carouselE" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselE" data-bs-slide-to="0" class="active" aria-current="true"
                aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselE" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselE" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="../assets/img/prefesores.jpg" class="d-block w-100" alt="Clases personalizadas">
                <div class="carousel-caption">
                    <h5>Clases personalizadas</h5>
                    <p>Encuentra el profesor ideal y comienza a aprender hoy mismo.</p>
                    <a href="PaginaProfesor.php" class="btn btn-primary mt-3">Encuentra tu profesor</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/formulario.png" class="d-block w-100" alt="Aprende a tu ritmo">
                <div class="carousel-caption">
                    <h5>Aprende a tu ritmo</h5>
                    <p>Clases adaptadas a tus necesidades y horarios.</p>
                    <a href="../Registro/RegistroUsuarios.php" class="btn btn-primary mt-3">Regístrate ahora</a>
                </div>
            </div>
            <div class="carousel-item">
                <img src="../assets/img/puntos.jpg" class="d-block w-100" alt="Sistema de puntos">
                <div class="carousel-caption">
                    <h5>Sistema de puntos</h5>
                    <p>Gana puntos por cada clase y canjéalos por descuentos.</p>
                    <a href="#" class="btn btn-primary mt-3">Más información</a>
                </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselE" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Anterior</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselE" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Siguiente</span>
        </button>
    </div>

    <!-- Sección de Clases -->
    <section class="classes section-padding">
        <div class="container">
            <div class="row">
                <!-- Clase de Inglés -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="class-card">
                        <img src="../assets/img/ingles.jpg" alt="Clase de Inglés" class="class-img">
                        <h3 class="class-title">Inglés</h3>
                        <p class="class-description">
                            Mejora tu nivel de inglés con clases personalizadas. Aprende gramática, vocabulario y conversación.
                        </p>
                        <a href="#" class="class-btn">Más información</a>
                    </div>
                </div>
                <!-- Clase de Matemáticas -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="class-card">
                        <img src="../assets/img/matematicas.jpeg" alt="Clase de Matemáticas" class="class-img">
                        <h3 class="class-title">Matemáticas</h3>
                        <p class="class-description">
                            Domina las matemáticas con clases adaptadas a tu nivel. Álgebra, cálculo, geometría y más.
                        </p>
                        <a href="#" class="class-btn">Más información</a>
                    </div>
                </div>
                <!-- Clase de Programación -->
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="class-card">
                        <img src="../assets/img/programacion.jpg" alt="Clase de Programación" class="class-img">
                        <h3 class="class-title">Programación</h3>
                        <p class="class-description">
                            Aprende a programar desde cero. Python, JavaScript, desarrollo web y más.
                        </p>
                        <a href="#" class="class-btn">Más información</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="about-section section-padding">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 col-md-12 col-12">
                    <div class="about-img">
                        <img src="../assets/img/nosotros.jpg" class="img-fluid" alt="Sobre nosotros">
                    </div>
                </div>
                <div class="col-lg-8 col-md-12 ps-lg-5 mt-md-5">
                    <div class="about-text text-black">
                        <h2>Sobre nuestra plataforma</h2>
                        <p>
                            Creemos que cada persona tiene un potencial único y que la educación debe adaptarse a las necesidades individuales para desbloquearlo. Somos una plataforma educativa innovadora que conecta a estudiantes con profesores expertos en diversas materias, ofreciendo clases personalizadas y flexibles que se ajustan a tu ritmo de vida.
                        </p>
                        <a href="#" class="btn btn-primary">Más información</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="services section-padding mb-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-header text-center text-white pb-5">
                        <h2>Nuestros servicios</h2>
                        <p>
                            Descubre cómo nuestra plataforma puede ayudarte a alcanzar tus metas de aprendizaje.
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-person-plus"></i>
                            <h3 class="card-title">Regístrate</h3>
                            <p class="lead">
                                Regístrate y comienza a aprender con los mejores profesores.
                            </p>
                            <button class="btn bg-primary text-white">Más información</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-book"></i>
                            <h3 class="card-title">Clases Personalizadas</h3>
                            <p class="lead">
                                Clases adaptadas a tus necesidades y horarios.
                            </p>
                            <button class="btn bg-primary text-white">Más información</button>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card text-white text-center bg-dark pb-2">
                        <div class="card-body">
                            <i class="bi bi-star"></i>
                            <h3 class="card-title">Sistema de Puntos</h3>
                            <p class="lead">
                                Gana puntos por cada clase y canjéalos por descuentos.
                            </p>
                            <button class="btn bg-primary text-white">Más información</button>
                        </div>
                    </div>
                </div>
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
</body>

</html>