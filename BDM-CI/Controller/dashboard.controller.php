<?php
require "Model/User.php";
require "Model/Course.php";
require "Model/Category.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$categoryDb = new Category($config['database']);
$coursesFav = $courseDb->getFavCourses();
$generalCourses = $courseDb->getCoursesWithInstructorsFromView();
$categories = $categoryDb->getCategories();

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

require "Views/dashboard.view.php";