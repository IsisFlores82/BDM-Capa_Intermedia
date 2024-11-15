<?php

require "Model/User.php";
require "Model/Inscription.php";
$config = require 'config.php';
$userDb = new User($config['database']);
$inscriptionDb = new Inscription($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validar que los datos necesarios estén presentes
    $idUsuario = $_POST['ID_Usuario'] ?? null;
    $idNivel = $_POST['ID_Nivel'] ?? null;
    $idCurso = $_POST['ID_Curso'] ?? null;

    if ($idUsuario && $idNivel) {
        // Actualizar el progreso en la base de datos
        try{
            $resultado = $inscriptionDb->actualizarProgresoNivel($idUsuario, $idNivel);

            if ($resultado) {
                // Verificar si todos los niveles del curso están completados
                if ($idCurso) {
                    $inscriptionDb->actualizarProgresoCurso($idUsuario, $idCurso);
                }
                $_SESSION['mensaje'] = [
                    'type' => 'success',
                    'text' => 'Progreso actualizado correctamente.'
                ];
                header('Location: /BDM-CI/cursarCurso?id='.$idCurso);
                exit;
            } else {
                $_SESSION['mensaje'] = [
                    'type' => 'error',
                    'text' => 'Ocurrio un error al actualizar el progreso.'
                ];
                header('Location: /BDM-CI/cursarCurso?id='.$idCurso);
                exit;
            }
        }catch(PDOException $e){
            $_SESSION['mensaje'] = [
                'type' => 'error',
                'text' => 'Ocurrió un error al actualizar el progreso.'
            ];
            header('Location: /BDM-CI/cursarCurso?id='.$idCurso);
            exit;
        }
    
    }
}