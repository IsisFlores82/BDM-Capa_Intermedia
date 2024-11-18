<?php
require "Model/User.php";
require "Model/Course.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$cursoDb = new Course($config['database']);
if (isset($_SESSION['user'])) {
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
}



$filters = [
    'title' => $_GET['title'] ?? null,
    'category' => $_GET['category'] ?? null,
    'author' => $_GET['author'] ?? null,
    'startDate' => $_GET['startDate'] ?? null,
    'endDate' => $_GET['endDate'] ?? null,
];

$cursos = $cursoDb->searchCursos($filters);
if(isset($_SESSION['user'])){
    $id = $_SESSION['user']['ID_Usuario'];
    $user = $userDb->getUserById($id);
    }
    
    if (!empty($user['Foto'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($user['Foto']);
        $fotoBase64 = base64_encode($user['Foto']);
        $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
    } else {
        $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
    }

require "Views/search.view.php";