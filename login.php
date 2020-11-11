<?php

    session_start();

    require 'conexion.php';

    $consultaRestaurantes = 'SELECT idsucursal, nomsucursal, imgbienvenida FROM sucursal WHERE estado = 1';

?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
    <title>Web Buen Gusto Peruano</title>
</head>
<body>

    <div class="draw-one">

    </div>

    <div class="draw-two">
        <div class="container">

        </div>
    </div>
    
    <div class="container-fluid container-login-new">
        <div class="container w-75r">
            <div class="row align-items-center vh-100 justify-content-center">
                <?php 
                
                if (isset($_POST['login'])) {
                    if (strlen($_POST['usuario']) > 0 && strlen($_POST['clave']) > 0) {
                        $usuario = $_POST['usuario'];
                        $clave = $_POST['clave'];
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

                                    header('Location: nosotros.php?view=' . $resultadosR[0]['idsucursal']);
                                    die;

                                }
                                header('Location: home.php');
                                die;
                                break;
                            }
                        }
                        

                    }
                }
            
                ?>

                <div class="col-5 bg-white rounded-left-15 text-center h-30r mb-6r px-3 py-5 shadow-lg">
                    <h4 class="mt-1 text-muted">Bienvenido a</h3>
                    <h1 class="fw-600 mt-0 color-header">BUEN GUSTO PERUANO</h1>
                    <h6 class="text-muted fw-400 mx-5 mt-4 fs-18">Ingresa y podrás acceder a muchos restaurantes con los platillos más deliciosos de la región</h6>
                    <form method='post' class="box-login mt-3">
                        <input type="text" placeholder="Correo" name="usuario" required>
                        <input type="password" placeholder="Contraseña" name="clave" required>
                        <input type="submit" value="Ingresar" name="login">
                        <?php
                            if (isset($datosErroneos)) {
                                ?>
                                    <div class="alert alert-danger text-center" role='alert'>
                                        Datos incorrectos &nbsp; <i class="far fa-times-circle"></i>
                                    </div>
                                <?php
                            }
                        ?>
                    </form>
                    <p class="mt-1r text-left ml-5 fw-500 fs-18">Continua con la siguiente <u> red social</u>:</p>
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
                </div>

                <div class="col-5 text-white rounded-right-15 h-30r mb-6r p-0 position-relative shadow-lg">

                    <div class="container p-0 w-100 h-100 login-img-right rounded-right-15">
                        <img src="img/img5.jpg" alt="" class="w-100 h-100 rounded-right-15">
                    </div>

                    <div class="container position-absolute h-100 rounded-right-15 container-login-text-right">
                        <div class="row text-center align-items-center h-100 login-text-right">
                            <div class="row">
                                <div class="col">
                                    <img src="img/logo-icon-512-color.png" alt="" class="">
                                </div>
                                <h1 class="w-100 mt-2">Buen Gusto Peruano</h1>
                                <h6 class="mx-5r">Lorem ipsum dolor sit amet consectetur adipisicing elit. Delectus consectetur voluptatem nostrum voluptas, doloribus iusto quo quas iste ullam harum.</h6>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.add.js"></script>
    <script src="js/script.js"></script>

</body>
</html>