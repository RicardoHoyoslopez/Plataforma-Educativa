<!DOCTYPE html>
<html lang="es"> <!-- Cambiado a español -->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <title>Inicio de Sesión</title>
    <!-- Estilos para mensajes de error -->
    <style>
        .error {
            color: #dc3545;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 8px;
            border-radius: 4px;
            margin-bottom: 15px;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <!-- Formulario de inicio de sesión -->
        <div class="form-container">
            <form action="IniciarSesion.php" method="POST" autocomplete="off">
                <h1 class="text text-center">INICIAR SESIÓN</h1>
                <hr>

                <?php if (isset($_GET['error'])): ?>
                    <p class="error"><?php echo htmlspecialchars($_GET['error']); ?></p>
                    <hr>
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-solid fa-user"></i> Usuario
                    </label>
                    <input type="text" class="form-control" name="Usuario" placeholder="Nombre de usuario" required 
                           autocomplete="off" readonly onfocus="this.removeAttribute('readonly')">
                </div>

                <div class="mb-3">
                    <label class="form-label">
                        <i class="fa-solid fa-unlock"></i> Contraseña
                    </label>
                    <input type="password" class="form-control" name="Clave" placeholder="Contraseña" required 
                           autocomplete="new-password" readonly onfocus="this.removeAttribute('readonly')">
                </div>

                <hr>

                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                </div>
            </form>
        </div>

        <!-- Mensaje en el lado derecho -->
        <div class="welcome-container">
            <h1>¡Bienvenido!</h1>
            <p>¡Regístrate ahora y descubre todo lo que tenemos para ofrecerte!</p>
            <a href="../Registro/RegistroUsuarios.php" class="btn btn-outline-primary">Registrarse</a>
        </div>
    </div>

    <!-- Script de Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>