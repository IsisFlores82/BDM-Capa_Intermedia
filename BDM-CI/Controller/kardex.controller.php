<?php
require "Model/User.php";
require "Model/Kardex.php";
require "Model/Category.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$kardexDb = new Kardex($config['database']);
$categoryDb = new Category($config['database']);

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}
$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
$categories = $categoryDb->getCategories();
$filtroFechaInicio = $_GET['startDate'] ?? null;
$filtroFechaFin = $_GET['endDate'] ?? null;
$filtroCategoria = $_GET['categoryFilter'] ?? '';
$filtroEstado = $_GET['statusFilter'] ?? 'todos';

// Obtén los cursos del Kardex
$kardexCursos = $kardexDb->getCursosKardex($id, $filtroFechaInicio, $filtroFechaFin, $filtroCategoria, $filtroEstado);

if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/kardex.view.php";