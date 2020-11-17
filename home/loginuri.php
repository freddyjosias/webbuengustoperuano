<?php

    if (file_exists('../conexion.php')) 
    {
        require_once '../conexion.php';

        session_start();

        if (isset($_SESSION['enableaccount'][0])) 
        {
            $_SESSION['enableaccount'][1]++;

            if ($_SESSION['enableaccount'][1] == 2 && isset($_GET['enable'])) 
            {
                $enableAccount = $conexion -> prepare('UPDATE usuario SET estado = 1 WHERE idusuario = ?');
                $enableAccount -> execute(array($_SESSION['enableaccount'][0]));
                
                $loginUser = $conexion -> prepare('SELECT nombreusuario, apellidousuario, photo FROM usuario WHERE idusuario = ?');
                $loginUser -> execute(array($_SESSION['enableaccount'][0]));
                $loginUser = $loginUser -> fetch(PDO::FETCH_ASSOC);

                $_SESSION['idusuario'] = $_SESSION['enableaccount'][0];
                $_SESSION['nombreusuario'] = $loginUser['nombreusuario'];
                $_SESSION['apellidousuario'] = $loginUser['apellidousuario'];
                $_SESSION['photo'] = $loginUser['photo'];

                unset($_SESSION['enableaccount']);
                header("Location: ../");
            }

            if ($_SESSION['enableaccount'][1] > 1) 
            {
                unset($_SESSION['enableaccount']);
            }
        }

    }
    
    if (isset($_POST['useremail'])) {

        if (strlen($_POST['useremail']) > 0 && strlen($_POST['userpassword']) > 0) {

            $mail = $_POST['useremail'];
            $password = $_POST['userpassword'];

            $resultUser = $conexion -> prepare('SELECT idusuario, nombreusuario, apellidousuario, photo, estado, contrasena FROM usuario WHERE emailusuario = ?');
            $resultUser -> execute(array($mail));
            $resultUser = $resultUser -> fetch(PDO::FETCH_ASSOC);

            if ($resultUser) 
            {
                if ($resultUser['estado'] == 1) 
                {
                    if (strlen($resultUser['contrasena']) > 1) 
                    {
                        if ($password == $resultUser['contrasena']) 
                        {
                            $_SESSION['idusuario'] = $resultUser['idusuario'];
                            $_SESSION['nombreusuario'] = $resultUser['nombreusuario'];
                            $_SESSION['apellidousuario'] = $resultUser['apellidousuario'];
                            $_SESSION['photo'] = $resultUser['photo'];
                            header("Location: ../");
                        }
                        else
                        {
                            $_SESSION['errorlogin'] = 1060;
                        }
                        
                    } 
                    else
                    {
                        $_SESSION['errorlogin'] = 1048;
                    }
                    
                }
                else
                {
                    $_SESSION['errorlogin'] = 1036;
                }
            } 
            else 
            {
                $_SESSION['errorlogin'] = 1024;
            }
        }
    }
    
    if ($_SERVER['PHP_SELF'] == '/webbuengustoperuano/home/loginuri.php')
    {
        header('Location: ../');
    } 

    if (file_exists('glogin/vendor/autoload.php')) 
    {
        require_once 'glogin/vendor/autoload.php';
    } 
    elseif (file_exists('../glogin/vendor/autoload.php')) 
    {
        require_once '../glogin/vendor/autoload.php';
    }

    $client = new Google_Client();
    
    $client -> setClientId('252426069950-jp72flosvijj2su36e58bail2qmmk8nu.apps.googleusercontent.com');
    $client -> setClientSecret('KcUczw-8uH_WVSgm8-qUE2bp');
    $client -> setRedirectUri('http://localhost/webbuengustoperuano/home/loginuri.php');
    $client -> addScope('email');
    $client -> addScope('profile');

    if (isset($_GET['code'])) 
    {
        $token =  $client->fetchAccessTokenWithAuthCode($_GET['code']);
        
        if (!isset($token['error'])) {

            $client -> setAccessToken($token['access_token']);
            $authorization = new Google_Service_Oauth2($client);
            $account = $authorization -> userinfo -> get();
            
            $gMail = $account -> email;
            $gId = $account -> id;
            

            $existUser = $conexion -> prepare('SELECT estado, nombreusuario, apellidousuario, photo FROM usuario WHERE idusuario = ? AND emailusuario = ?');
            $existUser -> execute(array($gId, $gMail));
            $existUser = $existUser -> fetch(PDO::FETCH_ASSOC);
            
            if ($existUser) 
            {
                if ($existUser['estado'] == 1) 
                {
                    $_SESSION['idusuario'] = $gId;
                    $_SESSION['nombreusuario'] = $existUser['nombreusuario'];
                    $_SESSION['apellidousuario'] = $existUser['apellidousuario'];
                    $_SESSION['photo'] = $existUser['photo'];
                    header("Location: ../");
                }
                else
                {
                    $_SESSION['enableaccount'] = array($gId, 0);
                    header("Location: ../");
                }
            } 
            else 
            {
                $gName = $account -> givenName;
                $gLastName = $account -> familyName;
                $gPhoto = $account -> picture;

                $newUser = $conexion -> prepare("INSERT INTO usuario(idusuario, emailusuario, nombreusuario, apellidousuario, photo) VALUES(?, ?, ?, ?, ?)");
                $newUser = $newUser -> execute(array($gId, $gMail, $gName, $gLastName, $gPhoto));
                
                if($newUser)
                {
                    $_SESSION['idusuario'] = $gId;
                    $_SESSION['nombreusuario'] = $gName;
                    $_SESSION['apellidousuario'] = $gLastName;
                    $_SESSION['photo'] = $gPhoto;
                    $_SESSION['newuser'] = true;
                    header("Location: ../");
                }
                else
                {
                    echo "Algo ha salido mal";
                }
            }

        }
        else
        {
            echo 'Algo ha salido mal';
        }

    } 
    else if($_SERVER['REQUEST_URI'] == "/webbuengustoperuano/" || $_SERVER['REQUEST_URI'] == "/webbuengustoperuano/index.php" )
    {
        
        ?>
            <a href="<?php echo $client -> createAuthUrl() ?>" class="btn shadow btn-red text-white mt-2 fw-600 "><i class="fab fa-google"></i> &nbsp; Inicia sesión con Google</a>

        <?php

    }

?>