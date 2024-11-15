<?php

require "Model/User.php";
require "Model/Course.php";
require "Model/Level.php";
require "Model/Inscription.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$courseDb = new Course($config['database']);
$levelDb = new Level($config['database']);
$inscriptionDb = new Inscription($config['database']);

if (!isset($_SESSION['user'])) {
    header("Location: /BDM-CI/logIn");
    exit;
}

$id = $_SESSION['user']['ID_Usuario'];
$user = $userDb->getUserById($id);
$cursoId = $_GET['id'] ?? null;

if (!$cursoId) {
    $_SESSION['mensaje'] = [
        'type' => 'error',
        'text' => 'No se especificó un curso válido.'
    ];
    header('Location: /BDM-CI/profile');
    exit;
}
$cursoComprado = $inscriptionDb->isCoursePurchased($id, $cursoId);
if ($cursoComprado) {
    // Actualiza la fecha de último ingreso solo si el curso está en inscripciones
    $inscriptionDb->updateLastAccess($id, $cursoId);
}
$infoCurso=$courseDb->getCoursesWithInstructorsFromViewById($cursoId);
// Obtén todos los niveles del curso.
$nivelesCurso = $levelDb->getLevelsByCourse($cursoId);
// Obtén los niveles que el usuario ha comprado (si no compró el curso completo).
$nivelesComprados = $cursoComprado 
    ? array_column($nivelesCurso, 'ID_Nivel') // Si compró el curso, tiene acceso a todos los niveles.
    : $inscriptionDb->getPurchasedLevels($id, $cursoId);

$inscriptionDb->llenarProgresoNiveles($id);
$result = $inscriptionDb->getProgreso($id, $cursoId);
$progreso = $result['PorcentajeProgreso'] ?? 0;
    if (!empty($user['Foto'])) {
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->buffer($user['Foto']);
        $fotoBase64 = base64_encode($user['Foto']);
        $fotoSrc = "data:" . $mimeType . ";base64," . $fotoBase64;
    } else {
        $fotoSrc = "https://miro.medium.com/v2/resize:fit:698/1*0jjdu52m0MO4SjLWiCVOlg.jpeg";
    }
require "Views/cursarCurso.view.php";