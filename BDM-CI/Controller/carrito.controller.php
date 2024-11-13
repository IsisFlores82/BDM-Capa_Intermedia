<?php
require "Model/User.php";
require "Model/Course.php";
require "Model/Level.php";
require "Model/Cart.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$levelDb = new Level($config['database']);
$cartDb = new Cart($config['database']);
if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
}

$carrito = $cartDb->getCartById($id);
// Enriquecer los datos del carrito con detalles de curso o nivel
$carritoEnriquecido = [];

foreach ($carrito as $item) {
    if ($item['Tipo'] === 'curso') {
        // Obtener datos del curso
        $curso = $courseDb->getCourseById($item['ID_Curso']);
        if ($curso) {
            $item['Course_Title'] = $curso['Titulo'];
            $item['Course_Image'] = $curso['Imagen'];
            $item['Course_Price'] = $curso['Costo_Total'];
            
            // Obtener datos del instructor
            $instructor = $userDb->getUserById($curso['ID_Instructor']);
            $item['Instructor_Nombre'] = $instructor['Nombre'] ?? 'N/A';
            $item['Instructor_Apellidos'] = $instructor['Apellidos'] ?? 'N/A';
        } else {
            // Datos por defecto en caso de que no se encuentre el curso
            $item['Course_Title'] = 'Curso no encontrado';
            $item['Course_Image'] = null;
            $item['Course_Price'] = 0;
            $item['Instructor_Nombre'] = 'N/A';
            $item['Instructor_Apellidos'] = 'N/A';
        }
    } elseif ($item['Tipo'] === 'nivel') {
        // Obtener datos del nivel
        $nivel = $levelDb->getLevelById($item['ID_Nivel']);
        if ($nivel) {
            $item['Level_Title'] = $nivel['Titulo'];
            $item['Level_Price'] = $nivel['Costo_Nivel'];
            
            // Obtener datos del curso al que pertenece el nivel
            $curso = $courseDb->getCourseById($nivel['ID_Curso']);
            if ($curso) {
                $item['Course_Title'] = $curso['Titulo'];
                
                // Obtener datos del instructor
                $instructor = $userDb->getUserById($curso['ID_Instructor']);
                $item['Instructor_Nombre'] = $instructor['Nombre'] ?? 'N/A';
                $item['Instructor_Apellidos'] = $instructor['Apellidos'] ?? 'N/A';
            } else {
                // Datos por defecto si el curso no existe
                $item['Course_Title'] = 'Curso no encontrado';
                $item['Instructor_Nombre'] = 'N/A';
                $item['Instructor_Apellidos'] = 'N/A';
            }
        } else {
            // Datos por defecto si no se encuentra el nivel
            $item['Level_Title'] = 'Nivel no encontrado';
            $item['Level_Price'] = 0;
            $item['Course_Title'] = 'Curso no encontrado';
            $item['Instructor_Nombre'] = 'N/A';
            $item['Instructor_Apellidos'] = 'N/A';
        }
        $item['Course_Image'] = null; // Niveles no tienen imagen
    }
    $carritoEnriquecido[] = $item;
}


$total = $cartDb->getTotal($id);
$totalAmount = $total['Total']; // Acceso más directo
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  
}

if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/carrito.view.php";