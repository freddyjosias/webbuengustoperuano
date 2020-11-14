<?php

    require '../../conexion.php';
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: ../../index.php');
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
        header('Location: ../../index.php');
    } else {
       $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';

       $idRestaurante;

       $resultados = $conexion -> prepare($consultaVerificarRestaurante);
       $resultados -> execute();
       $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

       foreach($resultados as $row) {
           if ($row['idsucursal'] ==  $_GET['view']) {
               $idRestaurante = $row['idsucursal'];
           break;
       }
   }

    if (isset($_GET['editarnombre'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET nomsucursal = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['res-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editartelefono'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET telefono = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['tele-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editarcorreo'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET correosucursal = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['email-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editardirec'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET direcsucursal = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['dire-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editarhorainicio'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET horaatencioninicio = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['horai-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editarhorafin'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $resultados = $conexion -> prepare('UPDATE sucursal SET horaatencioncierre = ? WHERE idsucursal = ?');
            $resultados -> execute(array($_POST['horac-actualizada'],$_GET['view']));

            if($resultado){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editartipoenvio'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['delivery'])) {
                $tipo1 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 1 AND idsucursal = ?');
                $tipo1 -> execute(array($_POST['delivery'],$_GET['view']));
            }
    
            if (isset($_POST['recojo'])) {
                $tipo2 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 2 AND idsucursal = ?');
                $tipo2 -> execute(array($_POST['recojo'],$_GET['view']));
            }
    
            if (isset($_POST['reserva'])) {
                $tipo3 = $conexion -> prepare('UPDATE detalletipospedido SET disponibilidadtipospedido = ? WHERE idtipospedido = 3 AND idsucursal = ?');
                $tipo3 -> execute(array($_POST['reserva'],$_GET['view']));
            }

            if($tipo1 || $tipo2 || $tipo3){
               header('Location: restaurante.php'); 
            }
        }
    }

    if (isset($_GET['editartipoenvio'])){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if (isset($_POST['forma1'])) {
                $formapago1 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 1 AND idsucursal = ?');
                $formapago1 -> execute(array($_POST['forma1'], $_GET['view']));
            }
    
            if (isset($_POST['forma2'])) {
                $formapago2 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 2 AND idsucursal = ?');
                $formapago2 -> execute(array($_POST['forma2'], $_GET['view']));
            }
    
            if (isset($_POST['forma3'])) {
                $formapago3 = $conexion -> prepare('UPDATE detalleformaspago SET disponibilidadformaspago = ? WHERE idformaspago = 3 AND idsucursal = ?');
                $formapago3 -> execute(array($_POST['forma3'], $_GET['view']));
            }

            if($formapago1 || $formapago2 || $formapago3){
               header('Location: restaurante.php'); 
            }
        }
    }

    $consulta = $conexion -> prepare('SELECT * FROM sucursal WHERE idsucursal = ?');
    $consulta -> execute(array($_GET['view']));
    $consulta = $consulta -> fetch(PDO::FETCH_ASSOC);

    $resultados1 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 1 AND idsucursal = ?');
    $resultados1 -> execute(array($_GET['view']));

    $resultados2 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 2 AND idsucursal = ?');
    $resultados2 -> execute(array($_GET['view']));

    $resultados3 = $conexion -> prepare('SELECT disponibilidadtipospedido FROM detalletipospedido WHERE idtipospedido = 3 AND idsucursal = ?');
    $resultados3 -> execute(array($_GET['view']));

    $resultado1 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 1 AND idsucursal = ?');
    $resultado1 -> execute(array($_GET['view']));

    $resultado2 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 2 AND idsucursal = ?');
    $resultado2 -> execute(array($_GET['view']));

    $resultado3 = $conexion -> prepare('SELECT disponibilidadformaspago FROM detalleformaspago WHERE idformaspago = 3 AND idsucursal = ?');
    $resultado3 -> execute(array($_GET['view']));

    if($profileManager == true)  {
        $consultaManager = $conexion -> prepare("SELECT access_id FROM access WHERE state = 1 AND idusuario = ? AND idsucursal = ?");
        $consultaManager -> execute(array($_SESSION['idusuario'], $_GET['view']));
        $consultaManager = $consultaManager -> fetch(PDO::FETCH_ASSOC);

          if($consultaManager == false){

              $profileManager = false;
              
        }
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Restaurante</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../css/panel.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">

            <?php require '../../menu/menupanel.php'; ?>
            
            <div class='formulario-panel container p-0 main-panel m-0 mw-85 w-85'>

                <h1 class='h3 text-center mt-5 font-weight-bold w-100'>INFORMACIÓN DE RESTAURANTE</h1>

                <form action="" class='form-panel mt-5' method ="post">
                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editarnombre'])) { ?>
                                <p>Nuevo nombre: <input value="<?php echo $consulta['nomsucursal']; ?>" type="text" name='res-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Nombre: &nbsp;&nbsp; <?php echo $consulta['nomsucursal'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editarnombre'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editarnombre=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editartelefono'])) { ?>
                                <p>Nuevo telefono: <input value="<?php echo $consulta['telefono']; ?>" type="text" name='tele-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Telefono: &nbsp;&nbsp; <?php echo $consulta['telefono'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editartelefono'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editartelefono=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editarcorreo'])) { ?>
                                <p>Nuevo correo: <input value="<?php echo $consulta['correosucursal']; ?>" type="text" name='email-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Correo: &nbsp;&nbsp; <?php echo $consulta['correosucursal'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editarcorreo'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editarcorreo=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                    
                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editardirec'])) { ?>
                                <p>Nueva direccion: <input value="<?php echo $consulta['direcsucursal']; ?>" type="text" name='dire-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Direccion: &nbsp;&nbsp; <?php echo $consulta['direcsucursal'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editardirec'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editardirec=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editarhorainicio'])) { ?>
                                <p>Nueva hora de inicio de atención: <input value="<?php echo $consulta['horaatencioninicio'] ?>" type="time" name='horai-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Hora inicio de atención: &nbsp;&nbsp; <?php echo $consulta['horaatencioninicio'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editarhorainicio'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editarhorainicio=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante">
                        <div>
                            <?php if (isset($_GET['editarhoracierre'])) { ?>
                                <p>Nueva hora de cierre de atención: <input value="<?php echo $consulta['horaatencioncierre'] ?>" type="time" name = 'horac-actualizada' class='text-center'></p>
                            <?php } else { ?>
                                <p>Hora cierre de atención: &nbsp;&nbsp; <?php echo $consulta['horaatencioncierre'] ?></p>
                            <?php } ?>
                        </div>
                        <div>
                            <?php if (isset($_GET['editarhoracierre'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editarhoracierre=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante-te">
                        <div class="formulario-tipoenvio">
                            <p>Tipo de envio:</p>
                        </div>
                        <div class="formulario-tipoenvio">
                            <?php foreach($resultados1 as $row) { ?>
                                <?php
                                    if($row['disponibilidadtipospedido'] == 1 ){?>
                                        <p class='h3 font-weight-bold w-100'>Delivery</p>
                                        <p><input type="radio" id="" name="delivery" value="1"checked> Habilitar</p>
                                        <p><input type="radio" id="" name="delivery" value="0"> Desabilitar</p><?php
                                    }else{?>
                                        <p class='h3 font-weight-bold w-100'>Delivery</p>
                                        <p><input type="radio" id="" name="delivery" value="1"> Habilitar</p>
                                        <p><input type="radio" id="" name="delivery" value="0"checked> Desabilitar</p><?php
                                    }?>
                            <?php } ?>
                        </div>
                        <div class="formulario-tipoenvio">
                            <?php foreach($resultados2 as $row) { ?>
                                <?php
                                    if($row['disponibilidadtipospedido'] == 1 ){?>
                                        <p class='h3 font-weight-bold w-100'>Recojo</p>
                                        <p><input type="radio" id="" name="recojo" value="1"checked> Habilitar</p>
                                        <p><input type="radio" id="" name="recojo" value="0"> Desabilitar</p><?php
                                    }else{?>
                                        <p class='h3 font-weight-bold w-100'>Recojo</p>
                                        <p><input type="radio" id="" name="recojo" value="1"> Habilitar</p>
                                        <p><input type="radio" id="" name="recojo" value="0"checked> Desabilitar</p><?php
                                    }?>
                            <?php } ?>
                        </div>
                        <div class="formulario-tipoenvio">
                        <?php foreach($resultados3 as $row) { ?>
                            <?php
                                if($row['disponibilidadtipospedido'] == 1 ){?>
                                    <p class='h3 font-weight-bold w-100'>Reserva</p>
                                    <p><input type="radio" id="" name="reserva" value="1"checked> Habilitar</p>
                                    <p><input type="radio" id="" name="reserva" value="0"> Desabilitar</p><?php
                                }else{?>
                                    <p class='h3 font-weight-bold w-100'>Reserva</p>
                                    <p><input type="radio" id="" name="reserva" value="1"> Habilitar</p>
                                    <p><input type="radio" id="" name="reserva" value="0"checked> Desabilitar</p><?php
                                }?>
                        <?php } ?> 
                        </div>
                        <div class="formulario-editar">
                            <?php if (isset($_GET['editartipoenvio'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editartipoenvio=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="formulario-restaurante-te">
                        <div class="formulario-tipoenvio">
                            <p>Formas de pago:</p>
                        </div>
                        <div class="formulario-tipoenvio">
                            <?php foreach($resultado1 as $row) { ?>
                                <?php
                                    if($row['disponibilidadformaspago'] == 1 ){?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>Efectivo</p>
                                        <p><input type="radio" id="" name="forma1" value="1"checked> Habilitar</p>
                                        <p><input type="radio" id="" name="forma1" value="0"> Desabilitar</p><?php
                                    }else{?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>Efectivo</p>
                                        <p><input type="radio" id="" name="forma1" value="1"> Habilitar</p>
                                        <p><input type="radio" id="" name="forma1" value="0"checked> Desabilitar</p><?php
                                    }?>
                            <?php } ?>
                        </div>
                        <div class="formulario-tipoenvio">
                            <?php foreach($resultado2 as $row) { ?>
                                <?php
                                    if($row['disponibilidadformaspago'] == 1 ){?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>Online</p>
                                        <p><input type="radio" id="" name="forma2" value="1"checked> Habilitar</p>
                                        <p><input type="radio" id="" name="forma2" value="0"> Desabilitar</p><?php
                                    }else{?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>Online</p>
                                        <p><input type="radio" id="" name="forma2" value="1"> Habilitar</p>
                                        <p><input type="radio" id="" name="forma2" value="0"checked> Desabilitar</p><?php
                                    }?>
                            <?php } ?>
                        </div>
                        <div class="formulario-tipoenvio">
                            <?php foreach($resultado3 as $row) { ?>
                                <?php
                                    if($row['disponibilidadformaspago'] == 1 ){?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>POS</p>
                                        <p><input type="radio" id="" name="forma3" value="1"checked> Habilitar</p>
                                        <p><input type="radio" id="" name="forma3" value="0"> Desabilitar</p><?php
                                    }else{?>
                                        <p class='h3 mt-5 font-weight-bold w-100'>POS</p>
                                        <p><input type="radio" id="" name="forma3" value="1"> Habilitar</p>
                                        <p><input type="radio" id="" name="forma3" value="0"checked> Desabilitar</p><?php
                                    }?>
                            <?php } ?> 
                        </div>
                        <div class="formulario-editar">
                            <?php if (isset($_GET['editartipoenvio'])) { ?>
                                <input type="submit" value="Editar" class="btn btn-primary">
                                <a href="restaurante.php" class="btn btn-danger">Cancelar</a>
                            <?php } else { ?>
                                <a href="restaurante.php?editarformapago=<?php echo $_GET['view']; ?>"><i class="far fa-edit"></i></a>
                            <?php } ?>
                        </div>
                    </div>
                </form>

            </div>

        </div>
    </main>

</body>
</html>
<?php

    }

?>