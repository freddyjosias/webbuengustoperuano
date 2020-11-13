<?php

    require_once '../conexion.php';

    if (isset($_POST['useremail'])) {

        if (strlen($_POST['useremail']) > 0 && strlen($_POST['userpassword']) > 0) {

            session_start();
            
            $usuario = $_POST['useremail'];
            $clave = $_POST['userpassword'];
            $consultaUsuario = 'SELECT * FROM usuario WHERE estado = 1 OR estado = 2';
            $datosErroneos = 1;
            $resultados = $conexion -> prepare($consultaUsuario);
            $resultados -> execute();
            $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
            //var_dump($resultados); die;

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

                        header('Location: nosotros.php?view=' . $resultadosR[0]['idsucursal']);
                        die;

                    }
                    header('Location: index.php');
                    die;
                    break;
                }
            }
            

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
        require_once '../conexion.php';
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
            var_dump($account); die;

        }

    } 
    else if($_SERVER['REQUEST_URI'] == "/webbuengustoperuano/")
    {
        
        ?>
            <a href="<?php echo $client -> createAuthUrl() ?>" class="btn btn-primary fw-600 mx-5r w-10r">Google</a>

        <?php

    }

?>