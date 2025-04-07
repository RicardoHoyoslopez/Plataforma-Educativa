
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Crear Clase</title>
</head>
<body>

<form action="crear_clase.php" method="POST">
  <input type="text" name="titulo" placeholder="Título de la clase" required>
  
  <textarea name="descripcion" placeholder="Descripción" required></textarea>

  <!-- Campo de horario con tipo datetime-local -->
  <label for="horario">Horario de la clase:</label>
  <input type="datetime-local" name="fecha_creacion" required>

  <select name="estado" required>
    <option value="activa">Activa</option>
    <option value="finalizada">Finalizada</option>
  </select>

  <button type="submit">Crear clase</button>
</form>


</body>
</html>
