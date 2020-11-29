<?php

    require '../conexion.php';

    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: ../index.php');
    }

    $resultsOrders = $conexion -> prepare('SELECT detallepedido.idproducto, detallepedido.quantity, finished, pedidos.idventa, nomsucursal FROM sucursal INNER JOIN categoriaproductos ON categoriaproductos.idsucursal = sucursal.idsucursal INNER JOIN productos ON productos.idcategoriaproducto = categoriaproductos.idcategoriaproducto INNER JOIN detallepedido ON detallepedido.idproducto = productos.idproducto INNER JOIN pedidos ON pedidos.idventa = detallepedido.idventa WHERE idusuario = ? GROUP BY idventa ORDER BY finished, pedidos_date DESC, pedidos_hour DESC');
    $resultsOrders -> execute(array($_SESSION['idusuario']));
    $resultsOrders = $resultsOrders -> fetchAll(PDO::FETCH_ASSOC);

    if(isset($resultsOrders[0]))
    {
        $resultsProd = $conexion -> prepare('SELECT nomproducto, pedidos.idventa FROM productos INNER JOIN detallepedido ON detallepedido.idproducto = productos.idproducto INNER JOIN pedidos ON pedidos.idventa = detallepedido.idventa WHERE idusuario = ? GROUP BY productos.idproducto ORDER BY finished, pedidos_date DESC, pedidos_hour DESC');
        $resultsProd -> execute(array($_SESSION['idusuario']));
        $resultsProd = $resultsProd -> fetchAll(PDO::FETCH_ASSOC);

        if($resultsOrders[0]['finished'] == 0)
        {
            $orderNoFinish = true;
        }
        else
        {
            $orderNoFinish = false;
        }

        if($resultsOrders[count($resultsOrders) - 1]['finished'] == 1)
        {
            $orderFinish = true;
        }
        else
        {
            $orderFinish = false;
        }
    }
    

   #var_dump($resultsProd); die;
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Mis Pedidos</title>
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

                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-my-orders'>MIS PEDIDOS</h1>

                    <h5 class='bg-info p-2 text-white fw-600 mb-3 mt-4 w-100'>PEDIDOS NUEVOS:</h5> 

                    <?php 
                    if(!$orderNoFinish) 
                    { 
                    ?>

                        <p class='w-100 text-center'>Usted no tiene pedidos nuevos</p>

                    <?php 
                    }
                    else 
                    { 
                    ?>

                        <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col"  class='w-1r text-center'>N°</th>
                                <th scope="col" class='w-auto'>Descripción</th>
                                <th scope="col" class=''>Restaurante</th>
                                <th scope="col" class='w-10r'>Más</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $k = 0;
                            $countOrders = count($resultsOrders);
                            for($i = 0; $i < $countOrders && $resultsOrders[$i]['finished'] == 0; $i++)
                            {
                            ?>
                                <tr>
                                
                                    <th scope="row" class='w-1r text-center'><?php echo ($i + 1) ?></th>

                                    <td class='w-auto'>
                                    
                                        <?php 
                                            
                                            echo 'Orden #' . $resultsOrders[$i]['idventa'] . ' - ';
                                            
                                            $countW = 0; 
                                            while ($resultsProd[$k]['idventa'] == $resultsOrders[$i]['idventa']) 
                                            {
                                                $countW++;
                                                if($countW == 4)
                                                {
                                                    echo 'etc.';
                                                }
                                                if($countW < 4)
                                                {
                                                    echo $resultsProd[$k]['nomproducto'];
                                                }
                                                $k++;

                                                if($countW < 4)
                                                {
                                                    if(isset($resultsProd[$k]['idventa']))
                                                    {
                                                        if($resultsProd[$k]['idventa'] == $resultsOrders[$i]['idventa'])
                                                        {
                                                            echo ', ';
                                                        }
                                                        else
                                                        {
                                                            echo '.';
                                                        }
                                                    }
                                                    else
                                                    {
                                                        echo '.';
                                                        break;
                                                    }
                                                }
                                            }
                                        
                                        ?>

                                    </td>

                                    <td class=''><?php echo $resultsOrders[$i]['nomsucursal'] ?></td>

                                    <td class='py-2 w-10r'><a href="pedido.php?pedido=<?php echo $resultsOrders[$i]['idventa'] ?>" class='btn btn-primary my-0 py-1'>Ver Pedido</a></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </tbody>
                        </table>

                    <?php 
                    }
                    ?>

                    <h5 class='bg-info p-2 text-white fw-600 mb-3 mt-4 w-100'>PEDIDOS COMPLETADOS:</h5>

                    <?php 
                    if(!$orderFinish) 
                    { 
                    ?>

                        <p class='w-100 text-center'>Usted no tiene pedidos completados</p>

                    <?php 
                    }
                    else 
                    { 
                    ?>

                    <?php 
                    }
                    ?>                    
                    
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