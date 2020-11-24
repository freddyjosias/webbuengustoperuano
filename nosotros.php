<?php 

    require 'conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) {
        header('Location: index.php');
    } 
    else 
    {
        $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 2");
        $queryProfile -> execute(array($_SESSION['idusuario']));
        $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);

        if (isset($queryProfile['id_profile'])) 
        {
            $profileManager = true;
        } 
        else
        {
            $profileManager = false;
        }

    }
    

    if (!isset($_GET['view'])) {
        header('Location: index.php');
    } else {

        $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';
        

        $idRestaurante;
        $bannerSucursal;
        $nombresucursal;
        $telefonoRestaurante;
        $correoRestaurante;
        $ubicacionRestaurante;


        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $nombresucursal = $row['nomsucursal'];
                $telefonoRestaurante = $row['telefono'];
                $correoRestaurante = $row['correosucursal'];
                $ubicacionRestaurante = $row['direcsucursal'];
                $atencioninicioRestautante = $row['horaatencioninicio'];
                $atencioncierreRestautante = $row['horaatencioncierre'];
                break;
            }
        }

        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {
        
            $consultaFormaPago = 'SELECT descripciontipospedido FROM tipospedido INNER JOIN detalletipospedido ON tipospedido.idtipospedido = detalletipospedido.idtipospedido INNER JOIN sucursal ON sucursal.idsucursal = detalletipospedido.idsucursal WHERE disponibilidadtipospedido = 1 AND sucursal.idsucursal = ' . $_GET['view'];

            $consultaTipoPago = 'SELECT descripcionformaspago FROM formaspago INNER JOIN detalleformaspago ON formaspago.idformaspago = detalleformaspago.idformaspago INNER JOIN sucursal ON sucursal.idsucursal = detalleformaspago.idsucursal WHERE disponibilidadformaspago = 1 AND sucursal.idsucursal = ?';

            if($profileManager == true)  {
                $consultaManager = $conexion -> prepare("SELECT access_id FROM access WHERE state = 1 AND idusuario = ? AND idsucursal = ?");
                $consultaManager -> execute(array($_SESSION['idusuario'], $_GET['view']));
                $consultaManager = $consultaManager -> fetch(PDO::FETCH_ASSOC);
  
                  if($consultaManager == false){
  
                      $profileManager = false;
                      
                  }
              }

              $resultadosR = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE estado = 1');
              $resultadosR -> execute();
              $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);
          
              $resultadosEn = $conexion -> prepare('SELECT a.idusuario, u.nombreusuario, u.apellidousuario, s.nomsucursal, u.emailusuario, s.idsucursal FROM access as a INNER JOIN usuario as u ON a.idusuario = u.idusuario INNER JOIN detail_usuario_profile as m ON a.idusuario = m.idusuario INNER JOIN sucursal as s ON s.idsucursal = a.idsucursal WHERE a.state = 1 AND s.estado = 1 AND m.state = 1 AND m.id_profile = 2 AND u.estado = 1 ORDER BY s.nomsucursal, u.nombreusuario');
              $resultadosEn -> execute();
              $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

              if (isset($_POST['comment'])) {

              $crateComment = $conexion -> prepare('INSERT INTO sucursal_comment(idusuario, idsucursal, comment_description) VALUES (?, ?, ?)');
              $crateComment -> execute(array($_SESSION['idusuario'], $_GET['view'], $_POST['comment']));

              }

              $resultadosC = $conexion -> prepare('SELECT * FROM sucursal_comment AS s INNER JOIN usuario AS u ON u.idusuario = s.idusuario WHERE s.comment_state = 1 AND s.idsucursal = ? AND u.estado = 1');
              $resultadosC -> execute(array($_GET['view']));
              $resultadosC = $resultadosC -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Nosotros | <?php echo $nombresucursal ?></title>
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/comentarios.css">
</head>
<body>

    <div class='logo-icono d-none d-md-block'>
        <a href="index.php"><img src="img/logo-icon-512-color.png" alt=""></a>
    </div>

    <div class='logo-icono right-2p d-none d-md-block'>
        <a href="cuenta/micuenta.php"><img src="<?php echo $_SESSION['photo'] ?>" class='border rounded-circle' alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        
        <?php require 'menu/menurestaurants.php'; ?>

	</header>



    <main class="contenedor-general">

        <div class="introduccion-quienes-somos pt-4 pb-3">
            <p> Situado en el centro de Tarapoto, ofrecemos a nuestros clientes la experiencia de disfrutar de los productos tipicos y autóctonos de la selva peruana. Proponemos platos tipicos dinámico sujeto a la disponibilidad de los productos, tan cambiante e impredecible como puedan ser las condiciones climatológicas y la temporada, es por eso que nuestra carta esta a disponibilidad de todos nuestros clientes.</p>
		</div>
		
		<div class="contenido-main-somos">
            
            <div class="div">
                <div class="horariodeatencion">
                    <h2 class='h5 text-uppercase fw-600 '>Horario de atención</h2>
                    <ul>
                        <li><p class='my-1'>Lunes a Domingo <?php echo $atencioninicioRestautante . ' - ' . $atencioncierreRestautante ?></p></li>
                    </ul>
                </div>
                
                <div class="telefono">
                    <h2 class='h5 text-uppercase fw-600 '>Teléfono</h2>
                    <ul>
                        <li><p class='my-1'><?php echo $telefonoRestaurante; ?></p></li>
                    </ul>
                </div>
            </div>
            
            <div class="div">
                <div class="ubicacion">
                    <h2 class='h5 text-uppercase fw-600 '>Dirección</h2>
                    <ul>
                        <li><p class='my-1'><?php echo $ubicacionRestaurante;?></p></li>
                    </ul>
                </div>

                <div class="correoelectronico">
                    <h2 class='h5 text-uppercase fw-600 '>Correo electrónico</h2>
                    <ul>
                        <li><p class='my-1'><?php echo $correoRestaurante; ?></p></li>
                    </ul>
                </div>
            </div>
            
            <div class="div">
                <div class="formadepago">
                    <h2 class='h5 text-uppercase fw-600 '>Tipos de envió</h2>
                    <ul>
                        <?php $resultados = $conexion -> prepare($consultaFormaPago);
                        $resultados -> execute();
                        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultados as $row) {?>
                            <li><p class='my-1'><?php echo $row['descripciontipospedido'] ?></p></li>
                        <?php } ?>
                </ul>
                </div>

                <div class="gastosdeenvio">
                    <h2 class='h5 text-uppercase fw-600 '>Forma de pagos</h2>
                    <ul>
                        <?php $resultados = $conexion -> prepare($consultaTipoPago);
                        $resultados -> execute(array($_GET['view']));
                        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
                        foreach($resultados as $row) {?>
                            <li><p class='my-1'><?php echo $row['descripcionformaspago'] ?></p></li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
         
        </div>

        <div class="mapa-quienes-somos">    
            <h3 class='mt-3 mb-4'>Nos Encontramos Aquí</h3>
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d9428.608432958468!2d-76.36468223737711!3d-6.49107291844111!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x91ba0c062708ad1d%3A0x470eec16e5498700!2sPlaza%20de%20Armas%20de%20Tarapoto!5e0!3m2!1ses-419!2spe!4v1600025859915!5m2!1ses-419!2spe"  style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>	

        <div class="btn-color-princi ml-auto text-center mt-5 mb-5">
            <a class="buttom-add-manager btn btn-primary bottom fw-600">Cargar Comentarios</a>
        </div>
        <div class="col-12 form-add-manager">

        <div class="btn-color-princi ml-auto text-center mt-5 mb-5">
            <a class="cancel-add-manager btn btn-primary bottom fw-600">Ocultar Comentarios</a>
        </div>
                        
                        <form class='text-center w-100 mt-0' method='post'>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class='d-flex'>Escribe un comentario:</label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="comment"></textarea>
                                </div>

                            
                                <div class='form-group d-flex'>
                                    <button class='btn btn-primary mt-3 px-4 fw-600'>Añadir</button>
                                </div>
                        </form>


                        <table class="table mt-4">
                            <thead class='thead-light fs-18'>
                                <tr>
                                    <th scope="col" class='text-center'>Comentarios Realizados:</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <?php foreach($resultadosC as $row) {?>
                            <tbody>
                                <tr>
                                    <td><a href="cuenta/micuenta.php"><img src="<?php echo $row['photo'] ?>" class='border rounded-circle' alt=""></a></td>
                                    <td><?php echo $row['comment_description'] ?></td>
                                </tr>
                            </tbody>
                            <?php } ?>
                        </table>
            </div>
                    
    </main>
    
    <footer class="footer-inicio">
        <div class='contenedor-general'>
            <div>© 2020 Restaurante 1 SAC. Todos los derechos reservados</div>
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
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>

<?php
        }

    }

?>