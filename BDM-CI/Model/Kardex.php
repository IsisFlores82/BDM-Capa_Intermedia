<?php

class Kardex {
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    public function getCursosKardex($userId, $startDate, $endDate, $category, $status) {
        $sql = "
            SELECT *
            FROM KardexUsuario
            WHERE ID_Usuario = :userId
        ";

        // Filtros dinámicos
        $params = ['userId' => $userId];
        if ($startDate) {
            $sql .= " AND Fecha_Inscripcion >= :startDate";
            $params['startDate'] = $startDate;
        }
        if ($endDate) {
            $sql .= " AND Fecha_Inscripcion <= :endDate";
            $params['endDate'] = $endDate;
        }
        if ($category) {
            $sql .= " AND Categoria = :category";
            $params['category'] = $category;
        }
        if ($status !== 'todos') {
            if ($status === 'completado') {
                $sql .= " AND Estado = 'Completado'";
            } elseif ($status === 'activo') {
                $sql .= " AND Estado = 'Activo'";
            }
        }

        $stmt = $this->con->getCon()->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
