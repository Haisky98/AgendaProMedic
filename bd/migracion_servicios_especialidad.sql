-- Migracion: relacionar servicios con especialidades
-- Fecha: 2026-03-08

SET @db_name := DATABASE();

-- 1) Agregar columna id_especialidad si no existe.
SET @col_exists := (
    SELECT COUNT(*)
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @db_name
      AND TABLE_NAME = 'cat_servicios'
      AND COLUMN_NAME = 'id_especialidad'
);

SET @sql := IF(
    @col_exists = 0,
    'ALTER TABLE cat_servicios ADD COLUMN id_especialidad INT NULL AFTER id_servicio',
    'SELECT "id_especialidad ya existe en cat_servicios"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 2) Intentar asignar especialidad por nombre del servicio.
UPDATE cat_servicios
SET id_especialidad = CASE
    WHEN UPPER(nombre) LIKE '%PEDIATR%' THEN 2
    WHEN UPPER(nombre) LIKE '%DENTAL%' THEN 4
    ELSE id_especialidad
END
WHERE id_especialidad IS NULL;

-- 3) Si hay citas historicas, inferir especialidad por medico asignado.
UPDATE cat_servicios s
INNER JOIN (
    SELECT c.id_servicio, MIN(m.id_especialidad) AS id_especialidad
    FROM citas c
    INNER JOIN medicos m ON m.id_medico = c.id_medico
    GROUP BY c.id_servicio
) t ON t.id_servicio = s.id_servicio
SET s.id_especialidad = t.id_especialidad
WHERE s.id_especialidad IS NULL;

-- 4) Completar faltantes con la primera especialidad disponible.
SET @especialidad_default := (
    SELECT COALESCE(MIN(id_especialidad), 1) FROM cat_especialidades
);
UPDATE cat_servicios
SET id_especialidad = @especialidad_default
WHERE id_especialidad IS NULL;

-- 5) Convertir la columna a NOT NULL si aun permite null.
SET @is_nullable := (
    SELECT IS_NULLABLE
    FROM information_schema.COLUMNS
    WHERE TABLE_SCHEMA = @db_name
      AND TABLE_NAME = 'cat_servicios'
      AND COLUMN_NAME = 'id_especialidad'
    LIMIT 1
);

SET @sql := IF(
    @is_nullable = 'YES',
    'ALTER TABLE cat_servicios MODIFY id_especialidad INT NOT NULL',
    'SELECT "id_especialidad ya es NOT NULL"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 6) Crear indice si no existe.
SET @idx_exists := (
    SELECT COUNT(*)
    FROM information_schema.STATISTICS
    WHERE TABLE_SCHEMA = @db_name
      AND TABLE_NAME = 'cat_servicios'
      AND INDEX_NAME = 'idx_servicio_especialidad'
);

SET @sql := IF(
    @idx_exists = 0,
    'ALTER TABLE cat_servicios ADD INDEX idx_servicio_especialidad (id_especialidad)',
    'SELECT "indice idx_servicio_especialidad ya existe"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;

-- 7) Crear llave foranea si no existe.
SET @fk_exists := (
    SELECT COUNT(*)
    FROM information_schema.TABLE_CONSTRAINTS
    WHERE TABLE_SCHEMA = @db_name
      AND TABLE_NAME = 'cat_servicios'
      AND CONSTRAINT_NAME = 'cat_servicios_ibfk_1'
      AND CONSTRAINT_TYPE = 'FOREIGN KEY'
);

SET @sql := IF(
    @fk_exists = 0,
    'ALTER TABLE cat_servicios ADD CONSTRAINT cat_servicios_ibfk_1 FOREIGN KEY (id_especialidad) REFERENCES cat_especialidades(id_especialidad) ON DELETE RESTRICT ON UPDATE RESTRICT',
    'SELECT "FK cat_servicios_ibfk_1 ya existe"'
);
PREPARE stmt FROM @sql;
EXECUTE stmt;
DEALLOCATE PREPARE stmt;
