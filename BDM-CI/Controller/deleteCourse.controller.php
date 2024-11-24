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

$userId = $_SESSION['user']['ID_Usuario'];

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['ID_Curso'];
    $instructorId = $userId;

    if ($courseDb->deleteCourse($id, $instructorId)) {
        $_SESSION['mensaje'] = ['text' => 'Curso eliminado exitosamente.', 'type' => 'success'];
    } else {
        $_SESSION['mensaje'] = ['text' => 'Error al eliminar el curso.', 'type' => 'error'];
    }
}

header("Location: /BDM-CI/profileInstructor");
exit;
