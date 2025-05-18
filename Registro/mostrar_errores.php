<?php
function mostrarErrores($errores) {
    foreach ($errores as $error) {
        echo "<p style='color:red;'>$error</p>";
    }
}
?>
