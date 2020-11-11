<?php 

    session_start();

    require 'conexion.php';

    if (isset($_SESSION['idusuario'])) 
    {
        require 'home/home.php';
    }
    else 
    {
        require 'home/login.php';
    }

 ?>