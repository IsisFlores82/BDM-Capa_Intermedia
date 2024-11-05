<?php

require "Model/User.php";
$config = require 'config.php';
$userDb = new User($config['database']);

// Verificar si el ID de usuario está presente en la URL
if (isset($_GET['id'])) {
    $userID = intval($_GET['id']);
    
    // Llamar al método para habilitar la cuenta
    if ($userDb->enableAccount($userID)) {
        $_SESSION['mensaje'] = ['text' => 'Cuenta rehabilitada exitosamente.', 'type' => 'success'];
    } else {
        $_SESSION['mensaje'] = ['text' => 'Error al rehabilitar la cuenta.', 'type' => 'error'];
    }
} else {
    $_SESSION['mensaje'] = ['text' => 'ID de usuario no proporcionado.', 'type' => 'error'];
}

// Redirigir de vuelta a la página anterior
header("Location: /BDM-CI/profileAdmin");
exit;
?>