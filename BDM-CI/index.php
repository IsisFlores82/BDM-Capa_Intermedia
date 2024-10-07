<?php

require 'functions.php';

$uri=parse_url($_SERVER['REQUEST_URI'])['path'];
dd($uri);
$basePath = '/BDM-CI';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}
$routes = [
    '/' => 'Controller/logIn.controller.php',
    '/signUp' => 'Controller/signUp.controller.php',
    '/logIn' => 'Controller/logIn.controller.php',
    '/dashboard' => 'Controller/dashboard.controller.php',
];

if(array_key_exists($uri,$routes)){
    require $routes[$uri];
}else{
    http_response_code(404);
    echo "valio madres jeje 404";
    die();
}