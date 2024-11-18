<?php
require "Model/User.php";
require "Model/Course.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}
$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);

 // Obtener instructores activos
 $instructores = $userDb->getInstructorsWithStats();

 // Obtener alumnos activos
 $alumnos = $userDb->getStudentsWithStats();

 // Obtener recuentos generales
 $totalAlumnos = count($alumnos);
 $totalInstructores = count($instructores);
 $totalCursos = $courseDb->getTotalActiveCourses();
 $totalCategorias = $courseDb->getTotalCategories();

if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/reporteUsuarios.view.php";