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
    i.Fecha_Inscripcion
FROM 
    Inscripciones i
JOIN 
    Curso c ON i.ID_Curso = c.ID_Curso
WHERE 
    i.Status = 1; -- Solo cursos activos


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