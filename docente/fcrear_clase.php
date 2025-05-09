<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Crear Clase</title>
  <!-- Agregar enlace a Bootstrap -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="style.css" rel="stylesheet">
  
</head>

<body>

  <div class="container">
    <div class="form-container">
      <h2 class="text-center">Crear Clase</h2>
      <form method="POST" action="crear_clase.php">
        <div class="mb-3">
          <input type="text" name="titulo" class="form-control" placeholder="Título" required>
        </div>

        <div class="mb-3">
          <textarea name="descripcion" class="form-control" placeholder="Descripción" required></textarea>
        </div>

        <div class="mb-3">
          <input type="datetime-local" name="fecha_creacion" class="form-control" required>
        </div>

        <div class="mb-3">
          <select name="dia" class="form-select" required>
            <option value="">Seleccione el día</option>
            <option value="Lunes">Lunes</option>
            <option value="Martes">Martes</option>
            <option value="Miércoles">Miércoles</option>
            <option value="Jueves">Jueves</option>
            <option value="Viernes">Viernes</option>
            <option value="Sábado">Sábado</option>
            <option value="Domingo">Domingo</option>
          </select>
        </div>

        <div class="mb-3">
          <label for="hora_inicio" class="form-label">Hora de inicio:</label>
          <input type="time" name="hora_inicio" class="form-control" required>
        </div>

        <div class="mb-3">
          <label for="hora_fin" class="form-label">Hora de fin:</label>
          <input type="time" name="hora_fin" class="form-control" required>
        </div>

        <button type="submit" class="btn btn-primary">Crear Clase</button>
      </form>
    </div>
  </div>

  <!-- Agregar enlace a los scripts de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
