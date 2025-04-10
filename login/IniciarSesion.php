<?php
session_start();
require '../includes/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación básica
    if (empty($_POST['Usuario']) || empty($_POST['Clave'])) {
        header("Location: Index.php?error=Usuario y clave requeridos");
        exit();
    }

    // Obtener datos del formulario
    $Usuario = htmlspecialchars(trim($_POST['Usuario']));
    $Clave = $_POST['Clave'];

    // Consulta para buscar el usuario
    $sql = "SELECT u.*, r.nombre AS rol_nombre 
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.Usuario = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $Usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    // Si existe el usuario
    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar contraseña
        if (password_verify($Clave, $row['Clave'])) {
            // Crear la sesión
            $_SESSION = [
                'usuario_id' => $row['id'],
                'usuario' => $row['Usuario'],
                'nombre_completo' => $row['Nombre_Completo'],
                'rol_id' => $row['rol_id'],
                'rol' => $row['rol_nombre']
            ];

            // Redirección por rol
            switch ($row['rol_id']) {
                case 2: // Cliente
                    header("Location: ../dashboard/paginaprincipale.php");
                    break;

                case 3: // Docente
                    header("Location: ../Docente/perfil_profesor.php");
                    break;

                default: // Otro rol
                    header("Location: ../dashboard/paginaprincipale.php");
            }
            exit();
        } else {
            // Contraseña incorrecta
            header("Location: Index.php?error=Contraseña incorrecta");
            exit();
        }
    } else {
        // Usuario no encontrado
        header("Location: Index.php?error=Usuario no encontrado");
        exit();
    }
} else {
    // Si no es POST
    header("Location: Index.php");
    exit();
}
