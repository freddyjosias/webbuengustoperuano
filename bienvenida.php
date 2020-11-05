<?php 
    
    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) {
        header('Location: index.php');
    } 

    if (!isset($_GET['view'])) {
        header('Location: index.php');


    } else {

        $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';

        $idRestaurante;
        $bannerSucursal;
        $imagenSucursal;
        $textoBienvenida;
        $imgdestacado1;
        $imgdestacado2;
        $imgdestacado3;
        $platodescatado1;
        $platodescatado2;
        $platodescatado3;
        $nombreRestaurante;
        

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $imagenSucursal = $row['imgbienvenida'];
                $textoBienvenida = $row['textobienvenida'];
                $imgdestacado1 = $row['imgdestacado1'];
                $imgdestacado2 = $row['imgdestacado2'];
                $imgdestacado3 = $row['imgdestacado3'];
                $platodescatado1 = $row['platodestacado1'];
                $platodescatado2 = $row['platodestacado2'];
                $platodescatado3 = $row['platodestacado3'];
                $nombreRestaurante = $row['nomsucursal'];
                break;
            }
        }

        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {

?>

<!DOCTYPE html>
<html>
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <title>Bienvenida | <?php echo $nombreRestaurante ?></title>
        <link rel="shorcut icon" href="img/logo-icono.png">
        <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/bootstrap.add.css">
        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="fontawesome/css/all.min.css">
	    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>

    <div class='logo-icono d-none d-md-block'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        
        <?php require 'menu/menurestaurants.php'; ?>

    </header>
    <main class="contenedor-general">
        <div class='bienvenida-page'>

            <div>
                <?php echo "<img src='".$imagenSucursal."' >" ?>
                <h2 class='fw-600'>Bienvenidos:</h2>
                
                <p class='fs-19'><?php echo $textoBienvenida ?></p>
                <?php echo "<img src='".$imagenSucursal."' >" ?>
                
            </div>
            
            <div>
                <h2 class='fw-600'>Destacados:</h2>
                <div class="destacados-bienvenida">
                    <div>
                        <?php echo "<img src='".$imgdestacado1."' >" ?>
                        <h3><?php echo $platodescatado1 ?> </h3>
                    </div>
                    <div>
                        <?php echo "<img src='".$imgdestacado2."' >" ?>
                        <h3> <?php echo $platodescatado2 ?> </h3>
                    </div>
                    <div>
                        <?php echo "<img src='".$imgdestacado3."' >" ?>
                        <h3> <?php echo $platodescatado3 ?> </h3>
                    </div>
                </div>
            </div>

        </div>
    </main>
    <footer class="footer-inicio">
        <div class= "contenedor-general">
            <div>© 2020 Restaurante 1 SAC. Todos los derechos reservados</div>
        </div>
    </footer>

    <img src="img/ir-arriba.png" class="ir-arriba">

    <div class="submenu-bottom container-fluid position-fixed bottom-0 d-block d-lg-none border border-light border-bottom-0 border-right-0 border-left-0">

        <div class="row text-center h-100">

            <div class="col-6 fs-22 h-100 d-flex border-right">
                <a href="index.php" class='text-white h-100 w-100 pt-1'><i class="fas fa-home"></i></a>
            </div>

            <div class="col-6 text-white fs-35">

                <div class="go-up h-100 d-flex top-0 justify-content-center w-100" role='button'>
                    <i class="fas fa-angle-up"></i>
                </div>

            </div>
        </div>

    </div>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>


<?php
        }

    }

?>