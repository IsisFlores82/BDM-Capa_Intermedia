<?php
class SalesReport {
    private $con;

    public function __construct($config){
        $this->con = new Conexion($config);
    }

    // Fetch summary of sales for a specific instructor using the created views
    public function getInstructorSalesSummary($id_instructor) {
        // Usar la vista Ventas_Totales_Cursos en lugar de hacer un JOIN adicional
        $query = "SELECT Forma_de_Pago, SUM(VentasTotales) AS TotalPagado
                  FROM Ventas_Totales_Cursos
                  WHERE ID_Instructor = ?
                  GROUP BY Forma_de_Pago";
        
        // Usar PDO para preparar la consulta
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindValue(1, $id_instructor, PDO::PARAM_INT); // Vincula el parámetro
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Fetch sales report by date, category, and course status using the views
    public function getSalesReport($id_instructor, $start_date = null, $end_date = null, $category_id = null, $estado_curso = null) {
        // Query the Ventas_Totales_Cursos view directly
        $query = "SELECT ID_Curso, Titulo, VentasCursos, VentasNiveles, VentasTotales
                  FROM Ventas_Totales_Cursos
                  WHERE ID_Instructor = ? 
                  AND (? IS NULL OR Fecha_Creacion >= ?)
                  AND (? IS NULL OR Fecha_Creacion <= ?)
                  AND (? IS NULL OR ID_Categoria = ?)
                  AND (? = 2 OR Status = ?)";
        
        // Usar PDO para preparar la consulta
        $stmt = $this->con->getCon()->prepare($query);
        $stmt->bindValue(1, $id_instructor, PDO::PARAM_INT); // Vincula el parámetro
        $stmt->bindValue(2, $start_date, PDO::PARAM_STR); // Vincula start_date
        $stmt->bindValue(3, $start_date, PDO::PARAM_STR); // Vincula start_date para la condición
        $stmt->bindValue(4, $end_date, PDO::PARAM_STR); // Vincula end_date
        $stmt->bindValue(5, $end_date, PDO::PARAM_STR); // Vincula end_date para la condición
        $stmt->bindValue(6, $category_id, PDO::PARAM_INT); // Vincula category_id
        $stmt->bindValue(7, $category_id, PDO::PARAM_INT); // Vincula category_id para la condición
        $stmt->bindValue(8, $estado_curso, PDO::PARAM_INT); // Vincula estado_curso
        $stmt->bindValue(9, $estado_curso, PDO::PARAM_INT); // Vincula estado_curso para la condición
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}


