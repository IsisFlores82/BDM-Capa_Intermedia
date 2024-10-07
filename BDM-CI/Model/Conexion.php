<?php

class Conexion{
    private $con;

    public function __construc(){
        $this->con = new mysqli('localhost','root','','BDMCAPA');
    }

    public function getUsers(){
        $query= $this->con->query('SELECT * FROM Usuario');

        $return=[];
        $i=0;
        while($fila=$query->fetch_assoc()){
            $return[$i]=$fila;
            $i++;
        }

        return $return;
    }
}

?>