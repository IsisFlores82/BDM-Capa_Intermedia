<?php
require 'Conexion.php';
class User{

    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function getUsers(){
        $query= $this->con->getCon()->query('SELECT * FROM Usuario');

        $return=[];
        $i=0;
        while($fila=$query->fetch(PDO::FETCH_ASSOC)){
            $return[$i]=$fila;
            $i++;
        }

        return $return;
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM Usuario WHERE Email = :email";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function incrementFailedAttempts($email) {
        $query = "UPDATE Usuario SET Failed_Attempts = Failed_Attempts + 1 WHERE Email = :email";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['email' => $email]);

        $query = "SELECT Failed_Attempts FROM Usuario WHERE Email = :email";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['email' => $email]);
        return $stmt->fetchColumn();
    }
    
    public function resetFailedAttempts($email) {
        $query = "UPDATE Usuario SET Failed_Attempts = 0 WHERE Email = :email";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['email' => $email]);
    }
    
    public function disableUser($email) {
        $query = "CALL disableUser(:email)";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['email' => $email]);
    }

    public function registerUser($email, $nombre, $apellido, $genero, $fechaNacimiento, $rol, $foto, $password) {
        try {
            // Preparar la llamada al procedimiento
            $stmt = $this->con->getCon()->prepare('CALL RegistrarUsuario(:email, :nombre, :apellido, :genero, :fechaNacimiento, :rol, :foto, :password, @mensaje)');
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            // Vincular los parámetros
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':nombre', $nombre);
            $stmt->bindParam(':apellido', $apellido);
            $stmt->bindParam(':genero', $genero);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento);
            $stmt->bindParam(':rol', $rol);
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB); // Guardar la foto como BLOB
            $stmt->bindParam(':password', $hashedPassword);
            
            // Ejecutar la consulta
            $stmt->execute();
            
            // Obtener el mensaje de salida
            $mensajeStmt = $this->con->getCon()->query('SELECT @mensaje AS mensaje');
            $mensaje = $mensajeStmt->fetch(PDO::FETCH_ASSOC)['mensaje'];
            
            return $mensaje; // Retorna el mensaje
        } catch (Exception $e) {
            return 'Error al registrar usuario: ' . $e->getMessage();
        }
    }
}
