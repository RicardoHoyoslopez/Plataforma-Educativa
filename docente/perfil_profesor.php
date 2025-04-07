<?php
session_start();
require '../includes/Conexion.php';

// Verificamos que el usuario ha iniciado sesión y es docente
if (!isset($_SESSION['usuario_id']) || $_SESSION['rol_id'] != 3) {
    header("Location: ../login/Index.php?error=Acceso denegado");
    exit();
}

$usuario_id = $_SESSION['usuario_id'];
$nombre = $_SESSION['nombre_completo'];
$usuario = $_SESSION['usuario'];

// Consultar clases del docente
$sql = "SELECT * FROM clases WHERE profesor_id = ? AND estado = 'activa'";
$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $usuario_id);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Docente</title>
    <!-- Bootstrap CSS y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container mt-5">
    <h2 class="mb-4">Bienvenido, <?php echo $nombre; ?></h2>
    
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>ID Usuario:</strong> <?php echo $usuario_id; ?></p>
            <p><strong>Usuario:</strong> <?php echo $usuario; ?></p>
            <p><strong>Rol:</strong> Docente</p>
        </div>
    </div>

    <a href="fcrear_clase.php" class="btn btn-success mb-3">
        <i class="bi bi-plus-circle"></i> Crear nueva clase
    </a>

    <table class="table table-bordered bg-white shadow">
        <thead class="table-dark">
            <tr>
                <th>Título</th>
                <th>Descripción</th>
                <th>Horario</th>
                <th>Estado</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($clase = mysqli_fetch_assoc($resultado)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($clase['titulo']); ?></td>
                    <td><?php echo htmlspecialchars($clase['descripcion']); ?></td>
                    <td><?php echo htmlspecialchars($clase['fecha_creacion'] ?? 'Sin horario'); ?></td>
                    <td><?php echo htmlspecialchars($clase['estado']); ?></td>
                    
                    <td>
                        <a href="editar_clase.php?id=<?php echo $clase['id_clase']; ?>" class="btn btn-sm btn-warning" title="Editar">
                            <i class="bi bi-pencil-square"></i>
                        </a>
                        <a href="eliminar_clase.php?id=<?php echo $clase['id_clase']; ?>" class="btn btn-sm btn-danger" title="Eliminar" 
                           onclick="return confirm('¿Estás seguro que deseas eliminar esta clase?');">
                            <i class="bi bi-trash3-fill"></i>
                        </a>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
</div>

</body>
</html>
