<?php

require "Model/Course.php";
require "Model/Level.php";
require "Model/User.php";
require "Model/Category.php";
$config = require 'config.php';

$userDb = new User($config['database']);
$categoryDb = new Category($config['database']);
$courseDb = new Course($config['database']);
$levelDb = new Level($config['database']);
$categories = $categoryDb->getCategories();

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);

if (isset($_GET['id'])) {
    $courseId = $_GET['id'];
    if($course = $courseDb->validateCourseOwnership($courseId, $id)){
        $levels = $levelDb->getLevelsByCourse($courseId);
    }else{
        header("Location: /BDM-CI/profileInstructor");
        exit;
    }
}


// Directory structure
$resourceDir = "Resourcer_Cursos/$id/";
if (!file_exists($resourceDir)) {
    mkdir($resourceDir, 0777, true);
}


if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/editCourse.view.php";