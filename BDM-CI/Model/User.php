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

    public function getUserById($id){
        $query = "SELECT * FROM Usuario WHERE ID_Usuario = :id";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
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

    public function updateUser($ID_usuario, $nombre, $apellido, $genero, $fechaNacimiento, $foto, $password) {
        try {
            // Iniciar transacción
            $this->con->getCon()->beginTransaction();
    
            // Preparar la llamada al procedimiento
            $stmt = $this->con->getCon()->prepare('CALL UpdateUsuario(:ID_usuario, :nombre, :apellido, :genero, :fechaNacimiento, :foto, :password)');
    
            // Hashear la contraseña solo si se proporciona una nueva
            $hashedPassword = $password ? password_hash($password, PASSWORD_BCRYPT) : null;
    
            // Vincular los parámetros
            $stmt->bindParam(':ID_usuario', $ID_usuario, PDO::PARAM_INT);
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->bindParam(':apellido', $apellido, PDO::PARAM_STR);
            $stmt->bindParam(':genero', $genero, PDO::PARAM_STR);
            $stmt->bindParam(':fechaNacimiento', $fechaNacimiento, PDO::PARAM_STR);
            
            // Manejar la foto
            if ($foto !== null) {
                $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB);
                echo "Tamaño de la imagen: " . strlen($foto) . " bytes";
            } else {
                $stmt->bindValue(':foto', null, PDO::PARAM_NULL);
            }
    
            // Manejar la contraseña
            if ($hashedPassword !== null) {
                $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            } else {
                $stmt->bindValue(':password', null, PDO::PARAM_NULL);
            }
    
            // Ejecutar la consulta
            $stmt->execute();
    
            // Confirmar la transacción
            $this->con->getCon()->commit();
    
            return ['status' => 'success', 'message' => 'Usuario actualizado exitosamente'];
        } catch (PDOException $e) {
            // Revertir la transacción en caso de error
            $this->con->getCon()->rollBack();
            
            $errorInfo = $e->errorInfo;
            $errorCode = $errorInfo[1] ?? 'Unknown';
            $errorMessage = $errorInfo[2] ?? $e->getMessage();
    
            return [
                'status' => 'error',
                'message' => "Error al actualizar usuario. Código: $errorCode. Detalles: $errorMessage"
            ];
        }
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
            $stmt->bindParam(':foto', $foto, PDO::PARAM_LOB); 
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
