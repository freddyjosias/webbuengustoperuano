<?php 

    $conexionDB = new mysqli('localhost', 'root', '', 'buengustoperuano');
    $conexionDB -> set_charset("utf8");

    if (!isset($_GET['view'])) {
        header('Location: index.php');
    } else {

        $consultaVerificarRestaurante = 'SELECT idsucursal FROM sucursal';

        $idRestaurante;
        $resultados = mysqli_query($conexionDB, $consultaVerificarRestaurante); 
        while($row = mysqli_fetch_assoc($resultados)) { 
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
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
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <title>Bienvenida - Restaurante 1</title>
        <link rel="shorcut icon" href="img/favicon.ico">
        <link rel="stylesheet" href="css/normalize.css">
	    <link rel="stylesheet" type="text/css" href="css/estilos.css">
	    <link rel="stylesheet" type="text/css" href="fonts/style.css">
</head>
<body>

    <div class='logo-icono'>
        <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <img src="img/norteño.jpg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="">Bienvenida</a></li>
                <li><a href="hacer-pedido.php?view=<?php echo $idRestaurante ?>">Pedidos</a></li>
                <li><a href="nosotros.php?view=<?php echo $idRestaurante ?>">Nosotros</a></li>
            </ul>
        </nav>
    </header>
    <main class="contenedor-general">
        <div class='bienvenida-page'>

            <div>
                <img src="img/menu.jpg"> 
                <h1>Bienvenidos:</h1>
                
                <p>Hace varios ayeres, en el Perú cambio el concepto del comer; Este gran cambio se ha convertido en toda una filosofía que permite que muchos restaurantes queden como favoritos de la gente.</p>
                <p>Esta gran filosofía es; “EL BUEN COMER…” es decir que todos trabajamos con el Mandil bien puesto,  y esto no es sino, mas que el meditado cuidado de todos los detalles”…, porque la intención ha sido siempre tratar a nuestros invitados como tú lo harías en tu propia casa.</p>
                <p>Nosotros como empresa gastronómica no podíamos estar ajenos a ello ya que todos los que conformamos Oh…mar, tratamos de personificar esa filosofía valiéndonos de nuestra rica gastronomía, típica y de tradición; admirada y envidiada por muchos, agregándole los ingredientes de calidad del producto, la atención personalizada y el costo proporcionado.</p>
                <p>Contamos con un personal especializado en cada una de sus áreas de trabajo, para brindar al cliente fiel una respuesta excelente a la confianza que ha depositado en nosotros, y al nuevo usuario una posibilidad de establecer un lugar con el que se sienta identificado.</p> 
                <img src="img/menu.jpg"> 
                
            </div>
            
            <div>
                <h1>Destacados:</h1>
                <div class="destacados-bienvenida">
                    <div>
                        <img src="img/destacado1.jpg" alt="">
                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero cum voluptates quo incidunt neque culpa aliquid hic minus</h3>
                    </div>
                    <div>
                        <img src="img/destacado2.jpg" alt="">
                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero cum voluptates quo incidunt neque culpa aliquid hic minus</h3>
                    </div>
                    <div>
                        <img src="img/destacado3.jpg" alt="">
                        <h3>Lorem ipsum dolor sit amet consectetur adipisicing elit. Vero cum voluptates quo incidunt neque culpa aliquid hic minus</h3>
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

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/script.js"></script>

</body>
</html>


<?php
        }

    }

?>