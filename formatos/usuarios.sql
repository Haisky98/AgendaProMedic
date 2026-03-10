CREATE TABLE IF NOT EXISTS `usuarios` (
  `id` INT NOT NULL AUTO_INCREMENT,
  `usuario` VARCHAR(80) NOT NULL,
  `password` VARCHAR(255) NOT NULL,
  `nombre` VARCHAR(120) NOT NULL,
  `rol` VARCHAR(50) NOT NULL DEFAULT 'admin',
  `activo` TINYINT(1) NOT NULL DEFAULT 1,
  `created_at` TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uk_usuario` (`usuario`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Recomendado: insertar usuarios con password_hash() desde PHP.
-- Ejemplo de semilla temporal (cambiar después del primer acceso):
-- INSERT INTO usuarios (usuario, password, nombre, rol, activo)
-- VALUES ('admin', 'admin123', 'Administrador', 'admin', 1);
