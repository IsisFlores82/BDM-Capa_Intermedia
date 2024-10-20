<?php

class Guest{

    public function handle(){
        if(isset($_SESSION['user'])){
            header("Location: /BDM-CI/");
            exit;
        }
    }
}