<?php
session_start();
require '../includes/Conexion.php';

$conexion = conectarBD();

/**
 * Valida que los campos usuario y clave no estén vacíos.
 * Retorna true si están presentes, false si falta alguno.
 */
function validarCamposLogin() {
    return !empty($_POST['Usuario']) && !empty($_POST['Clave']);
}

/**
 * Obtiene el usuario y sus datos (incluyendo rol) desde la base de datos por nombre de usuario.
 * Retorna un array con los datos o false si no existe.
 */
function obtenerUsuarioPorNombre($conexion, $usuario) {
    $sql = "SELECT u.*, r.nombre AS rol_nombre 
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.Usuario = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $usuario);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($resultado);
}

/**
 * Verifica la contraseña ingresada contra el hash almacenado.
 * Retorna true si coinciden, false si no.
 */
function verificarClave($claveIngresada, $hashAlmacenado) {
    return password_verify($claveIngresada, $hashAlmacenado);
}

/**
 * Inicializa la sesión con los datos del usuario.
 */
function iniciarSesion($usuario) {
    $_SESSION['usuario_id'] = $usuario['id'];
    $_SESSION['usuario'] = $usuario['Usuario'];
    $_SESSION['nombre_completo'] = $usuario['Nombre_Completo'];
    $_SESSION['rol_id'] = $usuario['rol_id'];
    $_SESSION['rol'] = $usuario['rol_nombre'];
}

/**
 * Redirige al usuario según su rol.
 */
function redirigirPorRol($rol_id) {
    switch ($rol_id) {
        case 2: // Cliente
            header("Location: ../dashboard/paginaprincipale.php");
            break;
        case 3: // Docente
            header("Location: ../Docente/perfil_profesor.php");
            break;
        default: // Otros roles
            header("Location: ../dashboard/paginaprincipale.php");
    }
    exit();
}

// --- Lógica principal ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validarCamposLogin()) {
        header("Location: Index.php?error=Usuario y clave requeridos");
        exit();
    }

    $usuario = htmlspecialchars(trim($_POST['Usuario']));
    $clave = $_POST['Clave'];

    $datosUsuario = obtenerUsuarioPorNombre($conexion, $usuario);

    if ($datosUsuario) {
        if (verificarClave($clave, $datosUsuario['Clave'])) {
            iniciarSesion($datosUsuario);
            redirigirPorRol($datosUsuario['rol_id']);
        } else {
            header("Location: Index.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        header("Location: Index.php?error=Usuario no encontrado");
        exit();
    }
} else {
    header("Location: Index.php");
    exit();
}
?>
