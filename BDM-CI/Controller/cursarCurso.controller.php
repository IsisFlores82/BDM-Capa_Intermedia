<?php

require "Model/User.php";
require "Model/Course.php";
require "Model/Level.php";


$cursoId = $_GET['id'] ?? null;

if (!$cursoId) {
    $_SESSION['mensaje'] = [
        'type' => 'error',
        'text' => 'No se especificó un curso válido.'
    ];
    header('Location: /BDM-CI/misCursos');
    exit;
}
require "Views/cursarCurso.view.php";