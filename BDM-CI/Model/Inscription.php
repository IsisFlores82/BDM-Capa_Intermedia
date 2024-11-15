<?php

class Inscription
{
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function getInscriptionById($id)
    {
        $query = "SELECT * FROM Inscripciones WHERE ID_Inscripcion = :id";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function agregarCurso($cursoId, $userId, $montoPagado) {
        $query = "INSERT INTO Inscripciones (ID_Curso, ID_Usuario, Fecha_Inscripcion, Monto_Pagado, Forma_de_Pago) 
                  VALUES (:cursoId, :userId, NOW(), :montoPagado, 'Tarjeta')";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute([
            'cursoId' => $cursoId,
            'userId' => $userId,
            'montoPagado' => $montoPagado
        ]);
    }
    
    public function agregarNivel($nivelId, $userId, $montoPagado) {
        $query = "INSERT INTO Inscripciones_Niveles (ID_Nivel, ID_Usuario, Fecha_Inscripcion, Monto_Pagado) 
                  VALUES (:nivelId, :userId, NOW(), :montoPagado)";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute([
            'nivelId' => $nivelId,
            'userId' => $userId,
            'montoPagado' => $montoPagado
        ]);
    }
    
    public function getUserCourses($userId) {
        $sql = "SELECT DISTINCT ID_Curso, CursoTitulo, CursoDescripcion, CursoImagen
                FROM View_Inscripciones_Combinadas 
                WHERE ID_Usuario = :userId";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCoursesByUser($userId) {
        $sql = "SELECT * FROM View_Inscripciones_Cursos WHERE ID_Usuario = :userId";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLevelsByUser($userId) {
        $sql = "SELECT * FROM View_Inscripciones_Niveles WHERE ID_Usuario = :userId";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAccessibleCourses($userId) {
        $sql = "SELECT * FROM View_Inscripciones_Combinadas WHERE ID_Usuario = :userId";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute(['userId' => $userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function obtenerNivelesPoseidos($userId) {
        $sql = "
            SELECT DISTINCT 
            IFNULL(inl.ID_Nivel, n.ID_Nivel) AS ID_Nivel,
            n.Titulo AS NivelTitulo,
            n.ID_Curso,
            c.Titulo AS CursoTitulo
        FROM 
            View_Inscripciones_Combinadas inl
        LEFT JOIN 
            Nivel n ON inl.ID_Curso = n.ID_Curso
        LEFT JOIN 
            Curso c ON n.ID_Curso = c.ID_Curso
        WHERE 
            inl.ID_Usuario = :
            AND (inl.ID_Nivel IS NULL OR inl.ID_Nivel = n.ID_Nivel)
            AND c.Status = 1 
            AND (n.Status = 1 OR n.Status IS NULL);
        ";
    
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function llenarProgresoNiveles($userId) {
        $niveles = $this->obtenerNivelesPoseidos($userId);
    
        $sql = "
            INSERT IGNORE INTO Progreso_Niveles (ID_Usuario, ID_Nivel, Status)
            VALUES (?, ?, 0)
        ";
    
        $stmt = $this->con->getCon()->prepare($sql);
        foreach ($niveles as $nivel) {
            $stmt->execute([$userId, $nivel['ID_Nivel']]);
        }
    }

    public function isCoursePurchased($userId, $courseId) {
        $query = "SELECT COUNT(*) 
                  FROM Inscripciones 
                  WHERE ID_Usuario = ? AND ID_Curso = ? AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute([$userId, $courseId]);
        $result = $stmt->fetchColumn();
        return $result > 0;
    }
    
    public function getPurchasedLevels($userId, $courseId) {
        $query = "SELECT ID_Nivel 
                  FROM View_Inscripciones_Niveles_Completa 
                  WHERE ID_Usuario = ? AND ID_Curso = ? AND NivelStatus = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute([$userId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    
}