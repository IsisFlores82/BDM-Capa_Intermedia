<?php

class Level
{
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function createLevel($data)
    {
        $query = "CALL createNivel (:ID_Curso, :Titulo, :Costo_Nivel, :Video, :Adjunto)";
        
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':ID_Curso', $data['ID_Curso']);
        $stmt->bindParam(':Titulo', $data['Titulo']);
        $stmt->bindParam(':Costo_Nivel', $data['Costo_Nivel']);
        $stmt->bindParam(':Video', $data['Video']);
        $stmt->bindParam(':Adjunto', $data['Adjunto']);
        
        return $stmt->execute();
    }
}