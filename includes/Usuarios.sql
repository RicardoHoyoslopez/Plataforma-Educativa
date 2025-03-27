-- Crear la base de datos
CREATE DATABASE IF NOT EXISTS plataformaeducativa;
USE plataformaeducativa;

-- Crear la tabla usuarios con id autoincrementable
CREATE TABLE IF NOT EXISTS usuarios (
  id INT(11) NOT NULL AUTO_INCREMENT,
  Usuario VARCHAR(255) NOT NULL,
  Clave VARCHAR(255) NOT NULL,
  Nombre_Completo VARCHAR(255) NOT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- Insertar datos de prueba
INSERT INTO usuarios (Usuario, Clave, Nombre_Completo) VALUES
('Juan', '1234', 'Juan Rodriguez'),
('Juanfran', '12345', 'Juanfran');
