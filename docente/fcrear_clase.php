<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <title>Crear Clase</title>
</head>

<body>

  <form method="POST" action="crear_clase.php">
    <input type="text" name="titulo" placeholder="Título" required><br>
    <textarea name="descripcion" placeholder="Descripción" required></textarea><br>
    <input type="datetime-local" name="fecha_creacion" required><br>

    <select name="dia" required>
      <option value="">Seleccione el día</option>
      <option value="Lunes">Lunes</option>
      <option value="Martes">Martes</option>
      <option value="Miércoles">Miércoles</option>
      <option value="Jueves">Jueves</option>
      <option value="Viernes">Viernes</option>
      <option value="Sábado">Sábado</option>
      <option value="Domingo">Domingo</option>
    </select><br>

    <label>Hora de inicio:</label>
    <input type="time" name="hora_inicio" required><br>

    <label>Hora de fin:</label>
    <input type="time" name="hora_fin" required><br>

    

    <button type="submit">Crear Clase</button>
  </form>

</body>

</html>