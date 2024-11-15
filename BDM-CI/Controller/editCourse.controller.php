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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
    // Recibir datos del curso
    $courseId = $_POST['ID_Curso'];
    $title = $_POST['Titulo'];
    $description = $_POST['Descripcion'];
    $categoryId = $_POST['ID_Categoria'];
    $isFree = $_POST['Gratuito'];
    $price = isset($_POST['Costo_Total']) && $_POST['Costo_Total'] !== '' && $isFree == '0' ? $_POST['Costo_Total'] : 0;
    // Procesar imagen de banner del curso
    $imageData = null;
    if (!empty($_FILES['Imagen']['tmp_name'])) {
        $imageData = file_get_contents($_FILES['Imagen']['tmp_name']);
    }

    // Actualizar el curso usando un stored procedure
    $courseDb->updateCourse($courseId, $title, $description, $categoryId, $price, $isFree, $imageData);

    // Estructura de directorios
    $resourceDir = "Resourcer_Courses/$id/";
    if (!file_exists($resourceDir)) {
        mkdir($resourceDir, 0777, true);
    }

    // Procesar niveles
    $levelsToUpdate = $_POST['Nivel'] ?? [];
    $levelsToDelete = $_POST['NivelEliminar'] ?? [];

    foreach ($levelsToUpdate as $index => $levelData) {
        $levelId = $levelData['ID_Nivel'] ?? null;
        $levelTitle = $levelData['Titulo'];
        $isLevelFree = $levelData['Gratuito'];
        $levelPrice = isset($levelData['Costo_Nivel']) && $levelData['Costo_Nivel'] !== '' && $isLevelFree == '0' ? $levelData['Costo_Nivel'] : 0;
        // Manejo de archivos de video y adjunto
        $videoPath = null;
        $attachmentPath = null;
        // Procesar video
        if (!empty($_FILES['Nivel']['tmp_name'][$index]['Video'])) {
            $videoName = basename($_FILES['Nivel']['name'][$index]['Video']);
            $videoPath = $resourceDir . $videoName;
            move_uploaded_file($_FILES['Nivel']['tmp_name'][$index]['Video'], $videoPath);
        }

        // Procesar archivo adjunto
        if (!empty($_FILES['Nivel']['tmp_name'][$index]['Adjunto'])) {
            $attachmentName = basename($_FILES['Nivel']['name'][$index]['Adjunto']);
            $attachmentPath = $resourceDir . $attachmentName;
            move_uploaded_file($_FILES['Nivel']['tmp_name'][$index]['Adjunto'], $attachmentPath);
        }

        if ($levelId) {
            // Nivel existente, actualizar
            $levelDb->updateLevel($levelId, $courseId, $levelTitle, $levelPrice, $attachmentPath, $videoPath);
        } else {
            $data = [
                'ID_Curso' => $courseId,
                'Titulo' => $levelTitle,
                'Costo_Nivel' => $levelPrice,  
                'Adjunto' => $attachmentPath,                           // Ruta del archivo adjunto
                'Video' => $videoPath                                   // Ruta del archivo de video
            ];
            
            // Llamada a createLevel pasando el arreglo $data
            $levelDb->createLevel($data);
        }
    }
    // Marcar niveles eliminados como inactivos
    foreach ($levelsToDelete as $levelId) {
        $levelDb->deactivateLevel($levelId);
    }

    $_SESSION['mensaje'] = ['text' => 'Curso actualizado exitosamente.', 'type' => 'success'];
    header("Location: /BDM-CI/profileInstructor");
    exit;
    } catch (Exception $e) {
        $_SESSION['mensaje'] = ['text' => $e->getMessage(), 'type' => 'error'];
        header("Location: /BDM-CI/profileInstructor");
        exit;
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
require "Views/editCourse.view.php";