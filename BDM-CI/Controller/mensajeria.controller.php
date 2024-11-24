<?php
require "Model/User.php";
require "Model/Chat.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$chatDb = new Chat($config['database']);
if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}
$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
$userType=$user['Rol'];
if($userType==='Alumno'){
    $chatUsers=$userDb->getChatableUsers('Instructor');
}else{
    $chatUsers=$userDb->getChatableUsers('Alumno');
}
if (isset($_GET['receiver_id']) && !empty($_GET['receiver_id'])) {
$id_receptor = $_GET['receiver_id']?? null;
$receiverUser=$userDb->getUserById($id_receptor);
}

// Obtener mensajes entre el usuario actual y el receptor
if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}


// Convertir la imagen del usuario a base64
if (!empty($receiverUser['Foto'])) {
    $finfoR = new finfo(FILEINFO_MIME_TYPE);
    $mimeTypeR = $finfoR->buffer($receiverUser['Foto']);
    $fotoBase64R = base64_encode($receiverUser['Foto']);
    $fotoSrcR = "data:" . $mimeTypeR . ";base64," . $fotoBase64R;
} else {
    // Imagen por defecto si no tiene foto
    $fotoSrcR = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}


require "Views/mensajeria.view.php";