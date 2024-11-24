<?php
require "Model/User.php";
require "Model/Chat.php"; // Asegúrate de tener un modelo Mensajes configurado
$config = require 'config.php';
header('Content-Type: application/json');

$chatDb = new Chat($config['database']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $sender = $_POST['sender'];
    $receiver = $_POST['receiver'];
    $message = $_POST['message'];


    $chatDb->sendMessage($sender, $receiver, $message);
}