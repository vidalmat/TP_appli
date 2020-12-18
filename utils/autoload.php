<?php

// Ajout du code spl_autoload_register pour un autoload qui permet d'éviter les require 

spl_autoload_register(function ($class){

    if(file_exists("$class.php")) {

        require_once "$class.php";

    }

});



?>
