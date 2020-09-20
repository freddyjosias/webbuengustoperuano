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
	<title>Hacer Pedido</title>
        <meta charset="utf-8">
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
        <title>Quienes Somos - Restaurante 1</title>
    
        <link rel="stylesheet" href="css/normalize.css">
	    <link rel="stylesheet" type="text/css" href="css/estilos.css">
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
                <li><a href="inicio.php?view=<?php echo $idRestaurante ?>">Inicio</a></li>
                <li><a href="">Pedidos</a></li>
                <li><a href="quienes-somos.php?view=<?php echo $idRestaurante ?>">Quienes Somos</a></li>
            </ul>
        </nav>
	</header>
	
    <main class= "carta">

        <div class= "contenedor-general">

            <h1>MENÚ - CARTA</h1>

			<div class="contenido-carta">	
                    
                <h2>Entradas:</h2>

			    <div>
					<div class="productos-carta">
                        <div><h3> Causa de pollo</h3></div>
                        <div>S/.9.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Ceviche achorado(pescado y chicharron mixto)</h3></div>
                        <div>S/.10.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Langostinos pacifico(6 unidades)</h3></div>
                        <div>S/.15.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Papa a la huancaina</h3></div>
                        <div>S/.10.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Tequeños de lomo saltado</h3></div>
                        <div>S/.12.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Wantanes peruanos</h3></div>
                        <div>S/.13.00</div>
                    </div>						
				</div>
                
				<h2>Fondos:</h2>
				
				<div>
					<div class="productos-carta">
                        <div><h3> Aji de gallina</h3></div>
                        <div>S/.20.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Arroz chaufa de Mamani con pollo y carne</h3></div>
                        <div>S/.25.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Arroz con mariscos</h3></div>
                        <div>S/.20.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Jalea mixta</h3></div>
                        <div>S/.30.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Lomo saltado</h3></div>
                        <div>S/.25.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Tacu tacu de mariscos</h3></div>
                        <div>S/.25.00</div>
                    </div>						
				</div>
              
                <h2>Postres:</h2>

				<div>
					<div class="productos-carta">
                        <div><h3> Flan al pisco y fresas</h3></div>
                        <div>S/.9.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Panqueque con manjar blanco y durazno</h3></div>
                        <div>S/.9.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Picarones</h3></div>
                        <div>S/.9.00</div>
                    </div>						
				</div>
    			                  
				<h2>Refrescos:</h2>
				
				<div>
					<div class="productos-carta">
                        <div><h3> Chicha morada</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Limonada</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Naranjada</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Piña</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Uva</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Taperibá</h3></div>
                        <div>S/.6.00</div>
					</div>
					<div class="productos-carta">
                        <div><h3>Maracuyá</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Guanábana</h3></div>
                        <div>S/.6.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Camu Camu</h3></div>
                        <div>S/.6.00</div>
                    </div>									
				</div>
		             
                <h2>Gaseosas:</h2>

                <div>
			        <div class="productos-carta">
                        <div><h3>Inca Kola</h3></div>
                        <div>S/.2.00</div>
                    </div>
                    <div class="productos-carta">
                        <div><h3>Coca Cola</h3></div>
                        <div>S/.2.00</div>
                    </div>	
    				<div>  						    				
               </div>             
            </div>           
        </div>
    </main>
    
	<footer class="footer-inicio">
        <div>
            <div>© 2020 Restaurante 1 SAC. Todos los derechos reservados</div>
        </div>
    </footer>

</body>
</html>

<?php
        }

    }

?>