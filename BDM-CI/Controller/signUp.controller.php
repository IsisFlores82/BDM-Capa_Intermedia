<?php

require "Model/User.php";
$config = require 'config.php'; // Configuración de la base de datos

$db = new User($config['database']); // Crea la conexión a la base de datos

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['Email'];
    $password = $_POST['Password'];

    // Obtener usuario por email
    $user = $db->getUserByEmail($email);

    if ($user) {
        // Verificar la contraseña con password_verify
        if (password_verify($password, $user['Contraseña'])) {
            // Reiniciar el contador de intentos fallidos en caso de éxito
            $db->resetFailedAttempts($email);
            $_SESSION['user'] = $user;
            $_SESSION['mensaje'] = ['text' => 'Inicio de sesión exitoso', 'type' => 'success'];
        } else {
            // Incrementar los intentos fallidos
            $attempts = $db->incrementFailedAttempts($email);

            // Deshabilitar usuario si se han excedido los intentos
            if ($attempts >= 3) {
                $db->disableUser($email); // Llama al procedimiento almacenado
                $_SESSION['mensaje'] = ['text' => 'Cuenta deshabilitada', 'type' => 'error'];
            } else {
                $_SESSION['mensaje'] = ['text' => 'Contraseña incorrecta le quedan ' . (3 - $attempts) . ' intentos', 'type' => 'error'];
            }
        }
    } else {
        $_SESSION['mensaje'] = ['text' => 'Usuario no encontrado', 'type' => 'error'];
    }
}
require "Views/signUp.view.php";