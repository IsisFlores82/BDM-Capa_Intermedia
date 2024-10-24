<?php

class AdminAlumno{

    public function handle(){
        if(!isset($_SESSION['user'])){
            header("Location: /BDM-CI/signUp");
            exit;
        }
        if($_SESSION['user']['Rol']==='Instructor'){
            header("Location: /BDM-CI/reporteDeVentas");
            exit;
        }
    }
}