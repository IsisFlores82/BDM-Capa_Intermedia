use BDMCAPA;

DELIMITER //

CREATE PROCEDURE RegistrarUsuario (
    IN p_Email VARCHAR(255),
    IN p_Nombre VARCHAR(50),
    IN p_Apellidos VARCHAR(50),
    IN p_Genero VARCHAR(10),
    IN p_Fech_Nacimiento DATE,
    IN p_Rol VARCHAR(50),
    IN p_Foto LONGBLOB,
    IN p_Contraseña VARCHAR(255),
    OUT p_Mensaje VARCHAR(255)
)
BEGIN
    -- Verificar si el usuario ya existe (por el correo)
    IF (SELECT COUNT(*) FROM Usuario WHERE Email = p_Email) > 0 THEN
        SET p_Mensaje = 'El correo ya está registrado';
    ELSE
        -- Insertar el nuevo usuario
        INSERT INTO Usuario (Email, Nombre, Apellidos, Genero, Fech_Nacimiento, Rol, Foto, Contraseña)
        VALUES (p_Email, p_Nombre, p_Apellidos, p_Genero, p_Fech_Nacimiento, p_Rol, p_Foto, p_Contraseña);

        SET p_Mensaje = 'Usuario registrado exitosamente';
    END IF;
END //

DELIMITER ;



DELIMITER $$

CREATE PROCEDURE UpdateUsuario(
    IN p_ID_Usuario INT,
    IN p_Nombre VARCHAR(50),
    IN p_Apellidos VARCHAR(50),
    IN p_Genero VARCHAR(10),
    IN p_Fech_Nacimiento DATE,
    IN p_Foto LONGBLOB,
    IN p_Contraseña VARCHAR(255)
    
)
BEGIN
    -- Variables locales para almacenar los valores actuales
    DECLARE v_ContraseñaActual VARCHAR(255);
    DECLARE v_FotoActual LONGBLOB;

    -- Obtén la contraseña y la foto actuales del usuario
    SELECT Contraseña, Foto INTO v_ContraseñaActual, v_FotoActual
    FROM Usuario
    WHERE ID_Usuario = p_ID_Usuario;

    -- Si la nueva contraseña es NULL, conserva la actual
    IF p_Contraseña IS NULL OR p_Contraseña = '' THEN
        SET p_Contraseña = v_ContraseñaActual;
    END IF;

    -- Si la nueva foto es NULL, conserva la actual
    IF p_Foto IS NULL THEN
        SET p_Foto = v_FotoActual;
    END IF;

    -- Actualiza los datos del usuario
    UPDATE Usuario
    SET
        Nombre = p_Nombre,
        Apellidos = p_Apellidos,
        Genero = p_Genero,
        Fech_Nacimiento = p_Fech_Nacimiento,
        Foto = p_Foto,
        Contraseña = p_Contraseña,
        Fech_Actualizacion = CURRENT_TIMESTAMP
    WHERE ID_Usuario = p_ID_Usuario;

END$$

DELIMITER ;

DELIMITER //

CREATE PROCEDURE GetBlockedAccounts()
BEGIN
    SELECT ID_Usuario, Nombre, Apellidos, Foto
    FROM Usuario
    WHERE Status = 0;
END //

DELIMITER ;
DELIMITER //

CREATE PROCEDURE disableUser(IN emailInput VARCHAR(255))
BEGIN
    UPDATE Usuario
    SET Status = 0
    WHERE Email = emailInput;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE enableUser(IN p_ID_Usuario INT )
BEGIN
    UPDATE Usuario
    SET Status = 1
    WHERE ID_Usuario = p_ID_Usuario;
END //

DELIMITER ;


DELIMITER $$

CREATE PROCEDURE CreateCourse(
    IN p_Titulo VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_Imagen LONGBLOB,
    IN p_Costo_Total DECIMAL(10,2),
    IN p_Gratuito BOOLEAN,
    IN p_ID_Instructor INT,
    IN p_ID_Categoria INT
)
BEGIN
    INSERT INTO Curso (Titulo, Descripcion, Imagen, Costo_Total, Gratuito, ID_Instructor, ID_Categoria)
    VALUES (p_Titulo, p_Descripcion, p_Imagen, p_Costo_Total, p_Gratuito, p_ID_Instructor, p_ID_Categoria);

    -- Return the ID of the newly created course
    SELECT LAST_INSERT_ID() AS new_course_id;
END $$

DELIMITER ;

DELIMITER //

CREATE PROCEDURE createNivel(
    IN p_ID_Curso INT,
    IN p_Titulo VARCHAR(255),
    IN p_Costo_Nivel DECIMAL(10, 2),
    IN p_Video VARCHAR(255),
    IN p_Adjunto VARCHAR(255)
)
BEGIN
    INSERT INTO Nivel (ID_Curso, Titulo, Costo_Nivel, Video, Adjunto)
    VALUES (p_ID_Curso, p_Titulo, p_Costo_Nivel, p_Video, p_Adjunto);
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE UpdateLevel(
    IN p_levelId INT,
    IN p_courseId INT,
    IN p_title VARCHAR(255),
    IN p_price DECIMAL(10, 2),
    IN p_attachmentPath VARCHAR(255),
    IN p_videoPath VARCHAR(255)
)
BEGIN
    UPDATE Nivel
    SET
        Titulo = p_title,
        Costo_Nivel = p_price,
        Adjunto = IFNULL(p_attachmentPath, Adjunto), -- Actualiza solo si hay nuevo archivo adjunto
        Video = IFNULL(p_videoPath, Video)           -- Actualiza solo si hay nuevo video
    WHERE ID_Nivel = p_levelId AND ID_Curso = p_courseId;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE DeactivateLevel(
    IN p_levelId INT
)
BEGIN
    UPDATE Nivel
    SET Status = 0
    WHERE ID_Nivel = p_levelId;
END //

DELIMITER ;

DELIMITER //

CREATE PROCEDURE UpdateCourse(
    IN p_ID_Curso INT,
    IN p_Titulo VARCHAR(255),
    IN p_Descripcion TEXT,
    IN p_ID_Categoria INT,
    IN p_Costo_Total DECIMAL(10,2),
    IN p_Gratuito TINYINT,
    IN p_Imagen LONGBLOB
)
BEGIN
    -- Actualización del título
    IF p_Titulo IS NOT NULL THEN
        UPDATE Curso SET Titulo = p_Titulo WHERE ID_Curso = p_ID_Curso;
    END IF;

    -- Actualización de la descripción
    IF p_Descripcion IS NOT NULL THEN
        UPDATE Curso SET Descripcion = p_Descripcion WHERE ID_Curso = p_ID_Curso;
    END IF;

    -- Actualización de la categoría
    IF p_ID_Categoria IS NOT NULL THEN
        UPDATE Curso SET ID_Categoria = p_ID_Categoria WHERE ID_Curso = p_ID_Curso;
    END IF;

    -- Actualización del precio
    IF p_Costo_Total IS NOT NULL THEN
        UPDATE Curso SET Costo_Total = p_Costo_Total WHERE ID_Curso = p_ID_Curso;
    END IF;

    -- Actualización del campo Gratuito
    IF p_Gratuito IS NOT NULL THEN
        UPDATE Curso SET Gratuito = p_Gratuito WHERE ID_Curso = p_ID_Curso;
    END IF;

    -- Actualización de la imagen
    IF p_Imagen IS NOT NULL THEN
        UPDATE Curso SET Imagen = p_Imagen WHERE ID_Curso = p_ID_Curso;
    END IF;
END //

DELIMITER ;

DELIMITER //

CREATE TRIGGER trg_on_course_deletion
AFTER UPDATE ON Curso
FOR EACH ROW
BEGIN
    -- Check if the course status is being set to 0
    IF OLD.Status = 1 AND NEW.Status = 0 THEN
        -- Set all related levels to inactive
        UPDATE Nivel 
        SET Status = 0 
        WHERE ID_Curso = NEW.ID_Curso;
    END IF;
END //

DELIMITER ;

DELIMITER $$

CREATE TRIGGER after_level_purchase
AFTER INSERT ON Inscripciones_Niveles
FOR EACH ROW
BEGIN
    DECLARE total_niveles INT;
    DECLARE niveles_comprados INT;

    -- Obtener la cantidad total de niveles del curso
    SELECT COUNT(ID_Nivel)
    INTO total_niveles
    FROM Nivel
    WHERE ID_Curso = (SELECT ID_Curso FROM Nivel WHERE ID_Nivel = NEW.ID_Nivel);

    -- Obtener la cantidad de niveles que el usuario ha comprado para este curso
    SELECT COUNT(DISTINCT ID_Nivel)
    INTO niveles_comprados
    FROM Inscripciones_Niveles
    WHERE ID_Usuario = NEW.ID_Usuario
      AND ID_Nivel IN (
          SELECT ID_Nivel
          FROM Nivel
          WHERE ID_Curso = (SELECT ID_Curso FROM Nivel WHERE ID_Nivel = NEW.ID_Nivel)
      );

    -- Si el usuario ha comprado todos los niveles, insertar el curso en Inscripciones
    IF niveles_comprados = total_niveles THEN
        INSERT INTO Inscripciones (ID_Curso, ID_Usuario, Fecha_Inscripcion, Monto_Pagado, Forma_de_Pago)
        VALUES (
            (SELECT ID_Curso FROM Nivel WHERE ID_Nivel = NEW.ID_Nivel),
            NEW.ID_Usuario,
            NOW(),
            (SELECT SUM(Costo_Nivel) FROM Nivel WHERE ID_Curso = (SELECT ID_Curso FROM Nivel WHERE ID_Nivel = NEW.ID_Nivel)),
            'Completado por niveles'
        );

        -- Opcional: Actualizar los registros en Inscripciones_Niveles para reflejar que el curso ya se completó
        UPDATE Inscripciones_Niveles
        SET Status = 0 -- 0 indica que ya no se necesita verificar estos niveles
        WHERE ID_Usuario = NEW.ID_Usuario
          AND ID_Nivel IN (
              SELECT ID_Nivel
              FROM Nivel
              WHERE ID_Curso = (SELECT ID_Curso FROM Nivel WHERE ID_Nivel = NEW.ID_Nivel)
          );
    END IF;
END$$

DELIMITER ;



DELIMITER $$

CREATE TRIGGER AfterInsertNivel
AFTER INSERT ON Nivel
FOR EACH ROW
BEGIN
    -- Insertar un registro de progreso para todos los usuarios con el curso completado
    INSERT INTO Progreso_Niveles (ID_Usuario, ID_Nivel, Status)
    SELECT ID_Usuario, NEW.ID_Nivel, 0
    FROM Inscripciones
    WHERE ID_Curso = NEW.ID_Curso AND Fecha_Terminacion IS NOT NULL;
END$$

DELIMITER ;



