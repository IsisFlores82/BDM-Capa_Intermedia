<?php
require "Model/User.php";
require "Model/Cart.php";
$config = require 'config.php';
$cartDb = new Cart($config['database']);


// Validar que se recibió un ID y un Tipo
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['ID'] ?? null;
    $tipo = $_POST['Tipo'] ?? null;

    if (!$id || !$tipo) {
        $_SESSION['mensaje'] = ['text' => 'Datos incorrectos', 'type' => 'error'];
        return;
    }

    // Seleccionar la tabla correcta según el tipo
    $resultado = false;
    if ($tipo === 'curso') {
        $resultado = $cartDb->updateStatusByCourseId($id, 0);
    } elseif ($tipo === 'nivel') {
        $resultado = $cartDb->updateStatusByLevelId($id, 0);
    }

    if ($resultado) {
        $_SESSION['mensaje'] = ['text' => 'Item eliminado correctamente', 'type' => 'success'];
    } else {
        $_SESSION['mensaje'] = ['text' => 'Error al eliminar el item', 'type' => 'error'];
    }
    header('Location: /BDM-CI/carrito');
}