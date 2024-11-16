<?php
require "Model/User.php";
require "Model/Category.php";
require "Model/SalesReport.php";  // Include the SalesReport model

$config = require 'config.php';
$userDb = new User($config['database']);
$categoryDb = new Category($config['database']);
$salesReportDb = new SalesReport($config['database']); // Create an instance of SalesReport

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
$categories = $categoryDb->getCategories();
// Get the sales data for the instructor (filter parameters can be passed if needed)
$start_date = isset($_GET['startDate']) ? $_GET['startDate'] : null;
$end_date = isset($_GET['endDate']) ? $_GET['endDate'] : null;
$category_id = isset($_GET['categoryFilter']) ? $_GET['categoryFilter'] : null;
$estado_curso = isset($_GET['statusFilter']) && $_GET['statusFilter'] != 'todos' ? $_GET['statusFilter'] : null;
$coursesSummary = $salesReportDb->getCoursesSummary($id, $start_date, $end_date, $category_id, $estado_curso);
$salesSummary = $salesReportDb->getInstructorSalesSummary($id);


if (!empty($user['Foto'])) {
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mimeType = $finfo->buffer($user['Foto']);
    $fotoBase64 = base64_encode($user['Foto']);
    $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
} else {
    $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
}
require "Views/reporteDeVentas.view.php"; // Pass the data to the view
?>
