<?php
session_start();

require 'functions.php';
require 'Model/Router.php';
$router = new Router();

$routes = require 'routes.php';

$uri=parse_url($_SERVER['REQUEST_URI'])['path'];
dd($uri);

$method=$_POST['_method']??$_SERVER['REQUEST_METHOD'];
dd($method);
$router->route($uri,$method);