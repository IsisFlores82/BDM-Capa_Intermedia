<?php
require 'Guest.php';
require 'Alumno.php';

class Middleware{
    public const MAP= [
        'guest'=>Guest::class,
        'Alumno'=>Alumno::class
    ];

    public static function resolve($role){
        if(!$role){
            return;
        }
        $middleware = static::MAP[$role] ?? null;

        if(!$middleware){
            return;
        }
        (new $middleware())->handle();
    }
}