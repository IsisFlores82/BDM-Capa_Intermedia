<?php

require "Model/User.php";
require "Model/Course.php";
require "Model/Inscription.php";
require_once("./dompdf/autoload.inc.php");

use Dompdf\Dompdf;

$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$inscriptionDb = new Inscription($config['database']);

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$idUsuario = $_SESSION['user']['ID_Usuario'];
$cursoId = $_GET['id_curso'] ?? null;

if (!$cursoId) {
    $_SESSION['mensaje'] = [
        'type' => 'error',
        'text' => 'No se especificó un curso válido.'
    ];
    header('Location: /BDM-CI/profile');
    exit;
}


// Crear carpeta para certificados
$basePath = "Certificates";
if (!is_dir($basePath)) {
    mkdir($basePath, 0755, true);
}

$userFolder = $basePath . "/" . $idUsuario;
if (!is_dir($userFolder)) {
    mkdir($userFolder, 0755, true);
}

// Obtener datos del usuario y curso
$usuario = $userDb->getUserById($idUsuario);
$curso = $courseDb->getCoursesWithInstructorsFromViewById($cursoId);
$imagePath = "Logo.png"; // Ruta de tu logo
if (file_exists($imagePath)) {
    $imageData = base64_encode(file_get_contents($imagePath));
    $imageMime = mime_content_type($imagePath);
    $base64Image = "data:{$imageMime};base64,{$imageData}";
} else {
    $base64Image = ""; // En caso de que no se encuentre la imagen
}
// Crear contenido del PDF
$html = '
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            border: 4px solid #000066;
            padding: 40px;
            position: relative;
            height: 90vh;
        }
        .certificate-container {
            text-align: center;
            position: relative;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .corner-decoration {
            position: absolute;
            width: 50px;
            height: 50px;
            border: 4px solid #000066;
        }
        .top-left { top: -4px; left: -4px; border-right: none; border-bottom: none; }
        .top-right { top: -4px; right: -4px; border-left: none; border-bottom: none; }
        .bottom-left { bottom: -4px; left: -4px; border-right: none; border-top: none; }
        .bottom-right { bottom: -4px; right: -4px; border-left: none; border-top: none; }
        .logo-container {
            display: flex;
            justify-content: center;
            margin-bottom: 50px;
        }
        .miku-logo {
            width: 200px; /* Logo más grande */
            height: auto;
            margin-top: 20px;
        }
        .student-name {
            font-size: 42px; /* Nombre más grande */
            font-weight: bold;
            margin: 40px 0;
            color: #000066;
        }
        .completion-text {
            font-size: 28px; /* Texto más grande */
            margin: 20px 0;
            color: #444;
        }
        .course-name {
            font-size: 48px; /* Nombre del curso más grande */
            color: navy;
            font-weight: bold;
            margin: 30px 0;
        }
        .description {
            font-size: 24px; /* Descripción más grande */
            margin: 30px 0;
            color: #333;
            line-height: 1.4;
        }
        .date {
            font-size: 24px; /* Fecha más grande */
            margin-top: 50px;
            color: #444;
        }
        @page {
            margin: 0;
            size: landscape;
        }
    </style>
</head>
<body>
    <div class="corner-decoration top-left"></div>
    <div class="corner-decoration top-right"></div>
    <div class="corner-decoration bottom-left"></div>
    <div class="corner-decoration bottom-right"></div>
    
    <div class="certificate-container">
        <div class="logo-container">
            <img src="' . $base64Image . '" class="miku-logo">
        </div>
        
        <div class="student-name">' . $usuario['Nombre'] . ' ' . $usuario['Apellidos'] . '</div>
        
        <div class="completion-text">Finalizó exitosamente el curso</div>
        
        <div class="course-name">' . $curso['Course_Title'] . '</div>
        
        <div class="description">
            Un curso en línea impartido a través de Miku academia y autorizado por<br>
            ' . $curso['Instructor_Nombre'] . ' ' . $curso['Instructor_Apellidos'] . '
        </div>
        
        <div class="date">' . date("M d, Y") . '</div>
    </div>
</body>
</html>
';
// Generar el PDF
// Configuración adicional para DOMPDF para asegurar que la imagen se cargue
$dompdf = new Dompdf(["isRemoteEnabled" => true, "isHtml5ParserEnabled" => true,"chroot"=>__DIR__]);
$dompdf->loadHtml($html);
$dompdf->setPaper("A4", "landscape");
$dompdf->render();

$fileName = "Certificado_{$idUsuario}_{$cursoId}.pdf";
$filePath = $userFolder . "/" . $fileName;

// Guardar el archivo en el servidor
$output = $dompdf->output();
file_put_contents($filePath, $output);

// Actualizar la base de datos
$inscriptionDb->updateCertificadoPath($idUsuario, $cursoId, $filePath);

// Redirigir con éxito
$_SESSION['mensaje'] = [
    'type' => 'success',
    'text' => 'Certificado generado exitosamente.'
];
header("Location: /BDM-CI/profile");
exit;
