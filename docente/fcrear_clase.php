<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Crear Clase</title>
  <!-- Enlace a Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">
 

  <div class="container mt-3">
    <div class="card shadow-lg">
      <div class="card-header bg-primary text-white">
        <h4 class="mb-0">Crear Clase</h4>
      </div>
      <div class="card-body">
        <form method="POST" action="crear_clase.php">
          <div class="mb-3">
            <label for="titulo" class="form-label">Título</label>
            <input type="text" class="form-control" id="titulo" name="titulo" placeholder="Título de la clase" required>
          </div>

          <div class="mb-3">
            <label for="descripcion" class="form-label">Descripción</label>
            <textarea class="form-control" id="descripcion" name="descripcion" rows="3" placeholder="Descripción breve" required></textarea>
          </div>

          <div class="mb-3">
            <label for="fecha_creacion" class="form-label">Fecha y Hora de Creación</label>
            <input type="datetime-local" class="form-control" id="fecha_creacion" name="fecha_creacion" required>
          </div>

          <div class="mb-3">
            <label for="dia" class="form-label">Día</label>
            <select class="form-select" id="dia" name="dia" required>
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
            <label for="precio" class="form-label">Precio</label>
            <input type="number" class="form-control" id="precio" name="precio" placeholder="Precio de la clase" min="0" step="0.01" required>
          </div>

          <div class="d-grid">
            <button type="submit" class="btn btn-success">Crear Clase</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  <!-- Script de Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  <!-- Incluye SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="alertas.js"></script>


</body>

</html>
