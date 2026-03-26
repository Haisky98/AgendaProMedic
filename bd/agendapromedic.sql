/*
 Navicat Premium Data Transfer

 Source Server         : 00.localhost
 Source Server Type    : MySQL
 Source Server Version : 80030
 Source Host           : localhost:3306
 Source Schema         : agendapromedic

 Target Server Type    : MySQL
 Target Server Version : 80030
 File Encoding         : 65001

 Date: 08/03/2026 08:17:44
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for cat_consultorios
-- ----------------------------
DROP TABLE IF EXISTS `cat_consultorios`;
CREATE TABLE `cat_consultorios`  (
  `id_consultorio` int(0) NOT NULL AUTO_INCREMENT,
  `numero_sala` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `ubicacion` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_consultorio`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_consultorios
-- ----------------------------
INSERT INTO `cat_consultorios` VALUES (1, 'Consultorio 1', 'Planta Baja', 1);
INSERT INTO `cat_consultorios` VALUES (2, 'Consultorio 2', 'Planta Baja', 1);
INSERT INTO `cat_consultorios` VALUES (3, 'Consultorio 3', 'Planta Alta', 1);
INSERT INTO `cat_consultorios` VALUES (4, 'Consultorio 4', 'Planta Alta', 1);

-- ----------------------------
-- Table structure for cat_especialidades
-- ----------------------------
DROP TABLE IF EXISTS `cat_especialidades`;
CREATE TABLE `cat_especialidades`  (
  `id_especialidad` int(0) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `descripcion` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_especialidad`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_especialidades
-- ----------------------------
INSERT INTO `cat_especialidades` VALUES (1, 'Medicina General', 'Atención médica primaria y valoración inicial', 1);
INSERT INTO `cat_especialidades` VALUES (2, 'Pediatría', 'Atención médica integral para niños y adolescentes', 1);
INSERT INTO `cat_especialidades` VALUES (3, 'Ginecología', 'Salud del sistema reproductor femenino', 1);
INSERT INTO `cat_especialidades` VALUES (4, 'Odontología', 'Cuidado y tratamiento dental', 1);
INSERT INTO `cat_especialidades` VALUES (5, 'Psicología', 'Atención a la salud mental y emocional', 1);

-- ----------------------------
-- Table structure for cat_estatus_cita
-- ----------------------------
DROP TABLE IF EXISTS `cat_estatus_cita`;
CREATE TABLE `cat_estatus_cita`  (
  `id_estatus` int(0) NOT NULL AUTO_INCREMENT,
  `nombre` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_estatus`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 7 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_estatus_cita
-- ----------------------------
INSERT INTO `cat_estatus_cita` VALUES (1, 'Pendiente', 1);
INSERT INTO `cat_estatus_cita` VALUES (2, 'Confirmada', 1);
INSERT INTO `cat_estatus_cita` VALUES (3, 'En Curso', 1);
INSERT INTO `cat_estatus_cita` VALUES (4, 'Finalizada', 1);
INSERT INTO `cat_estatus_cita` VALUES (5, 'Cancelada', 1);
INSERT INTO `cat_estatus_cita` VALUES (6, 'No Asistió', 1);

-- ----------------------------
-- Table structure for cat_hora_cita
-- ----------------------------
DROP TABLE IF EXISTS `cat_hora_cita`;
CREATE TABLE `cat_hora_cita`  (
  `id_hora` int(0) NOT NULL AUTO_INCREMENT,
  `hora_inicio` time(0) NOT NULL,
  `hora_fin` time(0) NOT NULL,
  `etiqueta` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `turno` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_hora`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 10 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_hora_cita
-- ----------------------------
INSERT INTO `cat_hora_cita` VALUES (1, '08:00:00', '08:30:00', '08:00 AM - 08:30 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (2, '08:30:00', '09:00:00', '08:30 AM - 09:00 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (3, '09:00:00', '09:30:00', '09:00 AM - 09:30 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (4, '09:30:00', '10:00:00', '09:30 AM - 10:00 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (5, '10:00:00', '10:30:00', '10:00 AM - 10:30 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (6, '10:30:00', '11:00:00', '10:30 AM - 11:00 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (7, '11:00:00', '11:30:00', '11:00 AM - 11:30 AM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (8, '11:30:00', '12:00:00', '11:30 AM - 12:00 PM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (9, '12:00:00', '12:30:00', '12:00 PM - 12:30 PM', 'Matutino', 1);
INSERT INTO `cat_hora_cita` VALUES (10, '12:30:00', '13:00:00', '12:30 PM - 01:00 PM', 'Matutino', 1);

-- ----------------------------
-- Table structure for cat_servicios
-- ----------------------------
DROP TABLE IF EXISTS `cat_servicios`;
CREATE TABLE `cat_servicios`  (
  `id_servicio` int(0) NOT NULL AUTO_INCREMENT,
  `id_especialidad` int(0) NOT NULL,
  `nombre` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `duracion_estimada_minutos` int(0) NULL DEFAULT 30,
  `costo` decimal(10, 2) NULL DEFAULT 0.00,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_servicio`) USING BTREE,
  INDEX `idx_servicio_especialidad`(`id_especialidad`) USING BTREE,
  CONSTRAINT `cat_servicios_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `cat_especialidades` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of cat_servicios
-- ----------------------------
INSERT INTO `cat_servicios` VALUES (1, 1, 'Consulta Primera Vez', 45, 500.00, 1);
INSERT INTO `cat_servicios` VALUES (2, 1, 'Consulta de Seguimiento', 30, 300.00, 1);
INSERT INTO `cat_servicios` VALUES (3, 4, 'Limpieza Dental', 45, 600.00, 1);
INSERT INTO `cat_servicios` VALUES (4, 1, 'Expedición Certificado Médico', 15, 200.00, 1);
INSERT INTO `cat_servicios` VALUES (5, 2, 'Valoración Pediátrica', 40, 500.00, 1);
-- ----------------------------
-- Table structure for citas
-- ----------------------------
DROP TABLE IF EXISTS `citas`;
CREATE TABLE `citas`  (
  `id_cita` int(0) NOT NULL AUTO_INCREMENT,
  `curp_paciente` varchar(18) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `nombre_paciente` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `telefono_paciente` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `correo_paciente` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `id_medico` int(0) NOT NULL,
  `id_servicio` int(0) NOT NULL,
  `id_hora` int(0) NOT NULL,
  `id_estatus` int(0) NOT NULL DEFAULT 1,
  `fecha_cita` date NOT NULL,
  `motivo` text CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL,
  `created_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` timestamp(0) NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP(0),
  PRIMARY KEY (`id_cita`) USING BTREE,
  INDEX `id_medico`(`id_medico`) USING BTREE,
  INDEX `id_servicio`(`id_servicio`) USING BTREE,
  INDEX `id_hora`(`id_hora`) USING BTREE,
  INDEX `id_estatus`(`id_estatus`) USING BTREE,
  CONSTRAINT `citas_ibfk_1` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `citas_ibfk_2` FOREIGN KEY (`id_servicio`) REFERENCES `cat_servicios` (`id_servicio`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `citas_ibfk_3` FOREIGN KEY (`id_hora`) REFERENCES `cat_hora_cita` (`id_hora`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `citas_ibfk_4` FOREIGN KEY (`id_estatus`) REFERENCES `cat_estatus_cita` (`id_estatus`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of citas
-- ----------------------------
INSERT INTO `citas` VALUES (4, 'OIOD940912HCLRRN07', 'DANIEL EDUARDO ORTIZ ORTEGA', '8443813536', 'haisky98@gmail.com', 2, 1, 1, 4, '2026-03-04', 'dolor', '2026-03-04 17:38:56', '2026-03-04 17:54:15');
INSERT INTO `citas` VALUES (5, 'RANTSFD54858F85558', 'RENATA LA BARATA', '8441234455', 'haisky98@gmail.com', 2, 1, 2, 1, '2026-03-04', 'dolor', '2026-03-04 17:42:39', '2026-03-04 17:42:39');
INSERT INTO `citas` VALUES (6, 'OIOD940912HCLRRN07', 'DANIEL EDUARDO ORTIZ ORTEGA', '8441234455', 'haisky98@gmail.com', 2, 1, 3, 1, '2026-03-04', 'dolor', '2026-03-04 17:43:37', '2026-03-04 17:43:37');

-- ----------------------------
-- Table structure for medicos
-- ----------------------------
DROP TABLE IF EXISTS `medicos`;
CREATE TABLE `medicos`  (
  `id_medico` int(0) NOT NULL AUTO_INCREMENT,
  `nombre_completo` varchar(150) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `cedula_profesional` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `id_especialidad` int(0) NOT NULL,
  `id_consultorio` int(0) NULL DEFAULT NULL,
  `telefono` varchar(20) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `correo` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NULL DEFAULT NULL,
  `activo` tinyint(1) NULL DEFAULT 1,
  PRIMARY KEY (`id_medico`) USING BTREE,
  UNIQUE INDEX `cedula_profesional`(`cedula_profesional`) USING BTREE,
  INDEX `id_especialidad`(`id_especialidad`) USING BTREE,
  INDEX `id_consultorio`(`id_consultorio`) USING BTREE,
  CONSTRAINT `medicos_ibfk_1` FOREIGN KEY (`id_especialidad`) REFERENCES `cat_especialidades` (`id_especialidad`) ON DELETE RESTRICT ON UPDATE RESTRICT,
  CONSTRAINT `medicos_ibfk_2` FOREIGN KEY (`id_consultorio`) REFERENCES `cat_consultorios` (`id_consultorio`) ON DELETE RESTRICT ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 4 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of medicos
-- ----------------------------
INSERT INTO `medicos` VALUES (1, 'Dr. Roberto Martínez', 'CED1234567', 1, 1, '8441234567', 'roberto.mtz@clinica.com', 1);
INSERT INTO `medicos` VALUES (2, 'Dra. Ana Sofía Garza', 'CED7654321', 2, 2, '8447654321', 'ana.garza@clinica.com', 1);
INSERT INTO `medicos` VALUES (3, 'Dra. Elena Rodríguez', 'CED1122334', 3, 3, '8441122334', 'elena.rdz@clinica.com', 1);
INSERT INTO `medicos` VALUES (4, 'Dr. Carlos Ruiz', 'CED4433221', 1, 4, '8444433221', 'carlos.ruiz@clinica.com', 1);

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios`  (
  `id` int(0) NOT NULL AUTO_INCREMENT,
  `usuario` varchar(80) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `password` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `nombre` varchar(120) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL,
  `rol` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_0900_ai_ci NOT NULL DEFAULT 'admin',
  `id_medico` int(0) NULL DEFAULT NULL,
  `activo` tinyint(1) NOT NULL DEFAULT 1,
  `created_at` timestamp(0) NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`) USING BTREE,
  UNIQUE INDEX `uk_usuario`(`usuario`) USING BTREE,
  INDEX `idx_usuarios_medico`(`id_medico`) USING BTREE,
  CONSTRAINT `fk_usuarios_medico` FOREIGN KEY (`id_medico`) REFERENCES `medicos` (`id_medico`) ON DELETE SET NULL ON UPDATE RESTRICT
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_0900_ai_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
INSERT INTO `usuarios` VALUES (1, 'ADMIN', '$2y$10$o5q6lCYLe8JeNagnGqaIU.hM5hKbXldHdRJNzcDruuzQbTVQgV/tS', 'Administrador', 'admin', NULL, 1, '2026-03-02 19:08:30');

SET FOREIGN_KEY_CHECKS = 1;
