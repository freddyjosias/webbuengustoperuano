<?php

    require '../conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: ../index.php');
    }

    $resultsOrder = $conexion -> prepare('SELECT nomsucursal, pedidos.state, pedidos_date, pedidos_hour, descripcionformaspago, descripciontipospedido, pedidos_data_buyer FROM sucursal INNER JOIN categoriaproductos ON categoriaproductos.idsucursal = sucursal.idsucursal INNER JOIN productos ON productos.idcategoriaproducto = categoriaproductos.idcategoriaproducto INNER JOIN detallepedido ON detallepedido.idproducto = productos.idproducto INNER JOIN pedidos ON pedidos.idventa = detallepedido.idventa INNER JOIN formaspago ON formaspago.idformaspago = pedidos.idformaspago INNER JOIN tipospedido ON tipospedido.idtipospedido = pedidos.idtipospedido WHERE idusuario = ? AND pedidos.idventa = ?');
    $resultsOrder -> execute(array($_SESSION['idusuario'], $_GET['pedido']));
    $resultsOrder = $resultsOrder -> fetch(PDO::FETCH_ASSOC);

    if (!$resultsOrder) 
    {
        header('Location: mispedidos.php');
    }
    
    $restBlock = $GLOBALS['conexion'] -> prepare('SELECT nomproducto, price, quantity FROM detallepedido INNER JOIN productos ON productos.idproducto = detallepedido.idproducto WHERE idventa = ?');
    $restBlock -> execute(array($_GET['pedido']));
    $restBlock = $restBlock -> fetchAll(PDO::FETCH_ASSOC);

    #var_dump($resultsOrder); die;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Orden #<?php echo $_GET['pedido'] ?></title>
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/formularios.css">

</head>

<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            
            <?php
                require '../menu/menuusuario.php';
            ?>

            <div class='container p-0 main-panel ml-auto mr-0 my-0 mw-f19-85 mw-f18-84 mw-f17-83 mw-f16-82 mw-f15-81 mw-f14-80 mw-100 z-index-auto'>

                <div class="line-top-panel row h-4r m-0 py-0 px-4 justify-content-between align-items-center">
                    <div class='container-button-menu text-white fw-700 fs-30  no-select'> 
                        <i class="fas fa-bars button-show-menu-panel d-f14-none d-inline" role="button"> &nbsp;</i>  
                        MI CUENTA
                    </div>
                </div>

                <div class="row w-f14-80 w-90 m-auto">

                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-my-orders'>ORDEN #<?php echo $_GET['pedido'] ?></h1>

                    <table class="table border border-info border-top-0 border-right-0 border-left-0">
                        <thead class="thead-light">
                            <tr>                   
                                <th scope="col">Producto</th>
                                <th scope="col">Cantidad</th>
                                <th scope="col">Precio Unit.</th>
                                <th scope="col">Precio Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $NproductoT = 0;
                            foreach($restBlock as $llave) 
                            { ?>
                                <tr class="trcarrito">
                                
                                    <td><?php echo $llave['nomproducto'] ?></td>
                                    <td><?php echo $llave['quantity'] ?></td>
                                    <td>S/. <?php echo $llave['price'] ?></td>
                                    <td>S/.<?php 
                                            $Nproducto = $llave['price']*$llave['quantity'];  
                                            echo number_format($Nproducto, 2, '.', ' ');
                                            $NproductoT = $NproductoT + $Nproducto; ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"  class=''>Restautante</th>
                                <th scope="col" class=''>Monto Total 
                                    <?php

                                        if($resultsOrder['state'] == 1)
                                        {
                                            echo 'Pagado';
                                        }
                                        else
                                        {
                                            echo 'a Pagar';
                                        }
                                                                                        
                                    ?>
                                </th>
                                <th scope="col" class=''>Tipo de Pedido</th>
                                <th scope="col" class=''>Forma de Pago</th>
                                <th scope="col" class=''>Estado</th>
                                <th scope="col" class=''>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr class='fw-400'>
                                <th scope="row" class='fw-400'><?php echo $resultsOrder['nomsucursal'] ?></th>
                                <td>S./ <?php echo $NproductoT ?></td>
                                <th scope="row" class='fw-400'><?php echo $resultsOrder['descripciontipospedido'] ?></th>
                                <th scope="row" class='fw-400'><?php echo $resultsOrder['descripcionformaspago'] ?></th>
                                <td>
                                    <?php

                                        if($resultsOrder['state'] == 1)
                                        {
                                            echo 'Pagado';
                                        }
                                        else if($resultsOrder['state'] == 2)
                                        {
                                            echo 'Pagado el 50%';
                                        }
                                        else
                                        {
                                            echo 'No Pagado';
                                        }
                                                                                        
                                    ?>
                                </td>
                                <td><?php echo date("d/m/Y", strtotime($resultsOrder['pedidos_date'])) . ' ' . $resultsOrder['pedidos_hour'] ?></td>
                            </tr>

                        </tbody>
                    </table>
                    
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"  class=''>Descripción del Pedido</th>
                            </tr>
                        </thead>
                        <tbody>

                            <tr>
                                <th scope="row" class='fw-400 lh-25'><?php echo $resultsOrder['pedidos_data_buyer'] ?></th>
                            </tr>

                        </tbody>
                    </table>
                    
                </div>
                

            </div>

        </div>
    </main>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.add.js"></script>
    <script src="../sweetalert/sweetalert210.js"></script>
    <script src="../js/script.js"></script>

</body>
</html>