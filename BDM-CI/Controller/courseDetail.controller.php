<?php

require "Model/User.php";
require "Model/Course.php";
require "Model/Category.php";
require "Model/Level.php";
require "Model/Cart.php";
require "Model/Comment.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$categoryDb = new Category($config['database']);
$levelDb = new Level($config['database']);
$cartDb= new Cart($config['database']);
$commentDb = new Comment($config['database']);
if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
}else{
    $id=0;
    $user=null;
}
// ID del curso obtenido desde la URL o el formulario
$courseId = $_GET['id'] ?? null;

// Obtener detalles del curso
$course = $courseDb->getCourseById($courseId);
if(empty($course)){
    header("Location: /BDM-CI/dashboard");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verificar si estamos recibiendo datos para eliminar un comentario
    if (isset($_POST['id_comentario']) && isset($_POST['_method']) && $_POST['_method'] === 'DELETE') {
        // Eliminar un comentario
        $id_comentario = $_POST['id_comentario'];
        $motivo_eliminacion = $_POST['motivo_eliminacion'];
        $id_curso = $_POST['id_curso'];
        try {
            $commentDb->deleteComment($id_comentario, $motivo_eliminacion);
            $_SESSION['mensaje'] = ['text' => 'Comentario eliminado exitosamente.', 'type' => 'success'];
        } catch (PDOException $e) {
            $_SESSION['mensaje'] = ['text' => 'Error al eliminar el comentario.', 'type' => 'error'];
        }

        // Redirigir a la página de detalles del curso
        $id_curso = $_POST['id_curso'];  // Obtener el ID del curso para redirigir
        header('Location: /BDM-CI/courseDetail?id=' . $id_curso);
        exit();
    }

    // Si es para agregar al carrito
    $id_usuario = $_POST['id_usuario'];  // ID del usuario
    $tipo = $_POST['tipo'];              // Tipo: 'curso' o 'nivel'
    $id_curso = $_POST['id_curso'];

    // Si es un nivel
    if ($tipo === 'nivel') {
        $id_nivel = $_POST['id_nivel'];
        try {
            $cartDb->createCartLevel($id_usuario, $id_nivel, $tipo);
            $_SESSION['mensaje'] = ['text' => 'Nivel agregado al carrito exitosamente.', 'type' => 'success'];
        }
        catch (PDOException $e) {
            $_SESSION['mensaje'] = ['text' => 'Error al agregar el nivel al carrito.', 'type' => 'error'];
        }
    }

    // Si es un curso
    if ($tipo === 'curso') {
        try {
            $cartDb->createCartCourse($id_usuario, $id_curso, $tipo);
            $_SESSION['mensaje'] = ['text' => 'Curso agregado al carrito exitosamente.', 'type' => 'success'];
        }
        catch (PDOException $e) {
            $_SESSION['mensaje'] = ['text' => 'Error al agregar el curso al carrito.', 'type' => 'error'];
        }
    }

    // Redirigir al curso después de agregar al carrito
    header('Location: /BDM-CI/courseDetail?id='. $id_curso);
    exit();
}


// Obtener niveles del curso
$levels = $levelDb->getLevelsByCourse($courseId);

// Obtener nombre de la categoría
$categoryCourse = $categoryDb->getCategoryById($course['ID_Categoria']);

// Obtener calificación del curso
$calificacion = $courseDb->getCourseRating($courseId);
// Obtener comentarios del curso    
$comentarios = $commentDb->getCourseComments($courseId);
// Obtener nombre completo del instructor
$instructorUser = $userDb->getUserById($course['ID_Instructor']);
$instructor= $instructorUser['Nombre'] . " " . $instructorUser['Apellidos'];


if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/courseDetail.view.php";