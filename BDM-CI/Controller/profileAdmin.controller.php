<?php
require "Model/User.php";
require "Model/Category.php";

$config = require 'config.php';
$userDb = new User($config['database']);
$categoryDb = new Category($config['database']);

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
$categories = $categoryDb->getCategories();
$blockedAccounts = $userDb->getBlockedAccounts();
if (isset($_GET['action']) && $_GET['action'] === 'enableAccount') {
    $userId = $_GET['userId'] ?? null;

    if ($userId) {
        // Llama al procedimiento almacenado para habilitar la cuenta
        $userDb->enableAccount($userId);
        echo json_encode(['status' => 'success', 'message' => 'Cuenta habilitada con éxito.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'ID de usuario no proporcionada.']);
    }
    exit;
}

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
    if (isset($_POST['_method']) && $_POST['_method'] === 'PATCH') {
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
    
    if (isset($_POST['action'])) {
        // Crear nueva categoría
        if ($_POST['action'] === 'createCategory') {
            $nameCreate = $_POST['categoryName'];
            $descriptionCreate = $_POST['categoryDescription'];

            if ($categoryDb->addCategory($nameCreate, $descriptionCreate, $id)) {
                $_SESSION['mensaje'] = ['text' => 'Categoría creada exitosamente.', 'type' => 'success'];
            } else {
                $_SESSION['mensaje'] = ['text' => 'Error al crear la categoría.', 'type' => 'error'];
            }
        }

        if (strpos($_POST['action'], 'updateCategory') === 0) {
            // Obtén el ID de la categoría a actualizar de la acción
            $categoryId = str_replace('updateCategory[', '', $_POST['action']);
            $categoryId = rtrim($categoryId, ']'); // Limpiar el ID

            // Obtiene el nombre y descripción usando el ID
            $categoryName = $_POST['categoryName'][$categoryId];
            $categoryDescription = $_POST['categoryDescription'][$categoryId];

            // Llama al método de actualización de la categoría
            if ($categoryDb->updateCategory($categoryId, $categoryName, $categoryDescription)) {
                $_SESSION['mensaje'] = ['text' => 'Categoría actualizada exitosamente.', 'type' => 'success'];
            } else {
                $_SESSION['mensaje'] = ['text' => 'Error al actualizar la categoría.', 'type' => 'error'];
            }
        }

        // Eliminar categoría específica
        if (strpos($_POST['action'], 'deleteCategory') === 0) {
            // Obtén el ID de la categoría a eliminar de la acción
            $categoryId = str_replace('deleteCategory[', '', $_POST['action']);
            $categoryId = rtrim($categoryId, ']'); // Limpiar el ID

            if ($categoryDb->deleteCategory($categoryId)) {
                $_SESSION['mensaje'] = ['text' => 'Categoría eliminada exitosamente.', 'type' => 'success'];
            } else {
                $_SESSION['mensaje'] = ['text' => 'Error al eliminar la categoría.', 'type' => 'error'];
            }
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

require "Views/profileAdmin.view.php";