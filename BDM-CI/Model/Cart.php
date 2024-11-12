<?php

class Cart
{
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function createCartCourse($id, $id_curso,$tipo)
    {
        $query = "Insert into Carrito (ID_Usuario, ID_Curso, Tipo) VALUES (:id, :id_curso, :tipo)";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute(['id' => $id, 'id_curso' => $id_curso, 'tipo' => $tipo]);
    }

    public function createCartLevel($id, $id_nivel,$tipo)
    {
        $query = "Insert into Carrito (ID_Usuario, ID_Nivel, Tipo) VALUES (:id, :id_nivel, :tipo)";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute(['id' => $id, 'id_nivel' => $id_nivel, 'tipo' => $tipo]); 
    }

    public function getCartById($id) {        
        $query = "SELECT * FROM Carrito WHERE ID_Usuario = :id AND Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotal($id) {
        $query="SELECT ObtenerTotalComprado(:id)";
        $stmt = $this->con->getCon()->prepare($query);
        return $stmt->execute(['id' => $id]);
    }
}