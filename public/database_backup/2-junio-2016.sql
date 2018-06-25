/*
Navicat MySQL Data Transfer

Source Server         : LOCAL
Source Server Version : 50711
Source Host           : localhost:33060
Source Database       : Homestead

Target Server Type    : MYSQL
Target Server Version : 50711
File Encoding         : 65001

Date: 2016-06-02 17:04:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for Articulos
-- ----------------------------
DROP TABLE IF EXISTS `Articulos`;
CREATE TABLE `Articulos` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`numero_articulo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`literal_numeral`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`norma_id`  int(11) NOT NULL ,
`Estado_del_Articulo`  varchar(20) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Vigente' ,
`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=23

;

-- ----------------------------
-- Records of Articulos
-- ----------------------------
BEGIN;
INSERT INTO `Articulos` VALUES ('1', '4', 'No aplica', '1', 'Derogado', '2016-05-26 21:30:06', '2016-05-26 16:30:06'), ('2', '2281115', 'No aplica', '2', 'Derogado', '2016-05-22 22:35:53', '2016-05-22 17:35:53'), ('3', '2281116', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('4', '1', 'No aplica', '3', 'Derogado', '2016-05-27 12:40:03', '2016-05-27 07:40:03'), ('5', '9', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('6', '8', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('7', '677', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('8', '678', 'No aplica', '2', 'Derogado', '2016-05-20 21:25:44', '2016-05-20 21:25:44'), ('9', '679', 'No aplica', '1', 'Derogado', '2016-05-20 21:30:07', '2016-05-20 21:30:07'), ('10', '676', 'No aplica', '1', 'Derogado', '2016-05-26 21:30:06', '2016-05-26 16:30:06'), ('11', '600', 'No aplica', '1', 'Derogado', '2016-05-26 21:30:06', '2016-05-26 16:30:06'), ('12', '4', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('13', '300', 'No aplica', '2', 'Derogado', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('14', '6', 'No aplica', '6', 'Derogado', '2016-05-26 21:25:48', '2016-05-26 16:25:48'), ('15', '8', 'No aplica', '6', 'Derogado', '2016-05-27 12:33:34', '2016-05-27 07:33:34'), ('18', '65', 'No aplica', '1', 'Derogado', '2016-05-31 19:58:23', '2016-05-31 14:58:23'), ('19', '5', 'No aplica', '4', 'Derogado', '2016-05-31 19:59:11', '2016-05-31 14:59:11'), ('20', '4', 'No aplica', '8', 'Vigente', '2016-05-31 14:59:12', '2016-05-31 14:59:12'), ('21', '1', 'No aplica', '5', 'Derogado', '2016-05-31 20:44:23', '2016-05-31 15:44:23'), ('22', '8', 'No aplica', '4', 'Vigente', '2016-05-31 15:44:23', '2016-05-31 15:44:23');
COMMIT;

-- ----------------------------
-- Table structure for AspectoAmbiental
-- ----------------------------
DROP TABLE IF EXISTS `AspectoAmbiental`;
CREATE TABLE `AspectoAmbiental` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=3

;

-- ----------------------------
-- Records of AspectoAmbiental
-- ----------------------------
BEGIN;
INSERT INTO `AspectoAmbiental` VALUES ('1', 'Manejo de residuos', '2016-05-30 17:29:53', '2016-05-30 17:29:53'), ('2', 'Manejo de desechos', '2016-05-30 17:32:54', '2016-05-30 17:32:54');
COMMIT;

-- ----------------------------
-- Table structure for autoridademisora
-- ----------------------------
DROP TABLE IF EXISTS `autoridademisora`;
CREATE TABLE `autoridademisora` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=15

;

-- ----------------------------
-- Records of autoridademisora
-- ----------------------------
BEGIN;
INSERT INTO `autoridademisora` VALUES ('1', 'Congreso \r\nde la República', '2016-05-16 15:39:56', '2016-05-20 12:41:05'), ('2', 'Ministerio de Ambiente y Desarrollo Sostenible', '2016-05-16 15:39:56', '2016-05-20 12:41:05'), ('3', 'Presidencia de la República ', '2016-05-19 21:56:36', '2016-05-18 15:02:12'), ('4', 'Ministerio de Trabajo y Seguridad Socia', '2016-05-20 12:41:05', '2016-05-20 12:41:05'), ('5', 'Ministerio de Ambiente, Vivienda y Desarrollo Territorial', '2016-05-19 21:55:37', '2016-05-19 21:55:37'), ('6', 'Ministerio  de Salud', '2016-05-20 12:34:47', '2016-05-20 12:34:47'), ('7', 'Ministerio de Comercio Exterior ', '2016-05-20 12:42:49', '2016-05-20 12:42:49'), ('8', 'Congreso Nacional de Colombia ', '2016-05-20 12:43:31', '2016-05-20 12:43:31'), ('9', 'Ministerio de Minas y Energía', '2016-05-20 12:44:05', '2016-05-20 12:44:05'), ('10', 'Ministerio de Transporte', '2016-05-20 12:45:08', '2016-05-20 12:45:08'), ('11', 'Ministerio de Hacienda y Crédito Público', '2016-05-20 12:46:01', '2016-05-20 12:46:01'), ('12', 'Ministerio de Gobierno', '2016-05-20 12:46:33', '2016-05-20 12:46:33'), ('13', 'Ministerio de Defensa', '2016-05-20 12:46:57', '2016-05-20 12:46:57'), ('14', ' Ministerio de Trabajo y Seguridad Social y de Salud', '2016-05-20 12:47:37', '2016-05-20 12:47:37');
COMMIT;

-- ----------------------------
-- Table structure for CategoriaAmbiental
-- ----------------------------
DROP TABLE IF EXISTS `CategoriaAmbiental`;
CREATE TABLE `CategoriaAmbiental` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`aspecto_ambiental_id`  int(11) NOT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=2

;

-- ----------------------------
-- Records of CategoriaAmbiental
-- ----------------------------
BEGIN;
INSERT INTO `CategoriaAmbiental` VALUES ('1', 'Desechos plasticos', '2', '2016-05-30 17:53:48', '2016-05-30 17:53:48');
COMMIT;

-- ----------------------------
-- Table structure for clase_norma
-- ----------------------------
DROP TABLE IF EXISTS `clase_norma`;
CREATE TABLE `clase_norma` (
`idclase_norma`  int(50) NOT NULL ,
`nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of clase_norma
-- ----------------------------
BEGIN;
INSERT INTO `clase_norma` VALUES ('1', 'Informativa'), ('2', 'Obligatoria '), ('3', 'Derogada'), ('4', 'modificada');
COMMIT;

-- ----------------------------
-- Table structure for Comentario
-- ----------------------------
DROP TABLE IF EXISTS `Comentario`;
CREATE TABLE `Comentario` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`comentario`  text CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`evaluacion_id`  int(11) NOT NULL ,
`archivo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
`usuario_id`  int(11) NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=17

;

-- ----------------------------
-- Records of Comentario
-- ----------------------------
BEGIN;
INSERT INTO `Comentario` VALUES ('1', 'comentario 1', '13', 'Git.docx', '2016-06-01 14:11:45', '2016-06-01 14:11:45', '24'), ('2', 'comentario 1 de esa evaluacion', '14', 'Historia_proyecto.docx', '2016-06-01 14:37:44', '2016-06-01 14:37:44', '24'), ('3', 'comentario del 3 si yo voy a ser un comentario mucho mas grande', '15', 'Capacitación shamir.docx', '2016-06-01 15:13:04', '2016-06-01 15:13:04', '24'), ('7', 'soy otro comentario cuya intención es ser lo mas grande posible para averiguar si es posible que se desborde la base de datos.', '16', 'Historia_proyecto.doc', '2016-06-02 13:37:33', '2016-06-02 13:37:33', '24'), ('8', 'Soy otro comentario estoy probando que todo funcione de manera adecuada', '15', 'Historia_proyecto.doc', '2016-06-02 13:37:31', '2016-06-02 13:37:31', '24'), ('11', 'soy el tercer comentario espero que con esto ya se arregle el problema', '15', 'Historia_proyecto.doc', '2016-06-02 13:37:39', '2016-06-02 13:37:39', '24'), ('12', 'comentario 2 soy otro comentario que bien', '13', 'GOL-BMS-FO-12 Tatiana Toro 2016 (Reparado).xlsx', '2016-06-02 08:38:21', '2016-06-02 08:38:21', '24'), ('13', 'soy otra subida ', '13', 'Git.pdf', '2016-06-02 08:39:00', '2016-06-02 08:39:00', '24');
COMMIT;

-- ----------------------------
-- Table structure for empresa
-- ----------------------------
DROP TABLE IF EXISTS `empresa`;
CREATE TABLE `empresa` (
`idempresa`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`representante_legal`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`cargo`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`sector_id`  int(100) NOT NULL ,
`industria_id`  int(100) NOT NULL ,
`estado`  tinyint(1) NOT NULL ,
`comentario`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`path`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL ,
`factores`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Ninguno' ,
`aspectos`  varchar(35) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'Ninguno' ,
`calificacion`  int(11) NULL DEFAULT NULL ,
`created_at`  datetime NOT NULL ,
`updated_at`  datetime NOT NULL ,
PRIMARY KEY (`idempresa`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of empresa
-- ----------------------------
BEGIN;
INSERT INTO `empresa` VALUES ('1', 'SCHLUMBERGER', 'Camilo Ruiz', '', '1', '1', '0', 'Empresa de petroleos', '46logo_schlumberger.png', '1,2', '1,2', '1', '2016-05-22 13:12:46', '2016-05-31 09:26:07'), ('2', 'TecniControl', 'Juan Perez', '', '2', '3', '0', 'dedicada al sector ambiental y salud', '40logo_tecnicontrol.png', '1', 'Ninguno', '2', '2016-05-22 13:52:40', '2016-05-31 09:18:08'), ('3', 'PANTHERS MACHINERY', 'Mauricio Vargas', 'Administrador de proyectos', '1', '4', '0', 'Empresa dedicada al sector ambiental y cumplimento en los estandares de calidad', '22logo_panthers.png', '3,9', '2', '1', '2016-05-22 14:11:22', '2016-05-31 09:28:53');
COMMIT;

-- ----------------------------
-- Table structure for EstadoCumplimiento
-- ----------------------------
DROP TABLE IF EXISTS `EstadoCumplimiento`;
CREATE TABLE `EstadoCumplimiento` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`Requisito`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`EvidenciaEsperada`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`Responsable`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`AreaAplicacion`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=15

;

-- ----------------------------
-- Records of EstadoCumplimiento
-- ----------------------------
BEGIN;
INSERT INTO `EstadoCumplimiento` VALUES ('1', '¿Está en curso algún procedimiento sancionatorio ambiental desde la autoridad competente en la jurisdicción de la facilidad?', 'Evidenciar los registros del tramite y la pertinencia de los mismos', 'Líder HSE', 'HSE', '2016-05-18 13:14:57', '2016-05-18 13:14:57'), ('2', 'Están definidas e implementadas las responsabilidades en materia ambiental son, como mínimo: velar por el cumplimiento de la normatividad ambiental; prevenir, minimizar y controlar la generación de cargas contaminantes; promover prácticas de producción má', 'Documento en el que se describa  las responsabilidades\nEvidencias de la comunicación de las responsabilidades del rol, ej.\n* Registros (memorando, circular, acta, e-mail, etc..).\n* Los empleados que asumen la responsabilidad en DGA son idóneos y competent', 'Líder HSE', 'HSE', '2016-05-18 13:14:57', '2016-05-18 13:14:57'), ('3', 'En comunicado firmado por el   representante legal de la empresa o su apoderado, se ha informado al la autoridad ambiental sobre la creación y funcionamiento del \"Departamento de Gestión Ambiental\", precisando las funciones y responsabilidades asignadas a', 'Comunicado a cada una de las autoridades ambientales competentes para cada una de las bases, firmado por el representante legal o su apoderado, con sello de radicado ante la autoridad ambiental.', 'Líder HSE', 'HSE', '2016-05-18 13:14:57', '2016-05-18 13:14:57'), ('4', 'requisito respecto al 4', 'evidencia respecto al 4 , esto es una prueba de le evidencia', 'el responsable de prueba', 'area de aplicación 0', '2016-05-25 14:40:48', '2016-05-25 14:40:48'), ('5', 'Se debe tener el reglamento interno de trabajo', 'reglamento interno de trabajo', 'Recursos humanos', '', '2016-05-26 16:34:17', '2016-05-26 16:34:17'), ('7', 'Requisito ambiental1', 'Evidencia ambiental 1', 'Responsable ambiental', 'ambiental', '2016-05-31 13:15:42', '2016-05-31 13:15:42'), ('8', 'requisito respecto al 8', 'evidencia respecto al 8 , esto es una prueba de le evidencia', 'Responsable ambiental', 'ambiental', '2016-05-31 13:24:30', '2016-05-31 13:24:30'), ('9', 'Requisito ambiental1', 'asads', 'dsadasd', 'dadasdasd', '2016-05-31 13:26:07', '2016-05-31 13:26:07'), ('10', 'fdfsdf', 'fsdfsdf', 'fsdfsdf', 'fsdfsdf', '2016-05-31 13:30:20', '2016-05-31 13:30:20'), ('11', 'fdsfsdf', 'fsdfsdf', 'fsdfsdf', 'fsdfsdf', '2016-05-31 13:35:29', '2016-05-31 13:35:29'), ('12', 'requisito 1', 'evidencia1', 'responsable1', 'area 0', '2016-05-31 15:49:08', '2016-05-31 15:49:08'), ('13', 'requisito legal2', 'evidencia esperada 2', 'responsable numero 2', 'area aplicacion 2', '2016-06-01 14:15:12', '2016-06-01 14:15:12'), ('14', 'requisito numero 3', 'Evidencia ambiental 3', 'responsable numero 3', 'area 3', '2016-06-01 14:52:50', '2016-06-01 14:52:50');
COMMIT;

-- ----------------------------
-- Table structure for Evaluacion
-- ----------------------------
DROP TABLE IF EXISTS `Evaluacion`;
CREATE TABLE `Evaluacion` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`Fecha`  date NOT NULL ,
`Calificacion`  int(11) NOT NULL ,
`EvidenciaCumplimiento`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`id_Requisito`  int(11) NOT NULL ,
`created_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
`Fecha2`  date NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=17

;

-- ----------------------------
-- Records of Evaluacion
-- ----------------------------
BEGIN;
INSERT INTO `Evaluacion` VALUES ('1', '2016-05-11', '100', 'evidencia de cumplimiento 1', '1', '2016-05-31 21:10:28', '2016-05-31 21:10:28', '2017-05-11'), ('2', '2016-05-23', '100', 'evidencia de cumplimiento 2', '1', '2016-05-31 21:10:29', '2016-05-31 21:10:29', '2017-05-11'), ('3', '2016-05-27', '100', 'evidencia de cumplimiento 3', '1', '2016-05-31 21:10:35', '2016-05-31 21:10:35', '2017-05-11'), ('4', '2016-06-15', '100', 'evidencia de cumplimiento 4', '1', '2016-05-31 21:10:37', '2016-05-31 21:10:37', '2017-05-11'), ('5', '2016-05-04', '100', 'evidencia de cumplimiento 1 requisito 2', '2', '2016-05-31 21:10:40', '2016-05-31 21:10:40', '2017-05-11'), ('6', '2016-06-07', '0', 'evidencia de cumplimiento 2 requisito 2', '2', '2016-05-31 21:10:42', '2016-05-31 21:10:42', '2017-05-11'), ('7', '2016-05-26', '100', 'lo que sea ', '5', '2016-05-31 21:10:44', '2016-05-31 21:10:44', '2017-05-11'), ('8', '2016-05-17', '100', 'evidencia de cumplimiento ambiental', '7', '2016-05-31 21:10:46', '2016-05-31 21:10:46', '2017-05-11'), ('9', '2016-05-31', '100', 'evidencia de cumplimiento 8', '8', '2016-05-31 21:10:50', '2016-05-31 21:10:50', '2017-05-11'), ('10', '2016-05-31', '100', 'sdasdsadasdasdasd', '9', '2016-05-31 21:10:52', '2016-05-31 21:10:52', '2017-05-11'), ('11', '2016-05-31', '100', 'fdsfsdfsdf', '10', '2016-05-31 21:10:55', '2016-05-31 21:10:55', '2017-05-11'), ('12', '2016-06-01', '100', 'fsdfsdfsdf', '11', '2016-05-31 21:11:00', '2016-05-31 21:11:00', '2017-05-11'), ('13', '2016-05-31', '100', 'evidencia de cumplimiento 1', '12', '2016-05-31 16:47:54', '2016-05-31 16:47:54', '2017-05-31'), ('14', '2016-06-01', '100', 'evidencia de cumplimiento 2', '13', '2016-06-01 14:37:04', '2016-06-01 14:37:04', '2017-06-01'), ('15', '2016-07-04', '100', 'evidencia numero 4', '14', '2016-06-01 14:53:22', '2016-06-01 14:53:22', '2016-07-06'), ('16', '2016-06-18', '100', 'czxczxczxc', '14', '2016-06-01 14:54:06', '2016-06-01 14:54:06', '2016-06-16');
COMMIT;

-- ----------------------------
-- Table structure for factor_riesgo
-- ----------------------------
DROP TABLE IF EXISTS `factor_riesgo`;
CREATE TABLE `factor_riesgo` (
`idfactor_riesgo`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at`  date NOT NULL ,
`updated_at`  date NOT NULL ,
PRIMARY KEY (`idfactor_riesgo`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=13

;

-- ----------------------------
-- Records of factor_riesgo
-- ----------------------------
BEGIN;
INSERT INTO `factor_riesgo` VALUES ('1', 'Ambiente y Desarrollo', '2016-04-20', '2016-04-20'), ('2', 'Salud Ocupacional y Ambiente', '2016-04-13', '2016-04-13'), ('3', 'Salud Ocupacional', '2016-04-13', '2016-04-13'), ('4', 'Seguridad Informatica', '2016-04-12', '2016-04-12'), ('5', 'Seguridad Indistrial', '2016-04-13', '2016-04-13'), ('6', 'Deportes y Cultura', '2016-04-13', '2016-04-13'), ('7', 'Recreación y Deporte ', '2016-04-13', '2016-04-26'), ('8', 'Infraestructura y Vivienda ', '2016-04-13', '2016-04-13'), ('9', 'Caídas de nivel', '2016-05-22', '2016-05-22'), ('10', 'Intoxicación por gases ', '2016-05-22', '2016-05-22'), ('11', ' Psicosocial', '2016-05-26', '2016-05-26'), ('12', 'Biomecanico', '2016-05-26', '2016-05-26');
COMMIT;

-- ----------------------------
-- Table structure for HistoricoMigracion
-- ----------------------------
DROP TABLE IF EXISTS `HistoricoMigracion`;
CREATE TABLE `HistoricoMigracion` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`usuario_id`  int(11) NOT NULL ,
`empresa_id`  int(11) NOT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`id`, `usuario_id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=6

;

-- ----------------------------
-- Records of HistoricoMigracion
-- ----------------------------
BEGIN;
INSERT INTO `HistoricoMigracion` VALUES ('5', 'Migracion 1 de schumberger', '24', '1', '2016-06-02 14:37:18', '2016-06-02 14:37:18');
COMMIT;

-- ----------------------------
-- Table structure for industria
-- ----------------------------
DROP TABLE IF EXISTS `industria`;
CREATE TABLE `industria` (
`idindustria`  int(200) NOT NULL ,
`sector_id`  int(11) NOT NULL ,
`industria`  varchar(150) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of industria
-- ----------------------------
BEGIN;
INSERT INTO `industria` VALUES ('1', '1', 'agricultura '), ('2', '1', 'ganadería'), ('3', '1', 'pesca'), ('4', '1', 'silvicultura'), ('5', '2', 'textil'), ('6', '2', 'quimica'), ('7', '2', 'alimentaria'), ('8', '3', 'transporte de carga '), ('9', '3', ' transporte público'), ('10', '3', ' transporte terrestre'), ('11', '3', ' transporte  aéreo'), ('12', '3', ' transporte marítimo'), ('13', '4', 'Bancarias y  Financieras'), ('14', '4', 'Aseguradoras'), ('15', '4', 'Pensiones y cesantías '), ('16', '4', 'fiduciarias');
COMMIT;

-- ----------------------------
-- Table structure for MigracionMatriz
-- ----------------------------
DROP TABLE IF EXISTS `MigracionMatriz`;
CREATE TABLE `MigracionMatriz` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`id_requisito`  int(10) NOT NULL ,
`id_cumplimiento`  int(11) NOT NULL ,
`id_evaluacion`  int(10) NOT NULL ,
`id_usuario`  int(10) NULL DEFAULT NULL ,
`id_historico`  int(11) NOT NULL DEFAULT 0 ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=5

;

-- ----------------------------
-- Records of MigracionMatriz
-- ----------------------------
BEGIN;
INSERT INTO `MigracionMatriz` VALUES ('1', '12', '12', '13', '24', '5'), ('2', '13', '13', '14', '24', '5'), ('3', '14', '14', '15', '24', '5'), ('4', '14', '14', '16', '24', '0');
COMMIT;

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations` (
`migration`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`batch`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Records of migrations
-- ----------------------------
BEGIN;
INSERT INTO `migrations` VALUES ('2014_10_12_000000_create_users_table', '1'), ('2016_05_23_115121_CreateEvaluacion', '2'), ('2016_05_27_081843_CreateMigracionMatriz', '3'), ('2016_05_30_164836_CreateAspectoAmbiental', '4'), ('2016_05_30_164902_CreateCategoriaAmbiental', '4'), ('2016_05_31_163501_CreateComentario', '5'), ('2016_06_02_093841_CreateHistoricMigracion', '6');
COMMIT;

-- ----------------------------
-- Table structure for normas
-- ----------------------------
DROP TABLE IF EXISTS `normas`;
CREATE TABLE `normas` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`numero_norma`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`descripcion_norma`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`tipo_norma_id`  int(11) NOT NULL ,
`yearemision_id`  int(11) NOT NULL ,
`fecha`  date NOT NULL ,
`autoridad_emisora_id`  int(11) NOT NULL ,
`clase_norma_id`  int(11) NOT NULL ,
`norma_relacionadas`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=11

;

-- ----------------------------
-- Records of normas
-- ----------------------------
BEGIN;
INSERT INTO `normas` VALUES ('1', '1333', 'Por el cual se adoptan normas sobre funciones que afecte al medio ambiente', '7', '9', '2016-04-11', '1', '3', 'Ley 99 de 1993, Congreso de la República, Art. 66\r\nLey 768 de 2002, Congreso de la República, Art. 13', '2016-05-26 21:30:06', '2016-05-26 16:30:06'), ('2', '1076', 'Este decreto vela por la integridad en la gestión ambiental', '1', '10', '2016-05-02', '2', '3', 'Deroga los art. 5,6 y 7 del Decreto 1299 de 2008', '2016-05-23 02:53:18', '2016-05-22 21:53:18'), ('3', '486', 'Esta resolución se enfoca a temas relacionados con desarrollo territorial ', '9', '6', '2002-05-12', '5', '3', 'Estatuto Tributario, Artículos 424-5 numeral 4 y 428 literal f) ', '2016-05-27 12:40:03', '2016-05-27 07:40:03'), ('4', '5678', 'Ley que aplica para la nueva gestion de basuras en empresa', '7', '12', '2006-05-04', '6', '1', 'Esta norma sigue vigente actualmente', '2016-05-23 01:43:18', '2016-05-22 14:49:09'), ('5', '345', 'Norma que derogada a los relacionados al articulos 2', '4', '8', '2004-03-12', '7', '2', 'derogada la norma con id 2', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('6', '1010', 'Ley de acoso laboral', '7', '15', '2010-05-26', '1', '3', 'No aplica', '2016-05-27 12:33:34', '2016-05-27 07:33:34'), ('7', '652', '', '1', '1', '2016-05-06', '1', '3', 'No aplica', '2016-05-27 12:38:47', '2016-05-27 07:38:47'), ('8', '6352', 'deroga a la 1010', '1', '18', '2012-05-19', '11', '1', '', '2016-05-27 07:33:34', '2016-05-27 07:33:34'), ('9', '782', 'deroga a la 652', '3', '1', '2016-06-02', '1', '2', 'No aplica', '2016-05-27 07:38:47', '2016-05-27 07:38:47'), ('10', '700', 'deroga a la 486', '3', '1', '2016-05-03', '1', '2', 'No aplica', '2016-05-27 07:40:03', '2016-05-27 07:40:03');
COMMIT;

-- ----------------------------
-- Table structure for password_resets
-- ----------------------------
DROP TABLE IF EXISTS `password_resets`;
CREATE TABLE `password_resets` (
`email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`token`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Records of password_resets
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for Relacionderogada
-- ----------------------------
DROP TABLE IF EXISTS `Relacionderogada`;
CREATE TABLE `Relacionderogada` (
`id`  int(11) NOT NULL AUTO_INCREMENT ,
`campo_derogado`  varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`campo_asignado`  varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`tabla_asociada`  varchar(35) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=29

;

-- ----------------------------
-- Records of Relacionderogada
-- ----------------------------
BEGIN;
INSERT INTO `Relacionderogada` VALUES ('1', '8', '10', 'articulos', '2016-05-23 02:03:51', '2016-05-20 21:25:44'), ('2', '9', '11', 'articulos', '2016-05-23 02:03:55', '2016-05-20 21:30:08'), ('3', '2', '13', 'articulos', '2016-05-23 02:11:10', '2016-05-22 17:35:53'), ('4', '2', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('5', '3', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('6', '5', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('7', '6', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('8', '7', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('9', '8', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('10', '12', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('11', '13', 'norma asociada derogada', 'articulos', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('12', '2', '4', 'normas', '2016-05-22 21:53:18', '2016-05-22 21:53:18'), ('13', '14', '15', 'articulos', '2016-05-26 16:25:49', '2016-05-26 16:25:49'), ('14', '1', 'norma asociada derogada', 'articulos', '2016-05-26 16:30:06', '2016-05-26 16:30:06'), ('15', '9', 'norma asociada derogada', 'articulos', '2016-05-26 16:30:06', '2016-05-26 16:30:06'), ('16', '10', 'norma asociada derogada', 'articulos', '2016-05-26 16:30:06', '2016-05-26 16:30:06'), ('17', '11', 'norma asociada derogada', 'articulos', '2016-05-26 16:30:06', '2016-05-26 16:30:06'), ('18', '1', '6', 'normas', '2016-05-26 16:30:06', '2016-05-26 16:30:06'), ('19', '14', 'norma asociada derogada', 'articulos', '2016-05-27 07:33:34', '2016-05-27 07:33:34'), ('20', '15', 'norma asociada derogada', 'articulos', '2016-05-27 07:33:34', '2016-05-27 07:33:34'), ('21', '6', '8', 'normas', '2016-05-27 12:36:13', '2016-05-27 07:33:34'), ('26', '18', '19', 'articulos', '2016-05-31 14:58:23', '2016-05-31 14:58:23'), ('27', '19', '20', 'articulos', '2016-05-31 14:59:12', '2016-05-31 14:59:12'), ('28', '21', '22', 'articulos', '2016-05-31 15:44:23', '2016-05-31 15:44:23');
COMMIT;

-- ----------------------------
-- Table structure for RequisitosMatriz
-- ----------------------------
DROP TABLE IF EXISTS `RequisitosMatriz`;
CREATE TABLE `RequisitosMatriz` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`FactorRiesgo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`Grupo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`CategoriaRiesgo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`TipoNorma`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`Numero`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`AñoEmision`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`AutoridadEmite`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`ArticuloAplica`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`LitNum`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`NormasRelacionadas`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`Norma`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT 'NO APLICA' ,
`created_at`  timestamp NOT NULL ,
`updated_at`  timestamp NOT NULL ,
`empresa`  int(11) NOT NULL ,
`Ambiental`  tinyint(1) NOT NULL DEFAULT 0 ,
`Estadoarticulo`  varchar(35) CHARACTER SET latin1 COLLATE latin1_swedish_ci NOT NULL DEFAULT 'Vigente' ,
PRIMARY KEY (`id`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=latin1 COLLATE=latin1_swedish_ci
AUTO_INCREMENT=15

;

-- ----------------------------
-- Records of RequisitosMatriz
-- ----------------------------
BEGIN;
INSERT INTO `RequisitosMatriz` VALUES ('12', 'Ambiente y Desarrollo', 'Suelo', 'Seguro ecológico', 'Acuerdo', '782', '2016', 'Congreso \r\nde la República', '5678', 'No aplica', 'No aplica', 'NO APLICA', '2016-05-31 14:35:11', '2016-05-31 14:35:11', '1', '0', 'Vigente'), ('13', 'Ambiente y Desarrollo', 'Suelo', 'Seguro ecológico', 'Ley', '5678', '2006', 'Ministerio  de Salud', '5', 'No aplica', 'Esta norma sigue vigente actualmente', 'NO APLICA', '2016-05-31 14:58:40', '2016-05-31 14:58:40', '1', '0', 'Vigente'), ('14', 'Ambiente y Desarrollo', 'Energía ', 'Desarrollo web', 'Circular Externa ', '345', '2004', 'Ministerio de Comercio Exterior ', '1', 'No aplica', 'derogada la norma con id 2', 'NO APLICA', '2016-05-31 15:31:10', '2016-05-31 15:44:23', '1', '0', 'Derogado');
COMMIT;

-- ----------------------------
-- Table structure for rol
-- ----------------------------
DROP TABLE IF EXISTS `rol`;
CREATE TABLE `rol` (
`idrol`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
PRIMARY KEY (`idrol`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=4

;

-- ----------------------------
-- Records of rol
-- ----------------------------
BEGIN;
INSERT INTO `rol` VALUES ('1', 'Administrador'), ('2', 'Consultor'), ('3', 'Cliente');
COMMIT;

-- ----------------------------
-- Table structure for sector
-- ----------------------------
DROP TABLE IF EXISTS `sector`;
CREATE TABLE `sector` (
`idsector`  int(200) NOT NULL ,
`sector`  varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of sector
-- ----------------------------
BEGIN;
INSERT INTO `sector` VALUES ('1', 'Agropecuario'), ('2', 'Industrial'), ('3', 'Transporte'), ('4', 'Financiera');
COMMIT;

-- ----------------------------
-- Table structure for sub_factor_riesgo
-- ----------------------------
DROP TABLE IF EXISTS `sub_factor_riesgo`;
CREATE TABLE `sub_factor_riesgo` (
`idsub_factor_riesgo`  int(11) NOT NULL AUTO_INCREMENT ,
`factor_riesgo_id`  int(11) NOT NULL ,
`nombre`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at`  date NOT NULL ,
`updated_at`  date NOT NULL ,
PRIMARY KEY (`idsub_factor_riesgo`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=11

;

-- ----------------------------
-- Records of sub_factor_riesgo
-- ----------------------------
BEGIN;
INSERT INTO `sub_factor_riesgo` VALUES ('1', '1', 'Departamento de Gestión Ambiental', '2016-05-18', '2016-05-18'), ('2', '2', 'Accidentes de tránsito en el transporte de me', '2016-05-18', '2016-05-18'), ('3', '3', 'vial', '2016-05-18', '2016-05-18'), ('4', '1', 'Seguro ecológico', '2016-05-18', '2016-05-18'), ('5', '4', 'Calidad de software ', '2016-05-18', '2016-05-18'), ('6', '3', 'Salud en el trabajo', '2016-05-18', '2016-05-18'), ('7', '9', 'Caída de maquinaria ', '2016-05-22', '2016-05-22'), ('8', '9', 'Caída en Oficinas', '2016-05-22', '2016-05-22'), ('9', '1', 'Desarrollo web', '2016-05-22', '2016-05-22'), ('10', '12', 'Manejo de cargas', '2016-05-26', '2016-05-26');
COMMIT;

-- ----------------------------
-- Table structure for temas_grupo
-- ----------------------------
DROP TABLE IF EXISTS `temas_grupo`;
CREATE TABLE `temas_grupo` (
`idtema`  int(11) NOT NULL AUTO_INCREMENT ,
`tema`  varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP ,
PRIMARY KEY (`idtema`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=17

;

-- ----------------------------
-- Records of temas_grupo
-- ----------------------------
BEGIN;
INSERT INTO `temas_grupo` VALUES ('1', 'Administrativo', '2016-05-09 14:05:38', '2016-05-31 19:05:42'), ('2', 'Energía ', '2016-05-09 14:05:38', '2016-05-31 19:05:49'), ('3', 'Agua', '2016-05-09 14:05:38', '2016-05-31 19:05:51'), ('4', 'Vertimientos', '2016-05-09 14:05:38', '2016-05-31 19:05:54'), ('5', 'Emergencias y Contingencias', '2016-05-09 14:05:38', '2016-05-31 19:05:56'), ('6', 'Aire', '2016-05-09 14:05:38', '2016-05-31 19:05:58'), ('7', 'Quimico', '2016-05-09 14:05:38', '2016-05-31 19:06:00'), ('8', 'Control sustancias', '2016-05-09 14:05:38', '2016-05-31 19:06:02'), ('9', 'Comunidad', '2016-05-09 14:05:38', '2016-05-31 19:06:04'), ('10', 'Flora', '2016-05-09 14:05:38', '2016-05-31 19:06:06'), ('11', 'Residuos  ', '2016-05-09 14:05:38', '2016-05-31 19:06:08'), ('12', 'Paisajismo', '2016-05-09 14:05:38', '2016-05-31 19:06:10'), ('13', 'Radiactivos', '2016-05-09 14:05:38', '2016-05-31 19:06:12'), ('14', 'Suelo', '2016-05-09 14:05:38', '2016-05-31 19:06:14'), ('15', 'Transporte', '2016-05-09 14:05:38', '2016-05-31 19:06:19'), ('16', 'Gestion de calidad', '2016-05-31 14:06:39', '2016-05-31 14:06:39');
COMMIT;

-- ----------------------------
-- Table structure for test_chart
-- ----------------------------
DROP TABLE IF EXISTS `test_chart`;
CREATE TABLE `test_chart` (
`id`  tinyint(11) NOT NULL ,
`calificacion`  int(11) NOT NULL 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci

;

-- ----------------------------
-- Records of test_chart
-- ----------------------------
BEGIN;
INSERT INTO `test_chart` VALUES ('1', '100'), ('2', '100'), ('3', '100'), ('4', '100'), ('5', '100'), ('6', '100'), ('7', '100'), ('8', '100'), ('9', '0'), ('10', '0');
COMMIT;

-- ----------------------------
-- Table structure for tipo_norma
-- ----------------------------
DROP TABLE IF EXISTS `tipo_norma`;
CREATE TABLE `tipo_norma` (
`idtipo_norma`  int(11) NOT NULL AUTO_INCREMENT ,
`nombre`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`descripcion`  varchar(300) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`idtipo_norma`)
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=11

;

-- ----------------------------
-- Records of tipo_norma
-- ----------------------------
BEGIN;
INSERT INTO `tipo_norma` VALUES ('1', 'Decretos', 'Son  actos administrativos que posee un contenido normativo reglamentario.', '2016-04-15 20:32:14', '2016-05-12 19:28:18'), ('2', 'Decreto- Ley', 'Es una norma con rango de Ley sin que medie autorización previa de un congreso', '2016-04-15 20:32:14', '2016-04-26 14:13:43'), ('3', 'Acuerdo', 'Este acuerdo tiene como fin de proteger el medio ambiente', '2016-04-20 21:02:02', '2016-04-26 13:54:07'), ('4', 'Circular Externa ', 'Relacionado al medio  ambiente  ', '2016-04-21 21:12:08', '2016-04-26 13:55:11'), ('5', 'Resolución', 'Esta resolución esta enfocada al medio Ambiente ', '2016-04-21 21:12:21', '2016-04-26 13:51:09'), ('6', 'ISO - NTC Normas Técnicas Colombianas ', 'Norma establecidas para estandarizar procesos', '2016-04-26 14:28:08', '2016-04-26 14:28:08'), ('7', 'Ley', 'Regla o norma establecida por una autoridad superior para regular un aspecto', '2016-04-26 14:32:09', '2016-04-26 14:32:09'), ('8', 'NTC', 'Normas Tecnicas  Colombianas', '2016-04-26 14:34:27', '2016-04-26 14:34:27'), ('9', 'Resolución', 'Se conoce como resolución al  fallo o decisión que se emite por autoridad juducial ', '2016-04-26 15:01:41', '2016-04-26 15:01:41'), ('10', 'Juridica', '', '2016-05-22 17:47:05', '2016-05-22 17:47:05');
COMMIT;

-- ----------------------------
-- Table structure for users
-- ----------------------------
DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
`id`  int(10) UNSIGNED NOT NULL AUTO_INCREMENT ,
`name`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`email`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`password`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`created_at`  timestamp NULL DEFAULT NULL ,
`updated_at`  timestamp NULL DEFAULT NULL ,
PRIMARY KEY (`id`),
UNIQUE INDEX `users_email_unique` (`email`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci
AUTO_INCREMENT=1

;

-- ----------------------------
-- Records of users
-- ----------------------------
BEGIN;
COMMIT;

-- ----------------------------
-- Table structure for usuarios
-- ----------------------------
DROP TABLE IF EXISTS `usuarios`;
CREATE TABLE `usuarios` (
`idusuario`  int(11) NOT NULL AUTO_INCREMENT ,
`rol_id`  int(11) NOT NULL ,
`nombre`  varchar(50) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`usuario`  varchar(45) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL ,
`password`  varchar(60) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`remember_token`  varchar(100) CHARACTER SET utf8 COLLATE utf8_unicode_ci NULL DEFAULT NULL ,
`correo`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`EmpresasPermiso`  varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT 'ninguna' ,
`estado`  tinyint(1) NOT NULL ,
`created_at`  date NOT NULL ,
`updated_at`  date NOT NULL ,
PRIMARY KEY (`idusuario`),
FOREIGN KEY (`rol_id`) REFERENCES `rol` (`idrol`) ON DELETE NO ACTION ON UPDATE NO ACTION,
INDEX `fk_usuario_rol1_idx` (`rol_id`) USING BTREE 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_general_ci
AUTO_INCREMENT=31

;

-- ----------------------------
-- Records of usuarios
-- ----------------------------
BEGIN;
INSERT INTO `usuarios` VALUES ('1', '1', 'Tatiana', 'ttoro', '$2y$10$2dQmb3XXPcBcY88999MP3.WEHoEOrvoZKt/eOsrHV5kKFRvbSp116', null, 'tatianatoro22@gmail.com', 'ninguna', '1', '2016-04-01', '2016-05-06'), ('2', '3', 'Felipe G', 'fforero', 'forero2015', null, 'felipe22@gmail.com', 'ninguna', '3', '2016-04-01', '2016-04-01'), ('3', '2', 'Cesar Merchan', 'cmerchan', '$2y$10$a5OuQi7hhwS2/IKzKg9TyOjD3FaJCsfOmVggV14N/bzFlIbolfYJG', 'zsuw5JhayYLR6ZOHMN7fgim9xFm855XxiasGkoJMImXn1guQLJkbhmGm7k5q', 'cesarmerchan@gmail.com', '2', '1', '2016-04-01', '2016-05-13'), ('5', '1', 'Moiseis Forero', 'MoseisAs', '$2y$10$iq/JCmg54aHWOjnJz8QgZOZR55kgEB6XLfSun/zxhAnuYWd7wIjPe', null, 'moiseas@sadasdasd.com', 'ninguna', '3', '2016-03-16', '2016-05-04'), ('8', '3', 'pruebazord', 'prueba', 'dsdsdsd', null, 'asasas@asasas.com', 'ninguna', '0', '2016-03-17', '2016-05-06'), ('9', '2', 'JoseHernandez', 'Jose', 'Joseelduro', null, 'jose@unjuk.com', 'ninguna', '0', '2016-03-17', '2016-03-17'), ('10', '3', 'Andres Bonilla', 'AndresB', 'asasdsdsd', null, 'asasas@asasas.com', 'ninguna', '0', '2016-03-17', '2016-03-17'), ('14', '2', 'Jesus Vega', 'Jvega', '$2y$10$ujD2.HMq.Mapfzsh2UGSteYBVMci6FcgGBGDOLDiJ5XGZGXJohUFy', 'y30SpFqXy1utCuLUfcD9hyg9oG5SxhRIMciR1eFmwokc07qkkp8L4tkb2MRZ', 'ventas.javc@gmail.com', '1,3', '0', '2016-03-22', '2016-05-16'), ('16', '2', 'camilo Andres', 'jklion', 'dsdsdsdsd', null, 'mariosdg@hotmail.com', '1,3', '0', '2016-03-22', '2016-05-13'), ('17', '1', 'mario alfonso lopez', 'marolope', 'dssasds', null, 'ma@jkl.com', 'ninguna', '0', '2016-03-22', '2016-03-22'), ('24', '1', 'Alexander Vega', 'Alexveg', '$2y$10$DYlLRBkrO0RRwwhWizRsOOII8yYp9WZ4SgjG/KUodgWSc1bM7FGFS', 'wMHotZLg2nzncwiBbM8OKLUmnRFuTaHNPp6RtQZmiS5ubkIMYRIB8jRzDiGI', 'alexveg@sig.com', 'ninguna', '0', '2016-03-30', '2016-06-01'), ('25', '2', 'Francisco Ramirez ', 'Franciscor', '$2y$10$Gc95qNZ21QpGfO4kzzaQrOkeD79VDVApRJm4zVKvz1KP5sweyleyy', '9eUVqa3aK334NKWRads8dOXelmELCvMAzJ8rIz584p6DRLkqsytFFOQohIfU', 'sdsdsdsd@dsdsdsds.com', 'ninguna', '0', '2016-04-01', '2016-05-13'), ('26', '1', 'Natalia Toro', 'natat', '$2y$10$KlwT3glm40ssBq8GpjOl..4gUXb9Iie7HrzCn8sBWeV5LWBgHPBpu', null, 'natalia@gmail.com', 'ninguna', '0', '2016-04-06', '2016-04-06'), ('27', '2', 'James Rodriguez', 'Jrodriguez', '$2y$10$82I1IDMbYbhhCJzjNDCcuevv37X0pch8TgC5.Cp675w6HfX12jh1a', null, 'james@gmail.com', 'ninguna', '0', '2016-04-13', '2016-04-13'), ('28', '1', 'Marcos Bacca', 'mtoro', '$2y$10$8oQaetJdtZZbPmL/k8i0vuWNEySwH9yH6pdB67at1LtvLz5D3Z4Ra', null, 'marcos@gmail.com', 'ninguna', '3', '2016-04-20', '2016-04-20'), ('29', '3', 'Mario Gimenez', 'MarioGi', '$2y$10$b0h6kTdQ4H04dYOOyvOP0ucgOaxnOLiZaVrapcTT5C2ro9436UUEW', 'jcHLxkjlnOpM9z8b0EuLw6doJDONHv8Wc9cDIzvNgyBgrHyjRKYiotwSiYom', 'marioGimenez@gmail.com', 'ninguna', '0', '2016-05-13', '2016-05-13'), ('30', '3', 'Diana Ramirez', 'Diana Ra', '$2y$10$grL0m8hYc5r1lPOUHaGS3u6.E8TUDkFRXwsp74FJ/Atm8yqHbwxu.', null, 'dianarg@hotmail.com', 'ninguna', '0', '2016-05-22', '2016-05-22');
COMMIT;

-- ----------------------------
-- Table structure for yearemision
-- ----------------------------
DROP TABLE IF EXISTS `yearemision`;
CREATE TABLE `yearemision` (
`id`  int(10) UNSIGNED NOT NULL ,
`year`  varchar(255) CHARACTER SET utf8 COLLATE utf8_unicode_ci NOT NULL ,
`created_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP ,
`updated_at`  timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP 
)
ENGINE=InnoDB
DEFAULT CHARACTER SET=utf8 COLLATE=utf8_unicode_ci

;

-- ----------------------------
-- Records of yearemision
-- ----------------------------
BEGIN;
INSERT INTO `yearemision` VALUES ('1', '2016', '2016-05-16 15:42:51', '2016-05-20 12:18:06'), ('2', '2011', '2016-05-16 15:42:51', '2016-05-20 12:18:06'), ('3', '1978', '2016-05-18 22:58:24', '2016-05-18 20:48:34'), ('4', '2000', '2016-05-18 20:49:26', '2016-05-18 20:49:26'), ('5', '2001', '2016-05-19 21:44:07', '2016-05-20 12:18:06'), ('6', '2002', '2016-05-19 21:44:07', '2016-05-20 12:18:06'), ('7', '2003', '2016-05-19 21:44:25', '2016-05-20 12:18:06'), ('8', '2004', '2016-05-19 21:44:25', '2016-05-20 12:18:06'), ('9', '2009', '2016-05-19 21:45:26', '2016-05-20 12:18:06'), ('10', '2015', '2016-05-19 21:45:26', '2016-05-20 12:18:06'), ('11', '2005', '2016-05-20 12:18:06', '2016-05-20 12:18:06'), ('12', '2006', '2016-05-20 12:18:14', '2016-05-20 12:18:14'), ('13', '2007', '2016-05-20 12:18:25', '2016-05-20 12:18:25'), ('14', '2008', '2016-05-20 12:18:48', '2016-05-20 12:18:48'), ('15', '2010', '2016-05-20 12:19:45', '2016-05-20 12:19:45'), ('16', '2012', '2016-05-20 12:20:02', '2016-05-20 12:20:02'), ('17', '2013', '2016-05-20 12:20:08', '2016-05-20 12:20:08'), ('18', '2014', '2016-05-20 12:20:36', '2016-05-20 12:20:36'), ('19', '1999', '2016-05-20 12:21:48', '2016-05-20 12:21:48'), ('20', '1998', '2016-05-20 12:21:55', '2016-05-20 12:21:55');
COMMIT;

-- ----------------------------
-- Auto increment value for Articulos
-- ----------------------------
ALTER TABLE `Articulos` AUTO_INCREMENT=23;

-- ----------------------------
-- Auto increment value for AspectoAmbiental
-- ----------------------------
ALTER TABLE `AspectoAmbiental` AUTO_INCREMENT=3;

-- ----------------------------
-- Auto increment value for autoridademisora
-- ----------------------------
ALTER TABLE `autoridademisora` AUTO_INCREMENT=15;

-- ----------------------------
-- Auto increment value for CategoriaAmbiental
-- ----------------------------
ALTER TABLE `CategoriaAmbiental` AUTO_INCREMENT=2;

-- ----------------------------
-- Auto increment value for Comentario
-- ----------------------------
ALTER TABLE `Comentario` AUTO_INCREMENT=17;

-- ----------------------------
-- Auto increment value for empresa
-- ----------------------------
ALTER TABLE `empresa` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for EstadoCumplimiento
-- ----------------------------
ALTER TABLE `EstadoCumplimiento` AUTO_INCREMENT=15;

-- ----------------------------
-- Auto increment value for Evaluacion
-- ----------------------------
ALTER TABLE `Evaluacion` AUTO_INCREMENT=17;

-- ----------------------------
-- Auto increment value for factor_riesgo
-- ----------------------------
ALTER TABLE `factor_riesgo` AUTO_INCREMENT=13;

-- ----------------------------
-- Auto increment value for HistoricoMigracion
-- ----------------------------
ALTER TABLE `HistoricoMigracion` AUTO_INCREMENT=6;

-- ----------------------------
-- Auto increment value for MigracionMatriz
-- ----------------------------
ALTER TABLE `MigracionMatriz` AUTO_INCREMENT=5;

-- ----------------------------
-- Auto increment value for normas
-- ----------------------------
ALTER TABLE `normas` AUTO_INCREMENT=11;

-- ----------------------------
-- Auto increment value for Relacionderogada
-- ----------------------------
ALTER TABLE `Relacionderogada` AUTO_INCREMENT=29;

-- ----------------------------
-- Auto increment value for RequisitosMatriz
-- ----------------------------
ALTER TABLE `RequisitosMatriz` AUTO_INCREMENT=15;

-- ----------------------------
-- Auto increment value for rol
-- ----------------------------
ALTER TABLE `rol` AUTO_INCREMENT=4;

-- ----------------------------
-- Auto increment value for sub_factor_riesgo
-- ----------------------------
ALTER TABLE `sub_factor_riesgo` AUTO_INCREMENT=11;

-- ----------------------------
-- Auto increment value for temas_grupo
-- ----------------------------
ALTER TABLE `temas_grupo` AUTO_INCREMENT=17;

-- ----------------------------
-- Auto increment value for tipo_norma
-- ----------------------------
ALTER TABLE `tipo_norma` AUTO_INCREMENT=11;

-- ----------------------------
-- Auto increment value for users
-- ----------------------------
ALTER TABLE `users` AUTO_INCREMENT=1;

-- ----------------------------
-- Auto increment value for usuarios
-- ----------------------------
ALTER TABLE `usuarios` AUTO_INCREMENT=31;
