<?php
    require '../conexion.php';
    
    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: ../');
    } 
    else 
    {
        $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 3");
        $queryProfile -> execute(array($_SESSION['idusuario']));
        $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);

        if (isset($queryProfile['id_profile'])) 
        {
            $profileAdmin = true;
        } 
        else
        {
            $profileAdmin = false;
        }

    }

    $sucursalSearch = $conexion -> prepare('SELECT * FROM sucursal WHERE nomsucursal LIKE "%' . $_GET['view'] . '%" AND estado = 1');
    $sucursalSearch -> execute();
    $sucursalSearch = $sucursalSearch -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Resultados de la búsqueda</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body>
    <header class="header-inicio ">

        <div class="contenedor-general contenido-header-inicio row">

            <div class="contenedor-img col-6 m-0 px-0 py-3 h-4r d-flex">
                <img src="../img/logo-icon-512-color.png" class="h-100">
                <img src="../img/logo-text-1024-white.png" class="h-100 ml-3 d-none d-sm-block">
                <img src="../img/logo-text-1024-white-min.png" class="h-100 ml-3 d-block d-sm-none">
            </div>

            <div class="cerrar-sesion text-right col-6 m-0 p-0 ">
                <div class="container h-100 align-items-center d-flex p-0">
                    <?php if ($profileAdmin) { ?>
                        <a class='text-white h3 sm-h2 ml-auto mb-0' title='Panel de Administrador' href="../paneladmin/index.php"><i class="fas fa-cogs"></i></a>
                    <?php } ?>

                    <a class='text-white d-flex h3 <?php echo ($profileAdmin) ? 'ml-3 ml-sm-4' : 'ml-auto' ?> sm-h2  mb-0' title='Información de la cuenta' href="../cuenta/micuenta.php">
                        <img src="<?php echo $_SESSION['photo'] ?>" alt="" class='border rounded-circle photo-user-home'>
                    </a>
                    
                    <a class='text-white h3 sm-h2 ml-3 ml-sm-4 mb-0' title='Cerrar Sesión' href="../home/logout.php"><i class="fas fa-sign-out-alt"></i></a>
                </div>
            </div>

        </div>

    </header>

    <div class="slider contenedor-general">
        <div class="slider-img efecto">
            <img src="../img/img1.jpg">
        </div>
        <div class="slider-img efecto">
            <img src="../img/img2.jpg">
        </div>
        <div class="slider-img efecto">
            <img src="../img/img3.jpg">
        </div>
        <div class="slider-img efecto"> 
            <img src="../img/img4.jpg">
        </div>
        <div class="direcciones">
            <a href="#" class="atras">&#10094</a>
            <a href="#" class="adelante">&#10095</a>
        </div>
    </div>

    <section class="box-usuario">
        <div class="contenedor-general view-restaurants mb-4">
            <h1 class='text-center'>RESTAURANTES</h1>
            <?php $contadorRestaurantes = 0;
            foreach($sucursalSearch as $row) {
                if ($contadorRestaurantes % 2 == 0) { ?>
                    <div class="presentacion-restaurantes">
                <?php } ?>
                    <a href="../hacerpedido.php?view=<?php echo $row['idsucursal']; ?>">
                        <div>
                            <h2><?php echo $row['nomsucursal']; ?>:</h2>
                            <img src="../<?php echo $row['imgbienvenida']; ?>">
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

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../bootstrap/js/popper.min.js"></script>
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <script src="../js/bootstrap.add.js"></script>
    <script src="../sweetalert/sweetalert210.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>