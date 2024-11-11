<?php
require 'Guest.php';
require 'Alumno.php';
require 'Admin.php';
require 'AdminAlumno.php';
require 'NoInstructor.php';

class Middleware{
    public const MAP= [
        'guest'=>Guest::class,
        'Alumno'=>Alumno::class,
        'Admin'=>Admin::class,
        'AdminAlumno'=>AdminAlumno::class,
        'NoInstructor'=>NoInstructor::class
    ];

    public static function resolve($role){

        if(!$role){ 
            $role = 'guest';
        }
        $middleware = static::MAP[$role] ?? null;

        if(!$middleware){
            return;
        }
        (new $middleware())->handle();
    }
}