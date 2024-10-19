<?php
require "Model/User.php";
$config = require 'config.php'; //extrae los datos de la bd de config.php

$userDb = new User($config['database']); //crea la conexion 
$users = $userDb->getUsers(); //realiza el query

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nombre = $_POST['Nombre'];
    $apellido = $_POST['Apellido'];
    $genero = $_POST['Genero'];
    $rol = $_POST['Rol'];
    $fechaNacimiento = $_POST['FechaDeNacimiento'];
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Obtener la foto desde el formulario
    $profilePhotoInput = $_FILES['Foto'];
    $foto = file_get_contents($profilePhotoInput['tmp_name']); // Lee el archivo de imagen

    // Llama a la función para registrar el usuario
    $mensaje = $userDb->registerUser($email, $nombre, $apellido, $genero, $fechaNacimiento, $rol, $foto, $password);
    echo $mensaje;
    // Manejar el mensaje de registro
    if ($mensaje == 'Usuario registrado exitosamente') {
        $_SESSION['mensaje'] = ['text' => $mensaje, 'type' => 'success'];
    } elseif ($mensaje == 'El correo ya está registrado') {
        $_SESSION['mensaje'] = ['text' => $mensaje, 'type' => 'error'];
    } else {
        $_SESSION['mensaje'] = ['text' => 'Error al registrar el usuario: ' . $mensaje, 'type' => 'error'];
    }
}


require "Views/logIn.view.php";


