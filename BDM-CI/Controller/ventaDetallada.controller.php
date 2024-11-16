<?php
require "Model/User.php";
require "Model/SalesReport.php";  // Include the SalesReport model
require "Model/Course.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$salesReportDb = new SalesReport($config['database']); // Create an instance of SalesReport
$courseDb = new Course($config['database']);
if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}
$courseId = $_GET['id_curso'] ?? null;



$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
if(!$courseDb->validateCourseOwnership($courseId, $id)){
    header("Location: /BDM-CI/reporteDeVentas");
    exit;
}
$start_date = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$end_date = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$estado_curso = isset($_GET['statusFilter']) && $_GET['statusFilter'] != 'todos' ? $_GET['statusFilter'] : null;
dd($estado_curso);
$alumnos = $salesReportDb->getDetailedSales($courseId, $start_date, $end_date, $estado_curso);
if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}

require "Views/ventaDetallada.view.php";