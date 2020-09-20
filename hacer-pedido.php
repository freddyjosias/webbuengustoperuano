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
	    <link rel="stylesheet" type="text/css" href="fonts/style.css">
</head>
<body>
    <header class="header-restaurante">
        <div>
            <img src="img/norteño.jpg" alt="">
        </div>
        <nav>
            <ul>
                <li><a href="">Inicio</a></li>
                <li><a href="">Pedidos</a></li>
                <li><a href="">Quienes Somos</a></li>
            </ul>
        </nav>
	</header>
	
    <main class= "menu-central">
		
	                   <div class="menu-central-icono">
							<h1>
								<img src="img/icono.png">
								Menu - Carta
								
							</h1>
						</div>
    	
			<div class="menu-central-cartas">	
					
			     <div>
					<div>							
							<h4>Entradas</h4>
							<ul>
								<li>Causa de pollo
									<p>S/.9.00</p>
								</li>
								<li>Ceviche achorado(pescado y chicharron mixto)
									<p>S/.10.00</p>
								</li>
								<li>Langostinos pacifico(6 unidades)
									<p>S/.15.00</p>
								</li>
								<li>Papa a la huancaina
									<p>S/.10.00</p>
								</li>
								<li>Tequeños de lomo saltado
									<p>S/.12.00</p>
								</li>
								<li>Wantanes peruanos
									<p>S/.13.00</p>
								</li>
							</ul>						
					</div>
    			
						<div>
							<div>
								<h4>Fondos</h4>
							</div>
							<div>	
								<ul>
									<li>Aji de gallina
										<p>S/.20.00</p>
									</li>
									<li>Arroz chaufa de Mamani con pollo y carne
										<p>S/.25.00</p>
									</li>
									<li>Arroz con mariscos
										<p>S/.20.00</p>
									</li>
									<li>Jalea mixta
										<p>S/.30.00</p>
									</li>
									<li>Lomo saltado
										<p>S/.25.00</p>
									</li>
									<li>Tacu tacu de mariscos
										<p>S/.25.00</p>
									</li>
								</ul>
							</div>
						</div>
				</div>
    			<div>
    				<div>
    					<h4>Postres</h4>
	    				<ul>
	    					<li>Flan al pisco y fresas
	    						<p>S/.9.00</p>
	    					</li>
	    					<li>Panqueque con manjar blanco y durazno
	    						<p>S/.9.00</p>
	    					</li>
	    					<li>Picarones
	    						<p>S/.9.00</p>
	    					</li>
	    				</ul>
    				</div>			
				 
    				<div>
    					<h4>Refrescos</h4>
	    				<ul>
	    					<li>Chicha morada
	    						<p>S/.6.00</p>
	    					</li>
	    					<li>Limonada
	    						<p>S/.6.00</p>
	    					</li>
	    					<li>Naranjada
	    						<p>S/.6.00</p>
							</li>
							<li>Piña
	    						<p>S/.6.00</p>
							</li>
							<li>Uva
	    						<p>S/.6.00</p>
							</li>
							<li>Taperibá
	    						<p>S/.6.00</p>
							</li>
							<li>Maracuyá
	    						<p>S/.6.00</p>
							</li>
							<li>Guanábana
	    						<p>S/.6.00</p>
							</li>
							<li>Camu Camu
	    						<p>S/.6.00</p>
	    					</li>
	    				</ul>
    				</div>				
				</div>
               <div>
    				<div>
    					<h4>Gaseosas</h4>
	    				<ul>
	    					<li>Inca Kola
	    						<p>S/.2.00</p>
	    					</li>
	    					<li>Coca Cola
	    						<p>S/.2.00</p>
	    					</li>
	    				</ul>
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