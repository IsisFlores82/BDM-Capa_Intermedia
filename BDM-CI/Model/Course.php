<?php

class Course
{
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function createCourse($data)
    {
        $query = "CALL CreateCourse (:Titulo, :Descripcion, :Imagen, :Costo_Total, :Gratuito, :ID_Instructor, :ID_Categoria)";
        
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':Titulo', $data['Titulo']);
        $stmt->bindParam(':Descripcion', $data['Descripcion']);
        $stmt->bindParam(':Imagen', $data['Imagen'], PDO::PARAM_LOB);
        $stmt->bindParam(':Costo_Total', $data['Costo_Total']);
        $stmt->bindParam(':Gratuito', $data['Gratuito'], PDO::PARAM_BOOL);
        $stmt->bindParam(':ID_Instructor', $data['ID_Instructor']);
        $stmt->bindParam(':ID_Categoria', $data['ID_Categoria']);
        
        $stmt->execute();

        // Fetch the result to get the new course ID
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['new_course_id']; 
    }
}