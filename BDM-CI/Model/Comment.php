<?php

class Comment {
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function addComment($id, $titulo, $calificacion, $comentario, $idCurso) {
        $query = "INSERT INTO Comentario (ID_Usuario, Titulo, Calificacion, Comentario, ID_Curso) VALUES (:id, :titulo, :calificacion, :comentario, :idCurso)";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titulo', $titulo);
        $stmt->bindParam(':calificacion', $calificacion);
        $stmt->bindParam(':comentario', $comentario);
        $stmt->bindParam(':idCurso', $idCurso);
        return $stmt->execute();
    }

    public function getCourseComments($idCurso) {
        $query = "SELECT * FROM VistaComentariosConUsuarios WHERE ID_Curso = :idCurso";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['idCurso' => $idCurso]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteComment($id_comentario, $motivo) {
        // Actualizar el estado del comentario y guardar el motivo de eliminación
        $query = "UPDATE Comentario SET Status = 0, Motivo_Eliminacion = :motivo WHERE ID_Comentario = :id_comentario";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':motivo', $motivo);
        $stmt->bindParam(':id_comentario', $id_comentario);
        return $stmt->execute();
    }
}