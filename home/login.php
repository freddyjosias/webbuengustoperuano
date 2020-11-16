<?php

    if (!isset($_SESSION)) 
    {
        header('Location: ../');
    }

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
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
    <title>Buen Gusto Peruano</title>
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

                <div class="col-5 bg-white rounded-left-15 text-center h-31r mb-6r px-3 py-5 shadow-lg">
                
                    <h4 class="mt-1 text-muted">Bienvenido a</h3>
                    <h1 class="fw-600 mt-0 color-header mb-2">BUEN GUSTO PERUANO</h1>

                    <?php require 'loginuri.php'?>

                    <p class="mt-3 mb-1 text-center mx-5 fw-400 fs-17">O ingresa con tu <span class='fw-600'>correo:</span></p>

                    <form method='post' action='home/loginuri.php'>

                        <div class="form-group mb-1 row justify-content-center">
                            <label for="exampleInputEmail1" class='col-9 px-0 text-left fs-17 fw-500'>Correo:</label>
                            <input type="email" name='useremail' class="col-9 form-control" id="exampleInputEmail1" aria-describedby="emailHelp" required>
                        </div>

                        <div class="form-group row justify-content-center">
                            <label for="exampleInputPassword1" class='col-9 px-0 text-left fs-17 fw-500'>Contraseña:</label>
                            <input type="password" class="col-9 form-control" id="exampleInputPassword1" name='userpassword' required>
                        </div>

                        <div class="row justify-content-center">
                            <div class="col-10 d-flex">
                                <button type="submit" class="btn btn-primary ml-1 px-3">Ingresar</button>
                            </div>
                        </div>
                        
                    </form>

                </div>

                <div class="col-5 text-white rounded-right-15 h-31r mb-6r p-0 position-relative shadow-lg">

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
                                <h6 class="mx-5r ls-13">El mayor secreto del éxito es lograr probar lo que más te gusta y permitir que la comida haga su lucha en tu interior. 
                                Ingresa y podrás acceder a una cadena de restaurantes con los platillos más deliciosos e agradables de la región San Martín.</h6>
                            </div>
                        </div>
                    </div>

                </div>
        </div>
    </div>
    
    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.add.js"></script>
    <script src="sweetalert/sweetalert210.js"></script>
    <script src="js/script.js"></script>

    <?php
        if (isset($_SESSION['invaliduser'])) {
            unset($_SESSION['invaliduser']);
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'error',
                    title: 'Usuario y contraseña incorrecta'
                })

            </script>
                
            <?php
        }
    ?>

</body>
</html>