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

    public function getCoursesWithInstructorsFromView() {
        $query = "SELECT * FROM CoursesWithInstructors WHERE Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchCursos($filters) {
        $sql = "
            SELECT *
            FROM CoursesWithInstructors
            WHERE Status = 1
        ";
        
        $params = [];
        
        // Filtros dinámicos
        if (!empty($filters['title'])) {
            $sql .= " AND Course_Title LIKE :title";
            $params['title'] = '%' . $filters['title'] . '%';
        }
        
        if (!empty($filters['category'])) {
            $sql .= " AND ID_Categoria = :category";
            $params['category'] = $filters['category'];
        }
        
        if (!empty($filters['author'])) {
            $sql .= " AND CONCAT(Instructor_Nombre, ' ', Instructor_Apellidos) LIKE :author";
            $params['author'] = '%' . $filters['author'] . '%';
        }
        
        if (!empty($filters['startDate'])) {
            $sql .= " AND Fecha_Creacion >= :startDate";
            $params['startDate'] = $filters['startDate'];
        }
        
        if (!empty($filters['endDate'])) {
            $sql .= " AND Fecha_Creacion <= :endDate";
            $params['endDate'] = $filters['endDate'];
        }
        
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute($params);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getCoursesWithInstructorsFromViewById($id) {
        $query = "SELECT * FROM CoursesWithInstructors WHERE ID_Curso = :id AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCourseById($id) {        
        $query = "SELECT * FROM Curso WHERE ID_Curso = :id AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCourseTitle($id) {
        $query = "SELECT Titulo FROM Curso WHERE ID_Curso = :id AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchColumn();
    }

    public function getCourseRating($id) {
        $query = "SELECT CalcularPromedioCurso(:id) AS CalificacionPromedio";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        $result = $stmt->fetchColumn();
        
        if ($result === false) {
            return 0; // Devuelve 0 si el curso no existe o no tiene comentarios
        }
        return $result;
    }

    public function getTotalActiveCourses()
    {
        $query = "SELECT COUNT(*) AS TotalCursos FROM Curso WHERE Status = 1";
        return $this->con->getCon()->query($query)->fetchColumn();
    }

    public function getTotalCategories()
    {
        $query = "SELECT COUNT(*) AS TotalCategorias FROM Categorias WHERE Status = 1";
        return $this->con->getCon()->query($query)->fetchColumn();
    }

    public function getFavCourses() {
        $queryFav = "SELECT * FROM CoursesWithInstructors ORDER BY Average_Rating DESC LIMIT 2";
        $stmtFav = $this->con->getCon()->prepare($queryFav);
        $stmtFav->execute();
        return $stmtFav->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFeaturedCourses() {
        $query = "SELECT * FROM CoursesWithInstructors WHERE Status = 1 ORDER BY RAND() LIMIT 2";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllCourses() {
        $query = "SELECT * FROM Curso WHERE Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function validateCourseOwnership($id, $instructorId) {
        $query = "SELECT * FROM Curso WHERE ID_Curso = :id AND ID_Instructor = :instructorId AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id, 'instructorId' => $instructorId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCoursesByInstructor($id) {
        $query = "SELECT * FROM Curso WHERE ID_Instructor = :id AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteCourse($id, $instructorId) {
        $query = "UPDATE Curso SET Status = 0, Fecha_Elim = NOW() WHERE ID_Curso = :id AND ID_Instructor = :instructorId";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute(['id' => $id, 'instructorId' => $instructorId]);
    }
    // Función para actualizar el curso
    public function updateCourse($courseId, $title, $description, $categoryId, $price, $isFree, $imageData) {
        $stmt = $this->con->getCon()->prepare("CALL UpdateCourse(?, ?, ?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $courseId, PDO::PARAM_INT);
        $stmt->bindParam(2, $title, PDO::PARAM_STR);
        $stmt->bindParam(3, $description, PDO::PARAM_STR);
        $stmt->bindParam(4, $categoryId, PDO::PARAM_INT);
        $stmt->bindParam(5, $price, PDO::PARAM_STR);
        $stmt->bindParam(6, $isFree, PDO::PARAM_INT);
        $stmt->bindParam(7, $imageData, PDO::PARAM_LOB);
        return $stmt->execute();
    }

}