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

    $sucursalSearch = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE nomsucursal LIKE "%' . $_GET['view'] . '%" AND estado = 1');
    $sucursalSearch -> execute();
    $sucursalSearch = $sucursalSearch -> fetchAll(PDO::FETCH_ASSOC);

    $sucursalSearch1 = $conexion -> prepare(
        'SELECT c.idsucursal, s.nomsucursal, c.idcategoriaproducto, c.descripcioncategoriaproducto 
         FROM categoriaproductos AS c INNER JOIN sucursal AS s ON c.idsucursal = s.idsucursal
         WHERE c.descripcioncategoriaproducto 
         LIKE "%' . $_GET['view'] . '%" AND c.estado = 1 AND s.estado = 1');
    $sucursalSearch1 -> execute();
    $sucursalSearch1 = $sucursalSearch1 -> fetchAll(PDO::FETCH_ASSOC);

    $sucursalSearch2 = $conexion -> prepare(
        'SELECT c.idsucursal, c.idcategoriaproducto, c.descripcioncategoriaproducto, p.idproducto, p.nomproducto 
         FROM productos AS p INNER JOIN categoriaproductos AS c ON p.idcategoriaproducto = c.idcategoriaproducto
         WHERE p.nomproducto LIKE "%' . $_GET['view'] . '%" AND p.estado = 1');
    $sucursalSearch2 -> execute();
    $sucursalSearch2 = $sucursalSearch2 -> fetchAll(PDO::FETCH_ASSOC);

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

    <section class="box-usuario">
        <div class="contenedor-general view-restaurants mb-4 text-center">
            <h1 class='text-center h1'>RESULTADOS DE LA BUSQUEDA</h1>
            <div class="w-100 d-flex m-auto">
                <div class="w-100">
                    <h3 class="h3 fw-600">Restaurantes</h3>
                        <?php foreach ($sucursalSearch as $row) { ?>
                            <a class="dropdown-item" href="../nosotros.php?view=<?php echo $row['idsucursal'] ?>"><?php echo $row['nomsucursal'] ?></a>
                        <?php } ?>
                </div>
                <div class="w-100">
                    <h3 class="h3 fw-600">Categorias</h3>
                        <div class="text-center m-auto">
                            <?php foreach ($sucursalSearch1 as $row) { ?>
                                <p class="w-75 pt-1 fw-600 m-auto d-flex text-center">(<?php echo $row['nomsucursal']; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a class="text-dark text-decoration-none" href="../hacerpedido.php?view=<?php echo $row['idsucursal'] ?>"><?php echo $row['descripcioncategoriaproducto'] ?></a></p>
                            <?php } ?>
                        </div>
                </div>
                <div class="w-100">
                    <h3 class="h3 fw-600">Productos</h3>
                        <div class="text-center m-auto">
                            <?php foreach ($sucursalSearch2 as $row) { ?>
                                <p class="w-100 pt-1 fw-600 m-auto d-flex text-center">(<?php echo $row['descripcioncategoriaproducto']; ?>)&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</p><a class="text-dark text-decoration-none" href="../hacerpedido.php?view=<?php echo $row['idsucursal'] ?>"><?php echo $row['nomproducto'] ?></a>
                            <?php } ?>
                        </div>
                </div>
            </div>
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