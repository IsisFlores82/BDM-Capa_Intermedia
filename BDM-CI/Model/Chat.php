<?php

class Chat{

    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }
    
    public function getChatMessages($id_usuario, $id_receptor){
        $sql = "SELECT * FROM Mensajes 
                WHERE (ID_Emisor = :id_usuario AND ID_Receptor = :id_receptor) 
                   OR (ID_Emisor = :id_receptor AND ID_Receptor = :id_usuario)
                ORDER BY Fecha_Envio ASC";
        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute(['id_usuario' => $id_usuario, 'id_receptor' => $id_receptor]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function sendMessage($id_emisor, $id_receptor, $mensaje) {
    $sql = "INSERT INTO Mensajes (ID_Emisor, ID_Receptor, Mensaje) 
        VALUES (:id_emisor, :id_receptor, :mensaje)";
    $stmt = $this->con->getCon()->prepare($sql);
    $stmt->execute([
        ':id_emisor' => $id_emisor,
        ':id_receptor' => $id_receptor,
        ':mensaje' => $mensaje,
    ]);
}
}