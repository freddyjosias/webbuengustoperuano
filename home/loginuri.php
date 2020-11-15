<?php

    if (file_exists('../conexion.php')) {
        require_once '../conexion.php';
    }

    if (isset($_POST['useremail'])) {

        if (strlen($_POST['useremail']) > 0 && strlen($_POST['userpassword']) > 0) {

            session_start();

            $mail = $_POST['useremail'];
            $password = $_POST['userpassword'];

            $resultUser = $conexion -> prepare('SELECT idusuario, nombreusuario, apellidousuario, idprofile FROM access INNER JOIN usuario ON usuario.i WHERE estado = 1 AND emailusuario = ? AND contrasena = ?');
            //$resultUser =

            $resultados = $conexion -> prepare($consultaUsuario);

            $consultaUsuario = 'SELECT * FROM usuario WHERE estado = 1 OR estado = 2';
            $datosErroneos = 1;
            $resultados = $conexion -> prepare($consultaUsuario);
            $resultados -> execute();
            $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

            foreach($resultados as $row) { 
                if ($row['emailusuario'] == $usuario && $row['contrasena'] == $clave) {
                    $datosErroneos = 0;
                    $_SESSION['idusuario'] = $row['idusuario'];
                    $_SESSION['email'] = $row['emailusuario'];
                    $_SESSION['nombreusuario'] = $row['nombreusuario'];
                    $_SESSION['apellidousuario'] = $row['apellidousuario'];
                    $_SESSION['profile'] = $row['id_profile']; 
                    if ($row['id_profile'] == 2) {

                        $resultadosR = $conexion -> prepare('SELECT idsucursal FROM access WHERE idusuario = ?');
                        $resultadosR -> execute(array($row['idusuario']));
                        $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);
                        $_SESSION['sucursal'] = $resultadosR[0]['idsucursal'];

                        header('Location: ../nosotros.php?view=' . $resultadosR[0]['idsucursal']);
                        die;

                    }
                    
                    break;
                }
            }
            
            if ($datosErroneos) {
                $_SESSION['invaliduser'] = true;
            }

            header('Location: ../');
            die;

        }
    }

    if ($_SERVER['REQUEST_URI'] == '/webbuengustoperuano/home/loginuri.php')
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

        session_start();
        
        if (!isset($token['error'])) {

            $client -> setAccessToken($token['access_token']);
            $authorization = new Google_Service_Oauth2($client);
            $account = $authorization -> userinfo -> get();
            
            $gMail = $account -> email;
            $gName = $account -> givenName;
            $gLastName = $account -> familyName;
            $gId = $account -> id;
            $gPhoto = $account -> picture;

            $existUser = $conexion -> prepare('SELECT estado FROM usuario WHERE idusuario = ? AND emailusuario = ?');
            $existUser -> execute(array($gId, $gMail));
            $existUser = $existUser -> fetch(PDO::FETCH_ASSOC);
            
            if ($existUser) 
            {
                if ($existUser['estado'] == 1) 
                {
                    $_SESSION['idusuario'] = $gId;
                    $_SESSION['email'] = $gMail;
                    $_SESSION['nombreusuario'] = $gName;
                    $_SESSION['apellidousuario'] = $gLastName;
                    $_SESSION['photo'] = $gPhoto;
                    header("Location: ../");
                }
                else
                {
                    echo 'Usuario Eliminado';
                }
            } 
            else 
            {
                $newUser = $conexion -> prepare("INSERT INTO usuario(idusuario, emailusuario, nombreusuario, apellidousuario, photo) VALUES(?, ?, ?, ?, ?)");
                $newUser = $newUser -> execute(array($gId, $gMail, $gName, $gLastName, $gPhoto));
                var_dump($account);
                if($newUser)
                {
                    $_SESSION['idusuario'] = $gId;
                    $_SESSION['email'] = $gMail;
                    $_SESSION['nombreusuario'] = $gName;
                    $_SESSION['apellidousuario'] = $gLastName;
                    $_SESSION['photo'] = $gPhoto;
                    header("Location: ../");
                }
                else
                {
                    echo "Algo ha salido mal en el New User";
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