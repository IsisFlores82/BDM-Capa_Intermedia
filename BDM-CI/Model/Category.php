<?php

class Category {
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    // Obtener todas las categorías
    public function getCategories() {
        $query = "SELECT * FROM Categorias where Status = 1";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Crear nueva categoría
    public function addCategory($name, $description, $userId) {
        $query = "INSERT INTO Categorias (Nombre, Descripcion, ID_Usuario) VALUES (:name, :description, :userId)";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':userId', $userId);
        return $stmt->execute();
    }

    // Actualizar categoría
    public function updateCategory($id, $name, $description) {
        $query = "UPDATE Categorias SET Nombre = :name, Descripcion = :description WHERE ID_Categoria = :id";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    // Eliminar categoría
    public function deleteCategory($id) {
        $query = "UPDATE Categorias SET Status = 0 WHERE ID_Categoria = :id";
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
