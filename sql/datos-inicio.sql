-- =============================================================================
-- Seed de datos iniciales para la base de datos control_practicas_db
-- Orden de inserción: roles -> instituciones -> carreras
-- =============================================================================

-- 1. ROLES (Valores permitidos por el ENUM: estudiante, administrador, reclutador)
INSERT INTO roles (id, nombre, descripcion) VALUES
(1, 'estudiante', 'Usuario común del sistema (USER)'),
(2, 'administrador', 'Administrador general del sistema (ADMIN)'),
(3, 'reclutador', 'Usuario reclutador o evaluador')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), descripcion = VALUES(descripcion);

-- 2. INSTITUCIONES
INSERT INTO instituciones (id, nombre, siglas, tipo, contacto_email, sitio_web) VALUES
(1, 'Universidad Mariano Gálvez de Guatemala', 'UMG', 'UNIVERSIDAD', 'info@umg.edu.gt', 'https://umg.edu.gt'),
(2, 'Universidad de San Carlos de Guatemala', 'USAC', 'UNIVERSIDAD', 'informacion@usac.edu.gt', 'https://usac.edu.gt'),
(3, 'Instituto Nacional Central para Varones', 'IN3', 'INSTITUTO', 'contacto@in3.edu.gt', 'https://in3.edu.gt')
ON DUPLICATE KEY UPDATE nombre = VALUES(nombre), siglas = VALUES(siglas), tipo = VALUES(tipo), contacto_email = VALUES(contacto_email), sitio_web = VALUES(sitio_web);

-- 3. CARRERAS
INSERT INTO carreras (id, institucion_id, nombre, codigo) VALUES
-- Carreras para UMG (institucion_id = 1)
(1, 1, 'Ingeniería en Sistemas de Información y Ciencias de la Computación', 'UMG-ISICC'),
(2, 1, 'Ingeniería Industrial', 'UMG-IND'),
(3, 1, 'Ingeniería Civil', 'UMG-CIV'),
(4, 1, 'Licenciatura en Ciencias Jurídicas y Sociales', 'UMG-DER'),
(5, 1, 'Licenciatura en Administración de Empresas', 'UMG-ADM'),

-- Carreras para USAC (institucion_id = 2)
(6, 2, 'Ingeniería en Ciencias y Sistemas', 'USAC-ICS'),
(7, 2, 'Ingeniería Mecánica Eléctrica', 'USAC-IME'),
(8, 2, 'Ingeniería Química', 'USAC-IQ'),
(9, 2, 'Médico y Cirujano', 'USAC-MED'),
(10, 2, 'Licenciatura en Auditoría y Contaduría Pública', 'USAC-CPA'),

-- Carreras/Especialidades para IN3 (institucion_id = 3)
(11, 3, 'Bachillerato en Ciencias y Letras con Orientación en Computación', 'IN3-BCLC'),
(12, 3, 'Perito en Electricidad Industrial', 'IN3-PEI'),
(13, 3, 'Perito en Electrónica Digital', 'IN3-PED'),
(14, 3, 'Perito en Mecánica Automotriz', 'IN3-PMA'),
(15, 3, 'Bachillerato Industrial y Perito en Dibujo Técnico de Ingeniería', 'IN3-BIPD')
ON DUPLICATE KEY UPDATE institucion_id = VALUES(institucion_id), nombre = VALUES(nombre), codigo = VALUES(codigo);
