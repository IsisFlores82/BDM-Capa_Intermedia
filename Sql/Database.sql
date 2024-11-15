create DATABASE BDMCAPA;
use BDMCAPA;

CREATE TABLE IF NOT EXISTS Usuario  (
    ID_Usuario INT AUTO_INCREMENT PRIMARY KEY,
    Email VARCHAR(255) NOT NULL UNIQUE,
    Nombre VARCHAR(50) NOT NULL,
    Apellidos VARCHAR(50) NOT NULL,
    Genero VARCHAR(10),
    Fech_Nacimiento DATE,
    Fech_Registro DATETIME DEFAULT CURRENT_TIMESTAMP,
    Fech_Actualizacion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    Rol VARCHAR(50),
    Foto LONGBLOB,
    Status TINYINT(1) DEFAULT 1,
    Contraseña VARCHAR(255) NOT NULL,
    Failed_Attempts INT DEFAULT 0
);
select * from Usuario;
-- Insert para un Administrador
INSERT INTO Usuario (Email, Nombre, Apellidos, Genero, Fech_Nacimiento, Rol, Foto, Contraseña)
VALUES ('admin@ejemplo.com', 'Admin', 'Ejemplo', 'Masculino', '1980-01-01', 'Administrador', '', '$2y$10$MsPQRReOdRC0G41ppEpX6ONlZYHTaGVNVYE.PD6WZgWGexlcw061S');

-- Insert para un Alumno
INSERT INTO Usuario (Email, Nombre, Apellidos, Genero, Fech_Nacimiento, Rol, Foto, Contraseña)
VALUES ('alumno@ejemplo.com', 'Alumno', 'Ejemplo', 'Femenino', '1995-05-10', 'Alumno', '', '$2y$10$MsPQRReOdRC0G41ppEpX6ONlZYHTaGVNVYE.PD6WZgWGexlcw061S');

-- Insert para un Alumno
INSERT INTO Usuario (Email, Nombre, Apellidos, Genero, Fech_Nacimiento, Rol, Foto, Contraseña)
VALUES ('alumno2@ejemplo.com', 'Alumno2', 'Ejemplo', 'Masculino', '2003-02-08', 'Alumno', '', '$2y$10$MsPQRReOdRC0G41ppEpX6ONlZYHTaGVNVYE.PD6WZgWGexlcw061S');


-- Insert para un Instructor
INSERT INTO Usuario (Email, Nombre, Apellidos, Genero, Fech_Nacimiento, Rol, Foto, Contraseña)
VALUES ('instructor@ejemplo.com', 'Instructor', 'Ejemplo', 'Otro', '1985-08-20', 'Instructor', '', '$2y$10$MsPQRReOdRC0G41ppEpX6ONlZYHTaGVNVYE.PD6WZgWGexlcw061S');


CREATE TABLE IF NOT EXISTS Categorias (
    ID_Categoria INT AUTO_INCREMENT PRIMARY KEY,
    Nombre VARCHAR(255),
    Descripcion TINYTEXT,
    ID_Usuario INT NOT NULL,
    Status TINYINT(1) DEFAULT 1,
    Fecha_Creacion  DATETIME DEFAULT CURRENT_TIMESTAMP,
    Fecha_Edicion DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario)
);
select * from Categorias;

CREATE TABLE if not exists Curso (
    ID_Curso INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255),
    Descripcion TEXT,
    Imagen LONGBLOB,
    Costo_Total DECIMAL(10, 2),
    Gratuito BOOLEAN,
    ID_Instructor INT NOT NULL,
    ID_Categoria INT NOT NULL,
    Status TINYINT(1) DEFAULT 1,
    Fecha_Creacion DATETIME DEFAULT CURRENT_TIMESTAMP,
    Fecha_Elim DATETIME,
    FOREIGN KEY (ID_Instructor) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Categoria) REFERENCES Categorias(ID_Categoria)
);
select * from Curso;

CREATE TABLE if not exists Nivel (
    ID_Nivel INT AUTO_INCREMENT PRIMARY KEY,
    Titulo VARCHAR(255),
    ID_Curso INT NOT NULL,
    Costo_Nivel DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    Video VARCHAR(255) NOT NULL,
    Adjunto VARCHAR(255),
    Status TINYINT(1) DEFAULT 1,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso)
);
select * from Nivel;

CREATE TABLE if not exists Inscripciones (
    ID_Inscripcion INT AUTO_INCREMENT PRIMARY KEY,
    ID_Curso INT NOT NULL,
    ID_Usuario INT NOT NULL,
    Fecha_Inscripcion DATETIME,
    Fecha_Ultimo_Ingreso DATETIME,
    Fecha_Terminacion DATETIME,
    Status TINYINT(1) DEFAULT 1,
    Certificado VARCHAR(255),
    Monto_Pagado DECIMAL(10, 2),
    Forma_de_Pago VARCHAR(255),
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso),
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario)
);
select * from Inscripciones;
ALTER TABLE Inscripciones
ADD CONSTRAINT UNQ_Inscripcion UNIQUE (ID_Curso, ID_Usuario);

CREATE TABLE if not exists Inscripciones_Niveles (
    ID_Inscripcion_Nivel INT AUTO_INCREMENT PRIMARY KEY,
    ID_Nivel INT NOT NULL,
    ID_Usuario INT NOT NULL,
    Monto_Pagado DECIMAL(10, 2),
	Forma_de_Pago VARCHAR(255),
    Fecha_Inscripcion DATETIME,
	Fecha_Ultimo_Ingreso DATETIME,
    Status TINYINT(1) DEFAULT 1,
    FOREIGN KEY (ID_Nivel) REFERENCES Nivel(ID_Nivel),
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario)
);
select * from Inscripciones_Niveles;
ALTER TABLE Inscripciones_Niveles
ADD CONSTRAINT UNQ_Inscripcion_Nivel UNIQUE (ID_Nivel, ID_Usuario);

describe Inscripciones_Niveles;
CREATE TABLE if not exists Progreso_Niveles (
    ID_Progreso INT AUTO_INCREMENT PRIMARY KEY,
    ID_Usuario INT NOT NULL,
    ID_Nivel INT NOT NULL,
    Fecha_Completado DATETIME,
    Status TINYINT(1) DEFAULT 0, -- 0: No completado, 1: Completado
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Nivel) REFERENCES Nivel(ID_Nivel),
    UNIQUE (ID_Usuario, ID_Nivel) -- Para evitar duplicados
);
select * from Progreso_Niveles;

CREATE TABLE if not exists Mensajes (
    ID_Mensaje INT AUTO_INCREMENT PRIMARY KEY,
    ID_Emisor INT,
    ID_Receptor INT,
    Mensaje TEXT,
    Fecha_Envio DATETIME,
    FOREIGN KEY (ID_Emisor) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Receptor) REFERENCES Usuario(ID_Usuario)
);
select * from Mensajes;

CREATE TABLE if not exists Comentario (
    ID_Comentario INT AUTO_INCREMENT PRIMARY KEY,
    ID_Curso INT,
    ID_Usuario INT,
    Calificacion INT,
    Comentario TEXT,
    Fecha_Creacion  DATETIME DEFAULT CURRENT_TIMESTAMP,
    Status TINYINT(1) DEFAULT 1,
    Fecha_Eliminacion DATETIME,
    Motivo_Eliminacion TINYTEXT,
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso),
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario)
);
select * from Comentario;

CREATE TABLE if not exists Carrito (
    ID_Carrito INT AUTO_INCREMENT PRIMARY KEY,
    ID_Usuario INT NOT NULL,  -- ID del usuario dueño del carrito
    ID_Curso INT NULL,        -- ID del curso (si es un curso)
    ID_Nivel INT NULL,        -- ID del nivel (si es un nivel)
    Tipo VARCHAR(6) NOT NULL,  -- Tipo de producto (curso o nivel)
    Fecha_Agregado DATETIME DEFAULT CURRENT_TIMESTAMP,  -- Fecha de cuando se añadió el item al carrito
	Status TINYINT(1) DEFAULT 1,
    FOREIGN KEY (ID_Usuario) REFERENCES Usuario(ID_Usuario),
    FOREIGN KEY (ID_Curso) REFERENCES Curso(ID_Curso),
    FOREIGN KEY (ID_Nivel) REFERENCES Nivel(ID_Nivel)
);
select * FROM Carrito;

