<?php

require "Model/User.php";
require "Model/Course.php";
require "Model/Category.php";
require "Model/Level.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$categoryDb = new Category($config['database']);
$levelDb = new Level($config['database']);

if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
}
// ID del curso obtenido desde la URL o el formulario
$courseId = $_GET['id'] ?? null;

// Obtener detalles del curso
$course = $courseDb->getCourseById($courseId);
if(empty($course)){
    header("Location: /BDM-CI/dashboard");
    exit;
}
// Obtener niveles del curso
$levels = $levelDb->getLevelsByCourse($courseId);

// Obtener nombre de la categoría
$category = $categoryDb->getCategoryById($course['ID_Categoria']);

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