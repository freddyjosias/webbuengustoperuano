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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Comentarios | <?php echo $nombresucursal ?></title>
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

        <div class="container-fluid p-0 d-none d-md-block">
            <nav class="nav-restaurant z-index-7 mt-2r">
                <ul>
                    <li><a href="">Nosotros</a></li>
                    <li><a href="comentarios.php">Comentarios</a></li>
                </ul>
            </nav>
        </div>

	</header>

    <main>
         
                <div class="row w-f14-80 w-90 m-auto contenedor-panel-admin">
                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-manager'>COMENTARIOS</h1>

                    <div class="col-12 form-add-manager">
                        
                        <form class='text-center w-100 mt-0' method='post'>
                                <div class="form-group">
                                    <label for="exampleFormControlInput1" class='d-flex'>Escribe un comentario:</label>
                                </div>
                                <div class="form-group">
                                    <label for="exampleFormControlTextarea1"></label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="3"></textarea>
                                </div>

                            
                                <div class='form-group d-flex'>
                                    <button type="button" class="cancel-add-manager btn btn-light ml-auto mt-3 mr-3">Cancelar</button>
                                    <button class='btn btn-primary mt-3 px-4 fw-600'>Añadir</button>
                                </div>
                        </form>
                    </div>

                        <div class="btn-color-princi ml-auto">
                            <a class="buttom-add-manager btn btn-primary bottom fw-600">Agregar Encargado</a>
                        </div>

                        <table class="table mt-4">
                            <thead class='thead-light fs-18'>
                                <tr>
                                    <th scope="col" class='text-center'>Comentarios Realizados:</th>
                                </tr>
                            </thead>
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