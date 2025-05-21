<?php

function conectarBD() {
    $host = "localhost";
    $user = "root";
    $pass = "";
    $bd = "plataformaeducativa";

    $conexion = mysqli_connect($host, $user, $pass, $bd);
    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    if (!$conexion) {
        die("Conexión fallida: " . mysqli_connect_error());
    }
    mysqli_query($conexion, "SET time_zone = '-05:00'");

    return $conexion;
}
