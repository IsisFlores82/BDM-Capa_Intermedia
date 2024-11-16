use BDMCAPA;


CREATE VIEW CoursesWithInstructors AS
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
    c.Fecha_Elim
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
    COALESCE(SUM(rn.VentasTotalesNiveles), 0) AS VentasNiveles,
    (COALESCE(rc.VentasTotales, 0) + COALESCE(SUM(rn.VentasTotalesNiveles), 0)) AS VentasTotales,
    rc.Forma_de_Pago
FROM Curso c
LEFT JOIN Resumen_Inscripciones_Cursos rc ON c.ID_Curso = rc.ID_Curso
LEFT JOIN Resumen_Inscripciones_Niveles rn ON c.ID_Curso = rn.ID_Curso
GROUP BY c.ID_Curso, c.Titulo, rc.Forma_de_Pago;

