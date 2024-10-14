<?php

class Conexion{
    private $con;
    //crea la conexion en el constructor, pasandole de parametros, todos los datos
    // de la conexion que se dinieron en config.php
    public function __construct($config){
        //crea el dsn con los datos, y el ";" que es el separador que pondra por cada parametro
        $dsn = 'mysql:' . http_build_query($config,"",";");

        $this->con = new PDO($dsn,$config['user'],$config['password']);
        $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function getCon(){
        return $this->con;
    }

}

?>