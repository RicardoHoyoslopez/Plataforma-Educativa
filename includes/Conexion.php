 <?php 

$host="localhost";
$user="root";
$pass="";
$bd="plataformaeducativa";

$conexion=mysqli_connect($host, $user, $pass, $bd);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

if (!$conexion) {
    echo "conexion fallida";
} 