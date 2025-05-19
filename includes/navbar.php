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
                    <a href="../dashboard/paginaprincipale.php" class="nav-link text-light">Inicio</a>
                </li>
                <li class="nav-item">
                    <a href="../dashboard/clases.php" class="nav-link text-light">Clases</a>
                </li>
                <li class="nav-item">
                    <a href="../docente/PaginaProfesor.php" class="nav-link text-light">Profesores</a>
                </li>

                <li class="nav-item">
                    <a href="../inscripcion/clases_solicitadas.php" class="nav-link text-light">Clases solicitadas</a>
                </li>



                <?php if (isset($_SESSION['usuario_id'])): ?>
                    <!-- Menú desplegable con nombre del usuario -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-light" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle"></i> <?php echo $_SESSION['nombre_completo']; ?>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <!-- Opción para realizar PQR -->
                            <li>
                                <a class="dropdown-item" href="../PQR/formulario_pqr.php">
                                    <i class="bi bi-envelope-check"></i> Realizar PQR
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- Cerrar sesión -->
                            <li>
                                <a class="dropdown-item text-danger" href="../login/CerrarSesion.php">
                                    <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>
                <?php else: ?>
                    <!-- Botón para iniciar sesión -->
                    <li class="nav-item">
                        <a class="btn btn-light btn-sm" href="../login/IniciarSesion.php">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar sesión
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>