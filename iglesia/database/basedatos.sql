CREATE DATABASE IF NOT EXISTS iglesia;
USE iglesia;

-- =========================
-- 1. Usuarios del sistema
-- =========================
CREATE TABLE Usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    rol ENUM('visitante','miembro','distrital','nacional','admin') NOT NULL,
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- =========================
-- 2. Distritos e Iglesias
-- =========================
CREATE TABLE Distrito (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    departamento VARCHAR(100)
);

CREATE TABLE Iglesia (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    distrito_id INT NOT NULL,
    direccion VARCHAR(255),
    FOREIGN KEY (distrito_id) REFERENCES Distrito(id)
);

-- =========================
-- 3. Catálogos para tallas de camisa y condiciones médicas
-- =========================
CREATE TABLE Talla_Camisa (
    id INT AUTO_INCREMENT PRIMARY KEY,
    talla ENUM('XS','S','M','L','XL','XXL') UNIQUE NOT NULL
);

CREATE TABLE Condicion_Medica (
    id INT AUTO_INCREMENT PRIMARY KEY,
    descripcion VARCHAR(255) NOT NULL UNIQUE
);

-- =========================
-- 4. Personas
-- =========================
CREATE TABLE Persona (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    apellido VARCHAR(100),
    edad INT,
    genero ENUM('M','F'),
    rol ENUM('visitante','miembro') NOT NULL,
    estado ENUM('pagado','pendiente','parcial') DEFAULT 'pendiente',
    cantidad_pagos DOUBLE DEFAULT 0,
    monto_total DOUBLE DEFAULT 0,
    iglesia_id INT,
    distrito_id INT,
    usuario_id INT, -- Usuario que creó o es responsable
    talla_camisa_id INT,
    condicion_medica_id INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (iglesia_id) REFERENCES Iglesia(id),
    FOREIGN KEY (distrito_id) REFERENCES Distrito(id),
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (talla_camisa_id) REFERENCES Talla_Camisa(id),
    FOREIGN KEY (condicion_medica_id) REFERENCES Condicion_Medica(id)
);

-- =========================
-- 5. Directiva (distrital/nacional)
-- =========================
CREATE TABLE Directiva (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    tipo ENUM('distrital','nacional') NOT NULL,
    distrito_id INT,
    departamento VARCHAR(100),
    fecha_inicio DATE,
    fecha_fin DATE,
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id),
    FOREIGN KEY (distrito_id) REFERENCES Distrito(id)
);

-- =========================
-- 6. Ministerios / Departamentos
-- =========================
CREATE TABLE Departamentos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL UNIQUE,
    descripcion TEXT,
    responsable_id INT,
    estado ENUM('activo','inactivo') DEFAULT 'activo',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (responsable_id) REFERENCES Persona(id)
);

-- =========================
-- 7. Grupos
-- =========================
CREATE TABLE Grupo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    descripcion TEXT,
    creado_por INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id)
);

-- =========================
-- 8. Actividades / Eventos
-- =========================
CREATE TABLE Actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100) NOT NULL,
    fecha DATE NOT NULL,
    hora TIME,
    directiva ENUM('juvenil','femenil','infantil') DEFAULT 'juvenil',
    costo DECIMAL(10,2),
    tipo ENUM('convencion','actividad','vigilia','bautismo','excursion','campamento','otro') DEFAULT 'actividad',
    lugar VARCHAR(255),
    foto_link VARCHAR(255),
    creado_por INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id)
);

-- Tablas especializadas para tipos de actividades
CREATE TABLE Actividad_Vigilia (
    actividad_id INT PRIMARY KEY,
    nombre_vigilia VARCHAR(100),
    departamento VARCHAR(100),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

CREATE TABLE Actividad_Excursion (
    actividad_id INT PRIMARY KEY,
    distrito_proponente INT,
    hora_salida TIME,
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id),
    FOREIGN KEY (distrito_proponente) REFERENCES Distrito(id)
);

CREATE TABLE Actividad_Convencion (
    actividad_id INT PRIMARY KEY,
    fecha_inicio DATE,
    dias INT,
    departamento VARCHAR(100),
    lema VARCHAR(255),
    himno VARCHAR(255),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

CREATE TABLE Actividad_Campamento (
    actividad_id INT PRIMARY KEY,
    fecha_inicio DATE,
    dias INT,
    departamento VARCHAR(100),
    lema VARCHAR(255),
    himno VARCHAR(255),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

-- =========================
-- 9. Personas inscritas a actividades
-- =========================
CREATE TABLE Inscripcion_Actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT NOT NULL,
    actividad_id INT NOT NULL,
    estado ENUM('inscrito','pendiente','cancelado','asistio','no_asistio') DEFAULT 'pendiente',
    fecha_estado TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    observaciones TEXT,
    FOREIGN KEY (persona_id) REFERENCES Persona(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

-- =========================
-- 10. Personas en grupos
-- =========================
CREATE TABLE Persona_Grupo (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT NOT NULL,
    grupo_id INT NOT NULL,
    fecha_union TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (persona_id) REFERENCES Persona(id),
    FOREIGN KEY (grupo_id) REFERENCES Grupo(id)
);

-- =========================
-- 11. Pagos
-- =========================
CREATE TABLE Pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT NOT NULL,
    actividad_id INT,
    monto_total DECIMAL(10,2) NOT NULL, -- Nuevo campo para el monto total del pago.
    fecha_pago TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (persona_id) REFERENCES Persona(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

-- =========================
-- 12. Detalle de los pagos
-- =========================
CREATE TABLE Detalle_Pago (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pago_id INT NOT NULL,
    monto DECIMAL(10,2) NOT NULL,
    metodo_pago ENUM('efectivo','tarjeta','transferencia','otro') DEFAULT 'efectivo',
    fecha_abono TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (pago_id) REFERENCES Pago(id)
);

-- =========================
-- 13. Notificaciones para usuarios
-- =========================
CREATE TABLE Notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    mensaje TEXT NOT NULL,
    tipo ENUM('pago','evento','general','recordatorio') DEFAULT 'general',
    estado ENUM('pendiente','enviado','leido') DEFAULT 'pendiente',
    creado_en TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES Usuarios(id)
);

-- =========================
-- 14. Himnos
-- =========================
CREATE TABLE Himno (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero INT NOT NULL UNIQUE,
    nombre VARCHAR(100) NOT NULL,
    letra TEXT,
    creado_por INT,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_modificacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (creado_por) REFERENCES Usuarios(id)
);

-- Himnos asociados a actividades
CREATE TABLE Himno_Actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    himno_id INT NOT NULL,
    actividad_id INT NOT NULL,
    FOREIGN KEY (himno_id) REFERENCES Himno(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

-- =========================
-- 15. Asistencia a Actividades
-- =========================
CREATE TABLE Asistencia_Actividad (
    id INT AUTO_INCREMENT PRIMARY KEY,
    persona_id INT NOT NULL,
    actividad_id INT NOT NULL,
    presente BOOLEAN DEFAULT TRUE,
    hora_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (persona_id) REFERENCES Persona(id),
    FOREIGN KEY (actividad_id) REFERENCES Actividad(id)
);

-- =========================
-- 16. Índices recomendados para optimización
-- =========================
CREATE INDEX idx_persona_usuario ON Persona(usuario_id);
CREATE INDEX idx_inscripcion_persona_actividad ON Inscripcion_Actividad(persona_id, actividad_id);
CREATE INDEX idx_pago_persona ON Pago(persona_id);
CREATE INDEX idx_detalle_pago_pago ON Detalle_Pago(pago_id);
CREATE INDEX idx_actividad_creado_por ON Actividad(creado_por);