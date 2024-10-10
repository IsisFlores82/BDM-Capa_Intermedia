<?php
require __DIR__ . '/../Model/Conexion.php';   
$config = require 'config.php'; //extrae los datos de la bd de config.php

$db = new Conexion($config['database']); //crea la conexion 
$users = $db->getUsers(); //realiza el query


require "Views/logIn.view.php";