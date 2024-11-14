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
    
}