<?php
session_start();
require '../includes/Conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validación básica
    if (empty($_POST['Usuario'])) {
        header("Location: Index.php?error=El usuario es requerido");
        exit();
    }
    if (empty($_POST['Clave'])) {
        header("Location: Index.php?error=La clave es requerida");
        exit();
    }

    // Limpieza de datos
    $Usuario = htmlspecialchars(trim($_POST['Usuario']));
    $Clave = $_POST['Clave']; // No limpiar la contraseña para hash

    // Consulta 
    $sql = "SELECT u.*, r.nombre as rol_nombre 
            FROM usuarios u
            JOIN roles r ON u.rol_id = r.id
            WHERE u.Usuario = ?";
    
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "s", $Usuario);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        // Verificar contraseña
        if (password_verify($Clave, $row['Clave'])) {
            // Configurar sesión
            $_SESSION = [
                'usuario_id' => $row['id'],
                'usuario' => $row['Usuario'],
                'nombre_completo' => $row['Nombre_Completo'],
                'rol_id' => $row['rol_id'],
                'rol' => $row['rol_nombre']
            ];

            // Redirección de acuerdo al rol con las credenciales que se ingrese
            switch ($row['rol_id']) {
                case 2: // ---------------redirecciona pagina cliente
                    header("Location: ../dashboard/paginaprincipale.php");
                    break;
                case 3: // --------- redirecciona pagina docente
                    header("Location: ../dashboard/panel_docente.php");
                    break;
                default:
                    header("Location: ../dashboard/paginaprincipale.php");
            }
            exit();
        }
    }

    // Error genérico por seguridad
    header("Location: Index.php?error=Credenciales incorrectas");
    exit();
} else {
    header("Location: Index.php");
    exit();
}