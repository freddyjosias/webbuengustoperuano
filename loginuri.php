<?php

    require 'conexion.php';
    require 'glogin/vendor/autoload.php';

    $client = new Google_Client();
    
    $client -> setClientId('252426069950-jp72flosvijj2su36e58bail2qmmk8nu.apps.googleusercontent.com');
    $client -> setClientSecret('KcUczw-8uH_WVSgm8-qUE2bp');
    $client -> setRedirectUri('http://localhost/webbuengustoperuano/loginuri.php');
    $client -> addScope('email');
    $client -> addScope('profile');

    if (isset($_GET['code'])) 
    {
        $token =  $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (!isset($token['error'])) {

            $client -> setAccessToken($token['access_token']);
            $google_oauth = new Google_Service_Oauth2($client);
            $google_account_info = $google_oauth -> userinfo -> get();
            var_dump($google_account_info); die;

        }

    } 
    else 
    {
        
        ?>
                <a href="<?php echo $client -> createAuthUrl() ?>" class="btn btn-primary fw-600 mx-5r w-10r">Google</a>
            

        <?php

    }

?>