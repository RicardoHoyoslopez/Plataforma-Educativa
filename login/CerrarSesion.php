<?php
session_start(); // Inicia la sesión

// Destruye todas las variables de sesión
session_unset();

// Destruye la sesión
session_destroy();

// Redirige al usuario a la página principal
header("Location: ../dashboard/paginaprincipale.php");
exit();
?>