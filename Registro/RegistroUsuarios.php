<?php
require '../includes/Conexion.php';
$conexion = conectarBD();
$query_roles = "SELECT * FROM roles";
$result_roles = mysqli_query($conexion, $query_roles);

// Mostrar errores de sesión si existen
if (isset($_SESSION['error_registro'])) {
    $error = $_SESSION['error_registro'];
    unset($_SESSION['error_registro']);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

<!-- Llamamos los  estilos-->
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Registro de Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <style>
        .error-message {
            color: #dc3545;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f8d7da;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center align-items-stretch">
            <!-- Formulario de registro -->
            <div class="col-lg-6 mb-4 d-flex">
                <div class="card shadow rounded-4 p-4 w-100">
                    <h2 class="text-center mb-4">Registrarse</h2>
                    
                    <?php if (!empty($error)): ?>
                        <div class="error-message text-center">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <form action="logicaregistro.php" method="POST" autocomplete="off" enctype="multipart/form-data">
                        <div class="row">
                            <!-- Columna izquierda -->
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="Nombre_Completo" class="form-control" placeholder="Nombre Completo" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-user"></i></span>
                                    <input type="text" name="Usuario" class="form-control" placeholder="Usuario" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-envelope"></i></span>
                                    <input type="email" name="Email" class="form-control" placeholder="E-mail" required>
                                </div>
                            </div>

                            <!-- Columna derecha -->
                            <div class="col-md-6">
                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-map-marker-alt"></i></span>
                                    <input type="text" name="Direccion" class="form-control" placeholder="Dirección" required>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                    <select name="Rol" class="form-select" required>
                                        <option value="">¿Cómo quieres registrarte?</option>
                                        <?php while ($row = mysqli_fetch_assoc($result_roles)): ?>
                                            <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
                                        <?php endwhile; ?>
                                    </select>
                                </div>

                                <div class="input-group mb-3">
                                    <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                    <input type="text" name="Telefono" class="form-control" placeholder="Teléfono" required>
                                </div>
                            </div>
                        </div>

                        <!-- Campos adicionales para docentes -->
                        <div id="campos-docente" class="mt-3" style="display: none;">
                            <h5 class="text-center text-secondary">Información adicional para docentes</h5>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
                                <input type="text" name="Experiencia" class="form-control" placeholder="Experiencia (ej: Matemáticas)" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
                                <input type="text" name="Titulo" class="form-control" placeholder="Título profesional" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-file-pdf"></i></span>
                                <input type="file" name="hoja_vida_path" class="form-control" accept=".pdf,.doc,.docx" required>
                            </div>
                            <div class="form-text mb-3">
                                Sube tu hoja de vida en formato PDF o Word (máximo 5MB)
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="Clave" class="form-control" placeholder="Clave" required>
                        </div>

                        <div class="input-group mb-3">
                            <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                            <input type="password" name="ConfirmarClave" id="confirmarClave" class="form-control" placeholder="Confirmar clave" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">Registrarse</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mensaje de bienvenida -->
            <div class="col-md-6 d-flex">
                <div class="welcome-container w-100">
                    <h1>¡Bienvenido!</h1>
                    <p>Inicie sesión con su información personal.</p>
                    <a href="../login/index.php" class="button-inicio">Iniciar Sesión</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Script para mostrar/ocultar campos del docente -->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectRol = document.querySelector('select[name="Rol"]');
        const camposDocente = document.getElementById('campos-docente');
        const form = document.querySelector('form');
        const clave = document.querySelector('input[name="Clave"]');
        const confirmarClave = document.getElementById('confirmarClave');

        // Mostrar u ocultar campos del docente
        selectRol.addEventListener('change', function () {
            if (this.value === '3') {
                camposDocente.style.display = 'block';
                // Hacer requeridos los campos de docente
                camposDocente.querySelectorAll('input').forEach(input => {
                    input.required = true;
                });
            } else {
                camposDocente.style.display = 'none';
                // Quitar el requerido de los campos de docente
                camposDocente.querySelectorAll('input').forEach(input => {
                    input.required = false;
                });
            }
        });

        // Validar que las contraseñas coincidan
        form.addEventListener('submit', function (e) {
            if (clave.value !== confirmarClave.value) {
                e.preventDefault();
                alert('Las contraseñas no coinciden');
                confirmarClave.focus();
            }
        });
    });
    </script>
</body>
</html>