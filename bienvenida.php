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
        <link rel="shorcut icon" href="img/favicon.ico">
        <link rel="stylesheet" href="css/normalize.css">
	    <link rel="stylesheet" type="text/css" href="css/estilos.css">
</head>
<body>

    <div class='logo-icono'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        <nav>
            <ul>
                <li><a href="">Bienvenida</a></li>
                <li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>">Pedidos</a></li>
                <li><a href="nosotros.php?view=<?php echo $idRestaurante ?>">Nosotros</a></li>
                    <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
                        <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
                            <li><a href="panel.php">Panel</a></li>
                        <?php } ?> 
                    <?php } ?>   
                <li><a href="anadircarrito.php?view=<?php echo $idRestaurante ?>"><img src="img/carrito.png" class="carrito-compras"></a></li>        
            </ul>
        </nav>
    </header>
    <main class="contenedor-general">
        <div class='bienvenida-page'>

            <div>
                <?php echo "<img src='".$imagenSucursal."' >" ?>
                <h1>Bienvenidos:</h1>
                
                <p><?php echo $textoBienvenida ?></p>
                <img src="img/menu.jpg"> 
                
            </div>
            
            <div>
                <h1>Destacados:</h1>
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

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>


<?php
        }

    }

?>