<?php
require '../includes/Conexion.php';
// Consultar en la base de datos los roles y los guarda en una variable
$query_roles = "SELECT * FROM roles";
$result_roles = mysqli_query($conexion, $query_roles);
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
</head>



<body>
    <div class="container">
        <div class="row">
            <!-- Formulario de registro -->
            <div class="col-md-6 form-container">
                <form action="logicaregistro.php" method="POST" autocomplete="off">
                    <h1>Registrarse</h1>
                    <hr>

                    <div class="row">
                        <!-- Columna 1 -->
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

                        <!-- Columna 2 -->
                        <div class="col-md-6">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-map-marker-alt"></i></span>
                                <input type="text" name="Direccion" class="form-control" placeholder="Dirección" required>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-user-tag"></i></span>
                                <select name="Rol" class="form-control" required>
                                    <option value="">¿Cómo quieres registrarte?</option>
                                    <?php while ($row = mysqli_fetch_assoc($result_roles)) { ?>
                                        <option value="<?= $row['id'] ?>"><?= $row['nombre'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>

                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-phone"></i></span>
                                <input type="text" name="Telefono" class="form-control" placeholder="Teléfono" required>
                            </div>


                            <!-- Dentro de tu formulario, después del campo de teléfono -->
<div id="campos-docente" class="mt-3" style="display: none;">
    <h5 class="text-muted">Información adicional para docentes</h5>
    
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa-solid fa-book"></i></span>
        <input type="text" name="Especialidad" class="form-control" placeholder="Especialidad (ej: Matemáticas)">
    </div>
    
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa-solid fa-graduation-cap"></i></span>
        <input type="text" name="Titulo" class="form-control" placeholder="Título profesional">
    </div>
    
    <div class="input-group mb-3">
        <span class="input-group-text"><i class="fa-solid fa-building"></i></span>
        <input type="text" name="Institucion" class="form-control" placeholder="Institución donde labora">
    </div>
</div>






                            <div class="input-group mb-3">
                                <span class="input-group-text"><i class="fa-solid fa-lock"></i></span>
                                <input type="password" name="Clave" class="form-control" placeholder="Clave" required>
                            </div>
                        </div>
                    </div>
                    <!-- Botón de Registro -->
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-custom">Registrarse</button>
                    </div>

                    <!-- Enlace para Iniciar Sesión -->
                    <!-- <div class="text-center mt-3">
                        <a href="../login/index.php" class="text-custom">Iniciar Sesión</a>
                    </div> -->
                </form>
            </div>

            <!-- Mensaje de bienvenida -->
            <div class="col-md-6 welcome-container">
                <h1>¡Bienvenido!</h1>
                <p>inicie sesión con su información personal.</p>
                <a href="../login/index.php" class="button-inicio">Iniciar Sesión</a>
            </div>
        </div>
    </div>




    <script>
document.addEventListener('DOMContentLoaded', function() {
    const selectRol = document.querySelector('select[name="Rol"]');
    const camposDocente = document.getElementById('campos-docente');
    
    selectRol.addEventListener('change', function() {
        // Verifica si el rol seleccionado es "Docente" (ID 3 en tu BD)
        if (this.value === '3') {
            camposDocente.style.display = 'block';
            // Hacer los campos requeridos
            camposDocente.querySelectorAll('input').forEach(input => {
                input.required = true;
            });
        } else {
            camposDocente.style.display = 'none';
            // Quitar el requerido si no es docente
            camposDocente.querySelectorAll('input').forEach(input => {
                input.required = false;
            });
        }
    });
});
</script>
</body>
</html>