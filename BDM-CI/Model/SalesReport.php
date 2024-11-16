<?php
class SalesReport {
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    // Fetch summary of sales for a specific instructor using the created views
    public function getInstructorSalesSummary($id_instructor) {
        // Usar la vista Ventas_Totales_Cursos en lugar de hacer un JOIN adicional
        $query = "SELECT MetodosPago, SUM(VentasTotales) AS TotalPagado
                  FROM Ventas_Totales_Cursos
                  WHERE ID_Instructor = ?
                  GROUP BY MetodosPago";
        
        // Usar PDO para preparar la consulta
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindValue(1, $id_instructor, PDO::PARAM_INT); // Vincula el parámetro
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDetailedSales($courseId, $startDate , $endDate, $status) {
        $query = "
            SELECT *
            FROM Vista_Detallada_Ventas
            WHERE ID_Curso = :courseId
        ";
    
        $params = ['courseId' => $courseId];
    
        if ($startDate) {
            $query .= " AND Fecha_Inscripcion >= :startDate";
            $params['startDate'] = $startDate;
        }
        if ($endDate) {
            $query .= " AND Fecha_Inscripcion <= :endDate";
            $params['endDate'] = $endDate;
        }
        if ($status !== 'todos') {
            if ($status === 'progreso') {
                $query .= " AND Estado = 'En Progreso'";
            } else if ($status === 'completado') {
                $query .= " AND Estado = 'Completado'";
            }
        }
    
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCoursesSummary($id_instructor, $startDate, $endDate, $category, $status) {
        $query = "
            SELECT 
                ID_Curso, 
                Titulo, 
                AlumnosInscritos, 
                PromedioProgreso, 
                Estado, 
                VentasCursos, 
                VentasNiveles, 
                VentasTotales, MetodosPago
            FROM Ventas_Totales_Cursos
            WHERE ID_Instructor = :id_instructor
        ";
    
        // Parámetros para la consulta
        $params = ['id_instructor' => $id_instructor];
    
        // Filtros dinámicos
        if ($startDate) {
            $query .= " AND Fecha_Creacion >= :startDate";
            $params['startDate'] = $startDate;
        }
        if ($endDate) {
            $query .= " AND Fecha_Creacion <= :endDate";
            $params['endDate'] = $endDate;
        }
        if ($category) {
            $query .= " AND ID_Categoria = :category";
            $params['category'] = $category;
        }
        if ($status !== 'todos') {
            if ($status === 'activo') {
                $query .= " AND Status = 1";
            } elseif ($status === 'inactivo') {
                $query .= " AND Status = 0";
            }
        }
    
        // Preparar y ejecutar la consulta
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->execute($params);
    
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
}


