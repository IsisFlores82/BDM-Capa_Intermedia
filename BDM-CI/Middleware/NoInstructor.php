<?php

class NoInstructor{

    public function handle(){
        if(isset($_SESSION['user'])){
            if($_SESSION['user']['Rol']==='Instructor'){
                header("Location: /BDM-CI/reporteDeVentas");
                exit;
            }
        }

    }
}