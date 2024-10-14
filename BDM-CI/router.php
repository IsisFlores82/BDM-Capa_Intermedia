<?php

$routes = require 'routes.php';

$uri=parse_url($_SERVER['REQUEST_URI'])['path'];
dd($uri);
$basePath = '/BDM-CI';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

function routeToController($uri,$routes){
    if(array_key_exists($uri,$routes)){
        require $routes[$uri];
    }else{
        abort();
    }
}

function abort($code=404){
    http_response_code($code);
    echo "valio madres jeje 404";
    die();
}

routeToController($uri,$routes);