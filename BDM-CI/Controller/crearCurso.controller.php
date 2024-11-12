<?php

require "Model/User.php";
require "Model/Category.php";
require "Model/Course.php";
require "Model/Level.php";
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

// Directory structure
$resourceDir = "Resourcer_Courses/$id/";
if (!file_exists($resourceDir)) {
    mkdir($resourceDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    dd($_POST);
    // Handle Course Data
    $courseData = [
        'Titulo' => $_POST['Titulo'],
        'Descripcion' => $_POST['Descripcion'],
        'ID_Categoria' => $_POST['ID_Categoria'],
        'Gratuito' => $_POST['Gratuito'], // Si está marcado, se pone 1
        'Costo_Total' => isset($_POST['Costo_Total']) && $_POST['Costo_Total'] !== '' && $_POST['Gratuito'] == '0' ? $_POST['Costo_Total'] : 0, // Si está marcado, se pone 0
        'ID_Instructor' => $id
    ];
    $imageData = null;
    if (!empty($_FILES['Imagen']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['Imagen']['tmp_name']);
    }
    $courseData['Imagen'] = $imageData;
    $courseID = $courseDb->createCourse($courseData);

    // Handle Levels
    foreach ($_POST['Nivel'] as $index => $nivelData) {
        $videoPath = null;
        $attachmentPath = null;
        // Upload Video
        if (!empty($_FILES['Nivel']['tmp_name'][$index]['Video'])) {
            $videoName = basename($_FILES['Nivel']['name'][$index]['Video']);
            $videoPath = $resourceDir . $videoName;
            move_uploaded_file($_FILES['Nivel']['tmp_name'][$index]['Video'], $videoPath);
        }

        // Upload Attachment
        if (!empty($_FILES['Nivel']['tmp_name'][$index]['Adjunto'])) {
            $attachmentName = basename($_FILES['Nivel']['name'][$index]['Adjunto']);
            $attachmentPath = $resourceDir . $attachmentName;
            move_uploaded_file($_FILES['Nivel']['tmp_name'][$index]['Adjunto'], $attachmentPath);
        }
        $nivelData = [
            'ID_Curso' => $courseID,
            'Titulo' => $nivelData['Titulo'],
            'Costo_Nivel' => isset($nivelData['Costo_Nivel']) && $nivelData['Costo_Nivel'] !== '' && $nivelData['Gratuito'] == '0' ? $nivelData['Costo_Nivel'] : 0,
            'Video' => $videoPath,
            'Adjunto' => $attachmentPath
        ];


        if ($levelDb->createLevel($nivelData)) {
            $_SESSION['mensaje'] = ['text' => 'Curso creado exitosamente.', 'type' => 'success'];
        } else {
            $_SESSION['mensaje'] = ['text' => 'Error al crear el curso.', 'type' => 'error'];
        }
    }

}

if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/crearCurso.view.php";