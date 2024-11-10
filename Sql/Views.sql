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