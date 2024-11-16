use BDMCAPA;


DELIMITER $$

CREATE FUNCTION ObtenerTotalComprado(ID_Usuario INT)
RETURNS DECIMAL(10, 2)
DETERMINISTIC
BEGIN
    DECLARE totalCursos DECIMAL(10, 2);
    DECLARE totalNiveles DECIMAL(10, 2);
    DECLARE totalFinal DECIMAL(10, 2);

    -- Sumar el costo de los cursos en el carrito del usuario
    SELECT COALESCE(SUM(C.Costo_Total), 0)
    INTO totalCursos
    FROM Carrito CA
    JOIN Curso C ON CA.ID_Curso = C.ID_Curso
    WHERE CA.ID_Usuario = ID_Usuario AND CA.Status = 1 AND CA.Tipo = 'curso' AND C.Status = 1;

    -- Sumar el costo de los niveles en el carrito del usuario
    SELECT COALESCE(SUM(N.Costo_Nivel), 0)
    INTO totalNiveles
    FROM Carrito CA
    JOIN Nivel N ON CA.ID_Nivel = N.ID_Nivel
    WHERE CA.ID_Usuario = ID_Usuario AND CA.Status = 1 AND CA.Tipo = 'nivel' AND N.Status = 1;

    -- Calcular el total final
    SET totalFinal = totalCursos + totalNiveles;

    RETURN totalFinal;
END$$

DELIMITER ;


DELIMITER //

CREATE FUNCTION CalcularProgresoCurso(idUsuario INT, idCurso INT)
RETURNS DECIMAL(5, 2) DETERMINISTIC
BEGIN
    DECLARE totalNiveles INT;
    DECLARE nivelesCompletados INT;
    DECLARE progreso DECIMAL(5, 2);

    -- Contar el total de niveles del curso
    SELECT COUNT(ID_Nivel) 
    INTO totalNiveles
    FROM Nivel
    WHERE ID_Curso = idCurso AND Status = 1;

    -- Contar los niveles completados por el usuario
    SELECT COUNT(vnp.ID_Nivel) 
    INTO nivelesCompletados
    FROM View_Niveles_Progreso vnp
    WHERE vnp.ID_Usuario = idUsuario AND vnp.ID_Curso = idCurso AND vnp.ProgresoStatus = 1;

    -- Calcular el porcentaje
    IF totalNiveles > 0 THEN
        SET progreso = (nivelesCompletados / totalNiveles) * 100;
    ELSE
        SET progreso = 0;
    END IF;

    RETURN progreso;
END //

DELIMITER ;





