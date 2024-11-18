use BDMCAPA;


CREATE OR REPLACE VIEW CoursesWithInstructors AS
SELECT 
    c.ID_Curso,
    c.Titulo AS Course_Title,
    c.Descripcion AS Course_Description,
    c.Imagen AS Course_Image,
    c.Costo_Total AS Course_Price,
    c.Gratuito AS Is_Free,
    c.ID_Instructor,
    u.Nombre AS Instructor_Nombre,
    u.Apellidos AS Instructor_Apellidos,
    c.ID_Categoria,
    c.Status,
    c.Fecha_Creacion,
    c.Fecha_Elim,
    CalcularPromedioCurso(c.ID_Curso) AS Average_Rating
FROM 
    Curso c
JOIN 
    Usuario u ON c.ID_Instructor = u.ID_Usuario;

    
    
CREATE VIEW View_Inscripciones_Cursos AS
SELECT 
    i.ID_Usuario,
    c.ID_Curso,
    c.Titulo AS CursoTitulo,
    c.Descripcion AS CursoDescripcion,
    c.Imagen AS CursoImagen,
    c.Costo_Total,
    i.Fecha_Inscripcion,
    c.Status
FROM 
    Inscripciones i
JOIN 
    Curso c ON i.ID_Curso = c.ID_Curso
WHERE 
    i.Status = 1 and c.Status = 1; -- Solo cursos activos


CREATE VIEW View_Inscripciones_Niveles AS
SELECT 
    inl.ID_Usuario,
    c.ID_Curso,
    c.Titulo AS CursoTitulo,
    c.Descripcion AS CursoDescripcion,
    c.Imagen AS CursoImagen,
    n.ID_Nivel,
    n.Titulo AS NivelTitulo,
    n.Costo_Nivel,
    inl.Fecha_Inscripcion
FROM 
    Inscripciones_Niveles inl
JOIN 
    Nivel n ON inl.ID_Nivel = n.ID_Nivel
JOIN 
    Curso c ON n.ID_Curso = c.ID_Curso
WHERE 
    inl.Status = 1
    AND n.Status = 1
    AND c.ID_Curso NOT IN (
        SELECT ID_Curso 
        FROM Inscripciones 
        WHERE ID_Usuario = inl.ID_Usuario AND Status = 1
    );


CREATE VIEW View_Inscripciones_Combinadas AS
SELECT 
    ic.ID_Usuario,
    ic.ID_Curso,
    ic.CursoTitulo,
    ic.CursoDescripcion,
    ic.CursoImagen,
    NULL AS ID_Nivel,
    NULL AS NivelTitulo,
    ic.Costo_Total,
    ic.Fecha_Inscripcion
FROM 
    View_Inscripciones_Cursos ic

UNION ALL

SELECT 
    inl.ID_Usuario,
    inl.ID_Curso,
    inl.CursoTitulo,
    inl.CursoDescripcion,
    inl.CursoImagen,
    inl.ID_Nivel,
    inl.NivelTitulo,
    inl.Costo_Nivel,
    inl.Fecha_Inscripcion
FROM 
    View_Inscripciones_Niveles inl;
    
    
CREATE VIEW View_Inscripciones_Niveles_Completa AS
SELECT 
    inl.ID_Usuario,
    n.ID_Curso,  -- Usar ID_Curso de la tabla Nivel
    c.Titulo AS CursoTitulo,
    c.Descripcion AS CursoDescripcion,
    c.Imagen AS CursoImagen,
    n.ID_Nivel,
    n.Titulo AS NivelTitulo,
    n.Costo_Nivel,
    inl.Fecha_Inscripcion,
    inl.Status AS NivelStatus
FROM 
    Inscripciones_Niveles inl
JOIN 
    Nivel n ON inl.ID_Nivel = n.ID_Nivel
JOIN 
    Curso c ON n.ID_Curso = c.ID_Curso
WHERE 
    inl.Status = 1;


CREATE VIEW View_Niveles_Poseidos AS
SELECT DISTINCT 
    IFNULL(inl.ID_Nivel, n.ID_Nivel) AS ID_Nivel,
    n.Titulo AS NivelTitulo,
    n.ID_Curso,
    c.Titulo AS CursoTitulo,
    inl.ID_Usuario
FROM 
    View_Inscripciones_Combinadas inl
LEFT JOIN 
    Nivel n ON inl.ID_Curso = n.ID_Curso
LEFT JOIN 
    Curso c ON n.ID_Curso = c.ID_Curso
WHERE 
    c.Status = 1 
    AND (n.Status = 1 OR n.Status IS NULL);
    
    
CREATE OR REPLACE VIEW View_Niveles_Progreso AS
SELECT 
    n.ID_Nivel,
    n.Titulo AS NivelTitulo,
    n.Costo_Nivel,
    n.Video,
    n.Adjunto,
    n.Status AS NivelStatus,
    c.ID_Curso,
    c.Titulo AS CursoTitulo,
    c.Costo_Total AS CursoCosto,
    c.Status AS CursoStatus,
    pn.ID_Usuario,
    pn.Fecha_Completado,
    pn.Status AS ProgresoStatus -- 0: No completado, 1: Completado
FROM 
    Nivel n
JOIN 
    Curso c ON n.ID_Curso = c.ID_Curso
LEFT JOIN 
    Progreso_Niveles pn ON n.ID_Nivel = pn.ID_Nivel;

CREATE OR REPLACE VIEW KardexUsuario AS
SELECT 
    i.ID_Usuario,
    c.ID_Curso,
    c.Titulo AS Curso,
    i.Fecha_Inscripcion,
    i.Fecha_Ultimo_Ingreso,
    c.ID_Categoria AS Categoria,
    CalcularProgresoCurso(i.ID_Usuario, c.ID_Curso) AS Progreso,
    CASE 
        WHEN i.Fecha_Terminacion IS NOT NULL THEN 'Completado'
        WHEN c.Status = 1 THEN 'Activo'
        ELSE 'Inactivo'
    END AS Estado,
    i.Fecha_Terminacion,
    i.Certificado,
    COUNT(co.ID_Comentario) AS TotalComentarios
FROM 
    Inscripciones i
LEFT JOIN 
    Curso c ON i.ID_Curso = c.ID_Curso
LEFT JOIN 
    Comentario co ON co.ID_Curso = c.ID_Curso AND co.ID_Usuario = i.ID_Usuario
GROUP BY 
    i.ID_Usuario, i.ID_Curso;
    
    
CREATE OR REPLACE VIEW Resumen_Inscripciones_Cursos AS
SELECT 
    c.ID_Curso,
    c.Titulo AS Curso,
    COUNT(i.ID_Usuario) AS AlumnosInscritos,
    AVG(COALESCE(CalcularProgresoCurso(i.ID_Usuario, c.ID_Curso), 0)) AS PromedioProgreso,
    SUM(CASE 
        WHEN i.Status = 1 THEN i.Monto_Pagado
        ELSE 0
    END) AS VentasTotales,
    i.Forma_de_Pago
FROM Curso c
LEFT JOIN Inscripciones i ON c.ID_Curso = i.ID_Curso
WHERE c.Status = 1
GROUP BY c.ID_Curso, i.Forma_de_Pago;


CREATE OR REPLACE VIEW Resumen_Inscripciones_Niveles AS
SELECT 
    n.ID_Curso,
    n.ID_Nivel,
    COUNT(inl.ID_Usuario) AS AlumnosInscritos,
    SUM(CASE 
        WHEN inl.Status = 1 THEN inl.Monto_Pagado
        ELSE 0
    END) AS VentasTotalesNiveles
FROM Nivel n
LEFT JOIN Inscripciones_Niveles inl ON n.ID_Nivel = inl.ID_Nivel
GROUP BY n.ID_Curso, n.ID_Nivel;

CREATE OR REPLACE VIEW Ventas_Totales_Cursos AS
SELECT 
    c.ID_Curso,
    c.Titulo,
    c.ID_Instructor,
    c.Fecha_Creacion,
    c.ID_Categoria,
    c.Status,
    COALESCE(rc.VentasTotales, 0) AS VentasCursos,
    COALESCE(rn.VentasTotalesNiveles, 0) AS VentasNiveles,
    (COALESCE(rc.VentasTotales, 0) + COALESCE(rn.VentasTotalesNiveles, 0)) AS VentasTotales,
    COALESCE(ai.AlumnosInscritos, 0) AS AlumnosInscritos,
    COALESCE(pp.PromedioProgreso, 0) AS PromedioProgreso,
    GROUP_CONCAT(DISTINCT rc.Forma_de_Pago SEPARATOR ', ') AS MetodosPago,
    CASE 
        WHEN c.Status = 1 THEN 'Activo'
        ELSE 'Inactivo'
    END AS Estado
FROM Curso c
LEFT JOIN (
    SELECT 
        i.ID_Curso, 
        COUNT(DISTINCT i.ID_Usuario) AS AlumnosInscritos
    FROM Inscripciones i
    GROUP BY i.ID_Curso
) ai ON c.ID_Curso = ai.ID_Curso
LEFT JOIN (
    SELECT 
        i.ID_Curso, 
        AVG(COALESCE(CalcularProgresoCurso(i.ID_Usuario, i.ID_Curso), 0)) AS PromedioProgreso
    FROM Inscripciones i
    GROUP BY i.ID_Curso
) pp ON c.ID_Curso = pp.ID_Curso
LEFT JOIN Resumen_Inscripciones_Cursos rc ON c.ID_Curso = rc.ID_Curso
LEFT JOIN (
    SELECT 
        rn.ID_Curso, 
        SUM(rn.VentasTotalesNiveles) AS VentasTotalesNiveles
    FROM Resumen_Inscripciones_Niveles rn
    GROUP BY rn.ID_Curso
) rn ON c.ID_Curso = rn.ID_Curso
GROUP BY 
    c.ID_Curso, 
    c.Titulo, 
    c.ID_Instructor, 
    c.Fecha_Creacion, 
    c.ID_Categoria, 
    c.Status, 
    rc.VentasTotales, 
    rn.VentasTotalesNiveles, 
    ai.AlumnosInscritos, 
    pp.PromedioProgreso;

CREATE OR REPLACE VIEW Vista_Detallada_Ventas AS
SELECT 
    i.ID_Curso,
    i.ID_Usuario AS Alumno,
    CONCAT(u.Nombre, ' ', u.Apellidos) AS Nombre,
    i.Fecha_Inscripcion,
    COALESCE(CalcularProgresoCurso(i.ID_Usuario, i.ID_Curso), 0) AS Progreso,
    i.Monto_Pagado,
    i.Forma_de_Pago,
    CASE 
        WHEN i.Fecha_Terminacion IS NOT NULL THEN 'Completado'
        ELSE 'En Progreso'
    END AS Estado
FROM Inscripciones i
INNER JOIN Usuario u ON i.ID_Usuario = u.ID_Usuario;


CREATE OR REPLACE VIEW View_InstructoresEstadisticas AS
SELECT 
    u.Email AS Usuario,
    CONCAT(u.Nombre, ' ', u.Apellidos) AS Nombre,
    u.Fech_Registro AS FechaIngreso,
    COUNT(DISTINCT c.ID_Curso) AS CursosOfrecidos, -- Asegura que se cuenten cursos únicos
    IFNULL(SUM(vtc.VentasTotales), 0) AS Ganancias
FROM Usuario u
LEFT JOIN Curso c 
    ON u.ID_Usuario = c.ID_Instructor AND c.Status = 1
LEFT JOIN Ventas_Totales_Cursos vtc 
    ON vtc.ID_Curso = c.ID_Curso
WHERE u.Rol = 'Instructor' AND u.Status = 1
GROUP BY u.ID_Usuario, u.Email, u.Nombre, u.Apellidos, u.Fech_Registro;


CREATE OR REPLACE VIEW View_AlumnosEstadisticas AS
SELECT 
    u.Email AS Usuario,
    CONCAT(u.Nombre, ' ', u.Apellidos) AS Nombre,
    u.Fech_Registro AS FechaIngreso,
    COUNT(i.ID_Inscripcion) AS CursosInscritos,
    ROUND(
        (SUM(CASE WHEN i.Fecha_Terminacion IS NOT NULL THEN 1 ELSE 0 END) * 100.0) / 
        COUNT(i.ID_Inscripcion), 
        2
    ) AS PorcentajeCursosTerminados
FROM Usuario u
LEFT JOIN Inscripciones i 
    ON u.ID_Usuario = i.ID_Usuario AND i.Status = 1
WHERE u.Rol = 'Alumno' AND u.Status = 1
GROUP BY u.ID_Usuario, u.Email, u.Nombre, u.Apellidos, u.Fech_Registro;

CREATE OR REPLACE VIEW VistaComentariosConUsuarios AS
SELECT 
    Comentario.ID_Comentario,
    Comentario.ID_Curso,
    Comentario.ID_Usuario,
    Usuario.Nombre,
    Usuario.Apellidos,
    Usuario.Foto AS Imagen_Perfil,
    Comentario.Titulo AS Titulo_Comentario,
    Comentario.Comentario AS Descripcion_Comentario,
    Comentario.Calificacion,
    Comentario.Fecha_Creacion,
    Comentario.Motivo_Eliminacion,
    Comentario.Status AS Status_Comentario,
    Usuario.Status AS Status_Usuario
FROM 
    Comentario
JOIN 
    Usuario ON Comentario.ID_Usuario = Usuario.ID_Usuario;

