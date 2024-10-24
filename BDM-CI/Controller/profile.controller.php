<?php

require "Model/User.php";
$config = require 'config.php';

$userDb = new User($config['database']);

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);

function handleImageUpload($file, $maxFileSize = 5242880) { // 5MB default
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return ['error' => 'Error en la carga del archivo: ' . $file['error']];
    }

    if ($file['size'] > $maxFileSize) {
        return ['error' => 'El archivo es demasiado grande. El tamaño máximo es ' . ($maxFileSize / 1048576) . 'MB.'];
    }

    $allowedTypes = ['image/jpeg', 'image/png'];
    $fileInfo = finfo_open(FILEINFO_MIME_TYPE);
    $detectedType = finfo_file($fileInfo, $file['tmp_name']);
    finfo_close($fileInfo);

    if (!in_array($detectedType, $allowedTypes)) {
        return ['error' => 'Tipo de archivo no permitido. Solo se permiten JPEG y PNG.'];
    }

    $image = imagecreatefromstring(file_get_contents($file['tmp_name']));
    $width = imagesx($image);
    $height = imagesy($image);

    $maxWidth = 1000;
    $maxHeight = 1000;

    if ($width > $maxWidth || $height > $maxHeight) {
        $ratio = min($maxWidth / $width, $maxHeight / $height);
        $newWidth = $width * $ratio;
        $newHeight = $height * $ratio;

        $newImage = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresampled($newImage, $image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

        ob_start();
        imagejpeg($newImage, null, 90);
        $imageData = ob_get_clean();
    } else {
        $imageData = file_get_contents($file['tmp_name']);
    }

    return ['success' => true, 'data' => $imageData];
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['firstName'];
    $apellido = $_POST['lastName'];
    $genero = $_POST['gender'];
    $fechaNacimiento = $_POST['birthdate'];
    $password = !empty($_POST['password']) ? $_POST['password'] : null;

    $foto = null;
    if (isset($_FILES['foto']) && $_FILES['foto']['error'] == UPLOAD_ERR_OK) {
        $result = handleImageUpload($_FILES['foto']);
        if (isset($result['error'])) {
            $_SESSION['mensaje'] = ['text' => $result['error'], 'type' => 'error'];
        } else {
            
            $foto = $result['data'];
        }
    }
    if (!isset($_SESSION['mensaje'])) {
        $resultado = $userDb->updateUser($id, $nombre, $apellido, $genero, $fechaNacimiento, $foto, $password);

        if ($resultado['status'] == 'success') {
            $_SESSION['mensaje'] = ['text' => $resultado['message'], 'type' => 'success'];
            $user = $userDb->getUserById($id);
            $_SESSION['user'] = $user;
        } else {
            $_SESSION['mensaje'] = ['text' => $resultado['message'], 'type' => 'error'];
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

require "Views/profile.view.php";