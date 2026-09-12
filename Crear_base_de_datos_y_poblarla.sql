-- ============================================================
-- Script de creación de base de datos: mascotas_y_mascotitas
-- Basado en el diagrama entidad-relación proporcionado
-- ============================================================

CREATE DATABASE IF NOT EXISTS mascotas_y_mascotitas
CHARACTER SET utf8mb4
COLLATE utf8mb4_0900_ai_ci;

USE mascotas_y_mascotitas;

-- ============================================================
-- 1. TABLAS CATÁLOGO (sin dependencias)
-- ============================================================

-- Tabla: Rol de usuario
CREATE TABLE IF NOT EXISTS RolUsuario (
  IDRol      INT AUTO_INCREMENT PRIMARY KEY,
  NomRol     VARCHAR(50) NOT NULL,
  BitActivo  BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla: EstadoPedido
CREATE TABLE IF NOT EXISTS EstadoPedido (
  IDEstadoPedido INT AUTO_INCREMENT PRIMARY KEY,
  Descripcion    VARCHAR(50) NOT NULL,
  BitActivo      BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla: Concentración
CREATE TABLE IF NOT EXISTS Concentracion (
  IDConcentracion INT AUTO_INCREMENT PRIMARY KEY,
  Descripcion     VARCHAR(50) NOT NULL,
  bitActivo       BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla: UnidadMedida
CREATE TABLE IF NOT EXISTS UnidadMedida (
  IDUnidadMedida INT AUTO_INCREMENT PRIMARY KEY,
  Nombre         VARCHAR(50) NOT NULL,
  Abreviatura    VARCHAR(20) NOT NULL,
  bitActivo      BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- Tabla: Categoría
CREATE TABLE IF NOT EXISTS Categoria (
  IDCategoria INT AUTO_INCREMENT PRIMARY KEY,
  Nombre      VARCHAR(50) NOT NULL,
  bitActivo   BOOLEAN NOT NULL DEFAULT TRUE
) ENGINE=InnoDB;

-- ============================================================
-- 2. TABLAS PRINCIPALES
-- ============================================================

-- Tabla: Usuario
CREATE TABLE IF NOT EXISTS Usuario (
  IDUsuario          INT AUTO_INCREMENT PRIMARY KEY,
  IDRol              INT NOT NULL,
  Nombre             VARCHAR(50) NOT NULL,
  ApellidoPaterno    VARCHAR(50) NOT NULL,
  ApellidoMaterno    VARCHAR(50) NOT NULL,
  Email              VARCHAR(50) NOT NULL UNIQUE,
  Contrasena         VARCHAR(255) NOT NULL,
  Telefono           BIGINT,
  BitActivo          BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_usuario_rol
    FOREIGN KEY (IDRol) REFERENCES RolUsuario(IDRol)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla: Proveedor
CREATE TABLE IF NOT EXISTS Proveedor (
  IDProveedor      INT AUTO_INCREMENT PRIMARY KEY,
  Nombre           VARCHAR(50) NOT NULL,
  ApellidoPaterno  VARCHAR(50) NOT NULL,
  ApellidoMaterno  VARCHAR(50) NOT NULL,
  Email            VARCHAR(50) NOT NULL UNIQUE,
  FechaCreacion    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FechaModifica    DATETIME NULL,
  FechaElimina     DATETIME NULL,
  bitActivo        BOOLEAN NOT NULL DEFAULT TRUE,
  IDUsuario        INT NOT NULL,
  CONSTRAINT fk_proveedor_usuario
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(IDUsuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla: Pedido
CREATE TABLE IF NOT EXISTS Pedido (
  IDPedido              INT AUTO_INCREMENT PRIMARY KEY,
  IDProveedor           INT NOT NULL,
  Descripcion           VARCHAR(50) NOT NULL,
  FechaSolicitud        DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  FechaModifica         DATETIME NULL,
  FechaEntregaEstimada  DATETIME NULL,
  FechaEntregaReal      DATETIME NULL,
  BitActivo             BOOLEAN NOT NULL DEFAULT TRUE,
  IDEstadoPedido        INT NOT NULL,
  IDUsuario             INT NOT NULL,
  CONSTRAINT fk_pedido_proveedor
    FOREIGN KEY (IDProveedor) REFERENCES Proveedor(IDProveedor)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_pedido_estado
    FOREIGN KEY (IDEstadoPedido) REFERENCES EstadoPedido(IDEstadoPedido)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT fk_pedido_usuario
    FOREIGN KEY (IDUsuario) REFERENCES Usuario(IDUsuario)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- Tabla: Medicamento
CREATE TABLE IF NOT EXISTS Medicamento (
  IDMedicamento             INT AUTO_INCREMENT PRIMARY KEY,
  IDUnidadMedida            INT NOT NULL,
  Nombre                    VARCHAR(50) NOT NULL,
  Descripcion               VARCHAR(50),
  StockTotal                INT NOT NULL DEFAULT 0,
  StockDisponible           INT NOT NULL DEFAULT 0,
  StockApartado             INT NOT NULL DEFAULT 0,
  CantidadMaximaPorEnvase   INT NOT NULL DEFAULT 0,
  CantidadActualPorEnvase   DOUBLE NOT NULL DEFAULT 0,
  bitActivo                 BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_medicamento_unidad
    FOREIGN KEY (IDUnidadMedida) REFERENCES UnidadMedida(IDUnidadMedida)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- ============================================================
-- 3. TABLAS INTERMEDIAS (relaciones muchos-a-muchos)
-- ============================================================

-- Tabla: MedicamentoConcentración
CREATE TABLE IF NOT EXISTS MedicamentoConcentracion (
  IDMedicamentoConcentracion INT AUTO_INCREMENT PRIMARY KEY,
  IDMedicamento              INT NOT NULL,
  IDConcentracion            INT NOT NULL,
  bitActivo                  BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_medcon_medicamento
    FOREIGN KEY (IDMedicamento) REFERENCES Medicamento(IDMedicamento)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_medcon_concentracion
    FOREIGN KEY (IDConcentracion) REFERENCES Concentracion(IDConcentracion)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT uq_medicamento_concentracion
    UNIQUE (IDMedicamento, IDConcentracion)
) ENGINE=InnoDB;

-- Tabla: MedicamentoCategoría
CREATE TABLE IF NOT EXISTS MedicamentoCategoria (
  IDMedicamentoCategoria INT AUTO_INCREMENT PRIMARY KEY,
  IDMedicamento          INT NOT NULL,
  IDCategoria            INT NOT NULL,
  bitActivo              BOOLEAN NOT NULL DEFAULT TRUE,
  CONSTRAINT fk_medcat_medicamento
    FOREIGN KEY (IDMedicamento) REFERENCES Medicamento(IDMedicamento)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_medcat_categoria
    FOREIGN KEY (IDCategoria) REFERENCES Categoria(IDCategoria)
    ON UPDATE CASCADE ON DELETE RESTRICT,
  CONSTRAINT uq_medicamento_categoria
    UNIQUE (IDMedicamento, IDCategoria)
) ENGINE=InnoDB;

-- ============================================================
-- 4. INSERCIÓN DE DATOS DE PRUEBA
-- ============================================================

-- ------------------------------------------------------------
-- 4.1 Roles de usuario
-- ------------------------------------------------------------
INSERT INTO RolUsuario (NomRol, BitActivo) VALUES
  ('JefeClinica', TRUE),
  ('Veterinario', TRUE),
  ('GerenteInventarioProveedor', TRUE),
  ('Proveedor', TRUE),
  ('Desarrollador', TRUE);

-- ------------------------------------------------------------
-- 4.2 Estados del pedido
-- ------------------------------------------------------------
INSERT INTO EstadoPedido (Descripcion, BitActivo) VALUES
  ('Pendiente de aprobación', TRUE),
  ('Aprobado', TRUE),
  ('Solicitado', TRUE),
  ('En transito', TRUE),
  ('Recibido', TRUE),
  ('Cancelado', TRUE);

-- ------------------------------------------------------------
-- 4.3 Concentraciones
-- ------------------------------------------------------------
INSERT INTO Concentracion (Descripcion, bitActivo) VALUES
  ('50 mg', TRUE),
  ('100 mg', TRUE),
  ('250 mg', TRUE),
  ('500 mg', TRUE),
  ('1 g', TRUE),
  ('5 ml', TRUE),
  ('10 ml', TRUE);

-- ------------------------------------------------------------
-- 4.4 Unidades de medida
-- ------------------------------------------------------------
INSERT INTO UnidadMedida (Nombre, Abreviatura, bitActivo) VALUES
  ('Tableta', 'tab', TRUE),
  ('Cápsula', 'cap', TRUE),
  ('Mililitro', 'ml', TRUE),
  ('Gramo', 'g', TRUE),
  ('Frasco', 'fco', TRUE),
  ('Ampolleta', 'amp', TRUE),
  ('Tubo', 'tub', TRUE);

-- ------------------------------------------------------------
-- 4.5 Categorías de medicamentos
-- ------------------------------------------------------------
INSERT INTO Categoria (Nombre, bitActivo) VALUES
  ('Antibiótico', TRUE),
  ('Antiinflamatorio', TRUE),
  ('Analgésico', TRUE),
  ('Vacuna', TRUE),
  ('Antiparasitario', TRUE),
  ('Vitaminas', TRUE),
  ('Dermatológico', TRUE);

-- ------------------------------------------------------------
-- 4.6 Usuarios (contraseñas hasheadas con bcrypt, todas son "password123")
--     Hash de ejemplo: $2b$10$abcdefghijklmnopqrstuv...
-- ------------------------------------------------------------
INSERT INTO Usuario (IDRol, Nombre, ApellidoPaterno, ApellidoMaterno, Email, Contrasena, Telefono, BitActivo) VALUES
  (1, 'Laura',   'García',   'Méndez',   'jefa.clinica@mascotasymascotitas.com',   '123', 5512345678, TRUE),
  (2, 'Carlos',  'Ramírez',  'Soto',     'veterinario1@mascotasymascotitas.com',  '123', 5512345679, TRUE),
  (2, 'Ana',     'López',    'Hernández','veterinario2@mascotasymascotitas.com',  '123', 5512345680, TRUE),
  (3, 'Miguel',  'Torres',   'Vega',     'gerente.inv@mascotasymascotitas.com',   '123', 5512345681, TRUE),
  (4, 'Patricia','Núñez',    'Ríos',     'proveedor1@distribuidora.com',          '123', 5512345682, TRUE),
  (4, 'Roberto', 'Silva',    'Castro',   'proveedor2@farmaciasvet.com',           '123', 5512345683, TRUE),
  (5, 'Ricardo',   'Navarro','Suárez',  'dev@mascotasymascotitas.com',           '123', 5512345684, TRUE);

-- ------------------------------------------------------------
-- 4.7 Proveedores
-- ------------------------------------------------------------
INSERT INTO Proveedor (Nombre, ApellidoPaterno, ApellidoMaterno, Email, IDUsuario, bitActivo) VALUES
  ('Patricia', 'Núñez',  'Ríos',   'proveedor1@distribuidora.com', 5, TRUE),
  ('Roberto',  'Silva',  'Castro', 'proveedor2@farmaciasvet.com',  6, TRUE);

-- ------------------------------------------------------------
-- 4.8 Medicamentos
-- ------------------------------------------------------------
INSERT INTO Medicamento (IDUnidadMedida, Nombre, Descripcion, StockTotal, StockDisponible, StockApartado, CantidadMaximaPorEnvase, CantidadActualPorEnvase, bitActivo) VALUES
  (1, 'Amoxicilina',    'Antibiótico de amplio espectro',      120, 100, 20, 100, 80.0, TRUE),
  (2, 'Meloxicam',      'Antiinflamatorio no esteroideo',       60,  50, 10,  50, 30.0, TRUE),
  (3, 'Ivermectina',    'Antiparasitario de uso veterinario',   80,  70, 10, 100, 90.0, TRUE),
  (6, 'Vacuna Rabia',   'Vacuna antirrábica canina/felina',     40,  35,  5,  40, 40.0, TRUE),
  (7, 'Shampoo Med.',   'Shampoo dermatológico medicado',       25,  20,  5,  25, 15.0, TRUE),
  (1, 'Metronidazol',   'Antibiótico para infecciones GI',      90,  80, 10,  90, 60.0, TRUE),
  (5, 'Suero Oral',     'Solución de rehidratación',           150, 130, 20, 150, 100.0, TRUE);

-- ------------------------------------------------------------
-- 4.9 Relación Medicamento - Concentración
-- ------------------------------------------------------------
INSERT INTO MedicamentoConcentracion (IDMedicamento, IDConcentracion, bitActivo) VALUES
  (1, 4, TRUE),  -- Amoxicilina 500 mg
  (2, 3, TRUE),  -- Meloxicam 250 mg
  (3, 6, TRUE),  -- Ivermectina 5 ml
  (4, 7, TRUE),  -- Vacuna Rabia 10 ml
  (5, 6, TRUE),  -- Shampoo Med. 5 ml
  (6, 4, TRUE),  -- Metronidazol 500 mg
  (7, 7, TRUE);  -- Suero Oral 10 ml

-- ------------------------------------------------------------
-- 4.10 Relación Medicamento - Categoría
-- ------------------------------------------------------------
INSERT INTO MedicamentoCategoria (IDMedicamento, IDCategoria, bitActivo) VALUES
  (1, 1, TRUE),  -- Amoxicilina → Antibiótico
  (2, 2, TRUE),  -- Meloxicam → Antiinflamatorio
  (3, 5, TRUE),  -- Ivermectina → Antiparasitario
  (4, 4, TRUE),  -- Vacuna Rabia → Vacuna
  (5, 7, TRUE),  -- Shampoo Med. → Dermatológico
  (6, 1, TRUE),  -- Metronidazol → Antibiótico
  (7, 6, TRUE);  -- Suero Oral → Vitaminas (por clasificación práctica)

-- ------------------------------------------------------------
-- 4.11 Pedidos de prueba
-- ------------------------------------------------------------
INSERT INTO Pedido (IDProveedor, Descripcion, FechaSolicitud, FechaEntregaEstimada, FechaEntregaReal, IDEstadoPedido, IDUsuario, BitActivo) VALUES
  (1, 'Pedido de antibióticos y antiinflamatorios',  '2026-08-01 09:00:00', '2026-08-10 09:00:00', '2026-08-09 14:30:00', 5, 4, TRUE),
  (2, 'Pedido de vacunas antirrábicas',              '2026-08-05 10:30:00', '2026-08-15 10:30:00', NULL,                   3, 4, TRUE),
  (1, 'Reposición de suero oral',                    '2026-08-12 11:00:00', '2026-08-20 11:00:00', NULL,                   2, 4, TRUE),
  (2, 'Pedido de shampoo dermatológico',             '2026-08-15 08:45:00', '2026-08-25 08:45:00', NULL,                   1, 4, TRUE),
  (1, 'Pedido urgente de antiparasitarios',          '2026-08-18 16:20:00', '2026-08-22 16:20:00', NULL,                   6, 4, TRUE);

-- ============================================================
-- Fin del script
-- ============================================================