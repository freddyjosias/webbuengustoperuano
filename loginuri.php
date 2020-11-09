<?php

    require 'conexion.php';
    require 'glogin/vendor/autoload.php';

    $client = new Google_Client();
    
    $client -> setClientId();
    $client -> setClientSecret();
    $client -> setRedirectUrl();
    $client -> addScope('email');
    $client -> addScope('profile');

?>