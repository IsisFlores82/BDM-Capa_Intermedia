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
        $query = "INSERT INTO Inscripciones_Niveles (ID_Nivel, ID_Usuario, Fecha_Inscripcion, Monto_Pagado, Forma_de_Pago) 
                  VALUES (:nivelId, :userId, NOW(), :montoPagado,'Tarjeta')";
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

    public function procesarLog(){
        $sql= "CALL procesarNivelProgresoLogs()";
        $stmt = $this->con->getCon()->prepare($sql);
        return $stmt->execute();
    }

    public function obtenerNivelesPoseidos($userId) {
        $sql = "
            SELECT ID_Nivel, NivelTitulo, ID_Curso, CursoTitulo
            FROM View_Niveles_Poseidos
            WHERE ID_Usuario = ?
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
    
    public function actualizarProgresoNivel($idUsuario, $idNivel) {
        $sql = "
            INSERT INTO Progreso_Niveles (ID_Usuario, ID_Nivel, Fecha_Completado, Status)
            VALUES (:idUsuario, :idNivel, NOW(), 1)
            ON DUPLICATE KEY UPDATE
                Fecha_Completado = NOW(),
                Status = 1
        ";

        $stmt = $this->con->getCon()->prepare($sql);
        return $stmt->execute([
            'idUsuario' => $idUsuario,
            'idNivel' => $idNivel
        ]);
    }

    public function actualizarProgresoCurso($idUsuario, $idCurso) {
        $sql = "
            SELECT COUNT(vnp.ID_Nivel) AS TotalNiveles,
                   SUM(CASE WHEN vnp.ProgresoStatus = 1 THEN 1 ELSE 0 END) AS NivelesCompletados
            FROM View_Niveles_Progreso vnp
            WHERE vnp.ID_Usuario = :idUsuario AND vnp.ID_Curso = :idCurso
        ";
    
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute([
            'idUsuario' => $idUsuario,
            'idCurso' => $idCurso
        ]);
    
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($result && $result['TotalNiveles'] > 0 && $result['TotalNiveles'] == $result['NivelesCompletados']) {
            // Si todos los niveles están completados, marcar el curso como completado
            $updateSql = "
                UPDATE Inscripciones
                SET Fecha_Terminacion = NOW(), Status = 1
                WHERE ID_Usuario = :idUsuario AND ID_Curso = :idCurso
            ";
    
            $updateStmt = $this->con->getCon()->prepare($updateSql);
            return $updateStmt->execute([
                'idUsuario' => $idUsuario,
                'idCurso' => $idCurso
            ]);
        }
    
        return false;
    }
    
    public function getCertificadoPath($userId, $courseId)
    {
        $stmt = $this->con->getCon()->prepare("SELECT Certificado FROM Inscripciones WHERE ID_Usuario = :userId AND ID_Curso = :courseId");
        $stmt->execute([
            ':userId' => $userId,
            ':courseId' => $courseId
        ]);
        return $stmt->fetchColumn(); // Devuelve el path si existe, o null si no
    }

    public function updateCertificadoPath($userId, $courseId, $path)
    {
        $stmt = $this->con->getCon()->prepare("UPDATE Inscripciones SET Certificado = :path WHERE ID_Usuario = :userId AND ID_Curso = :courseId");
        $stmt->execute([
            ':path' => $path,
            ':userId' => $userId,
            ':courseId' => $courseId
        ]);
    }


    public function getProgreso($userId, $courseId) {
        $sql = "SELECT CalcularProgresoCurso(:idUsuario, :idCurso) AS PorcentajeProgreso";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute([
            'idUsuario' => $userId,
            'idCurso' => $courseId
        ]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
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

    public function updateLastAccess($userId, $courseId) {
        $sql = "
            UPDATE Inscripciones
            SET Fecha_Ultimo_Ingreso = NOW()
            WHERE ID_Usuario = :userId AND ID_Curso = :courseId
        ";
        $stmt = $this->con->getCon()->prepare($sql);
        return $stmt->execute([
            'userId' => $userId,
            'courseId' => $courseId
        ]);
    }
    
    
    public function getPurchasedLevels($userId, $courseId) {
        $query = "SELECT ID_Nivel 
                  FROM View_Inscripciones_Niveles_Completa 
                  WHERE ID_Usuario = ? AND ID_Curso = ? AND NivelStatus = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute([$userId, $courseId]);
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function verificarProgresoNivel($userId, $nivelId) {
        $sql = "
            SELECT ProgresoStatus 
            FROM View_Niveles_Progreso 
            WHERE ID_Usuario = :userId AND ID_Nivel = :nivelId
        ";
        
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute([
            'userId' => $userId,
            'nivelId' => $nivelId
        ]);
        
        $resultado = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Si no se encuentra el registro, el nivel no está completado.
        return $resultado ? $resultado['ProgresoStatus'] : 0;
    }
    
    
}