<!DOCTYPE html>
<html>
<head>
	<title>Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>
                            
        <header class="header-inicio ">

            <div class="contenedor-general contenido-header-inicio row">

                <div class="contenedor-img col-6 m-0 px-0 py-3 h-4r d-flex">
                    <img src="img/logo-icon-512-color.png" class="h-100">
                    <img src="img/logo-text-1024-white.png" class="h-100 ml-3 d-none d-sm-block">
                    <img src="img/logo-text-1024-white-min.png" class="h-100 ml-3 d-block d-sm-none">
                </div>

                <div class="cerrar-sesion text-right col-6 m-0 p-0 ">
                    <div class="container h-100 align-items-center d-flex p-0">
                        <?php if ($profileAdmin) { ?>
                            <a class='text-white h3 sm-h2 ml-auto mb-0' title='Panel de Administrador' href="paneladmin/index.php"><i class="fas fa-cogs"></i></a>
                        <?php } ?>

                        <a class='text-white d-flex h3 <?php echo ($profileAdmin) ? 'ml-3 ml-sm-4' : 'ml-auto' ?> sm-h2  mb-0' title='Información de la cuenta' href="cuenta/micuenta.php">
                            <img src="<?php echo $_SESSION['photo'] ?>" alt="" class='border rounded-circle photo-user-home'>
                        </a>
                        
                        <a class='text-white h3 sm-h2 ml-3 ml-sm-4 mb-0' title='Cerrar Sesión' href="home/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                    </div>
                </div>

            </div>

        </header>

        <section class="box-usuario">
            <div class="contenedor-general view-restaurants mb-4 mt-5">
                <h1 class='text-center'>RESULTADOS</h1>
                <?php $contadorRestaurantes = 0;
                $resultados = $conexion -> prepare($consultaRestaurantes);
                $resultados -> execute();
                $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                foreach($resultados as $row) {
                    if ($contadorRestaurantes % 2 == 0) { ?>
                        <div class="presentacion-restaurantes">
                    <?php } ?>
                        <a href="hacerpedido.php?view=<?php echo $row['idsucursal']; ?>">
                            <div>
                                <h2><?php echo $row['nomsucursal']; ?>:</h2>
                                <img src="<?php echo $row['imgbienvenida']; ?>">
                            </div>
                        </a>
                    <?php $contadorRestaurantes++;
                    if ($contadorRestaurantes % 2 == 0) {?>
                    </div>
                <?php }
                } ?>

            </div>
        </section>
        <footer class="footer-inicio">
            <div class= "contenedor-general">
                <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
            </div>
        </footer>
        <div class="function-go-up ir-arriba">
            <i class="fas fa-angle-up"></i>
        </div>
        <div class="submenu-bottom container-fluid position-fixed bottom-0 d-block d-lg-none border border-light border-bottom-0 border-right-0 border-left-0">
            <div class="row text-center h-100">
                <div class="col-6 fs-22 h-100 d-flex border-right">
                    <a href="index.php" class='text-white h-100 w-100 pt-1'><i class="fas fa-home"></i></a>
                </div>
                <div class="col-6 text-white fs-35">
                    <div class="function-go-up go-up h-100 d-flex top-0 justify-content-center w-100" role='button'>
                        <i class="fas fa-angle-up"></i>
                    </div>
                </div>
            </div>

        </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.add.js"></script>
    <script src="sweetalert/sweetalert210.js"></script>
    <script src="js/script.js"></script>

</body>
</html>