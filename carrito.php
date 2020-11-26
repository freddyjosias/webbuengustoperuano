
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
}

$consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE idsucursal = ?';
        

        $idRestaurante;
        $bannerSucursal;
        $nombresucursal;
    

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute(array($_GET['view']));
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);
        foreach($resultados as $row) {
           
                $idRestaurante = $row['idsucursal'];
                $bannerSucursal = $row['banner'];
                $nombresucursal = $row['nomsucursal'];
                break;     
        }
        
        $cont = 0;
        $NproductoT = 0;

        $consultaCar = $conexion -> prepare('SELECT p.idproducto, quantity, nomproducto, precio, nomsucursal, r.idsucursal FROM shop_car AS s INNER JOIN productos AS p ON s.idproducto = p.idproducto INNER JOIN categoriaproductos AS c ON c.idcategoriaproducto = p.idcategoriaproducto INNER JOIN sucursal AS r ON r.idsucursal = c.idsucursal WHERE s.idusuario = ? AND p.estado = 1 ORDER BY nomsucursal, nomproducto');
        $consultaCar -> execute(array($_SESSION['idusuario']));
        $consultaCar = $consultaCar -> fetchAll(PDO::FETCH_ASSOC);

        if ($consultaCar) 
        {
            $cont++;
            $restaurants = array(0 => array(), 1 => array());
            $countArrayRest = 0;
            $pricheRest = array(0 => array(), 1 => array());

            foreach($consultaCar as $producto)
            {
                if (isset($restaurants[0][0])) 
                {
                    if ($restaurants[0][$countArrayRest - 1] != $producto['idsucursal']) 
                    {
                        $restaurants[0][$countArrayRest] = $producto['idsucursal'];
                        $restaurants[1][$countArrayRest] = $producto['nomsucursal'];
                        $pricheRest[0][$countArrayRest] = $producto['idsucursal'];
                        $pricheRest[1][$countArrayRest] = ($producto['precio'] * $producto['quantity']);
                        $countArrayRest++;
                    }
                    else
                    {
                        $pricheRest[1][$countArrayRest - 1] =  ($producto['precio'] * $producto['quantity']) + $pricheRest[1][$countArrayRest - 1];
                    }
                }
                else
                {
                    $restaurants[0][0] = $producto['idsucursal'];
                    $restaurants[1][0] = $producto['nomsucursal'];
                    $pricheRest[0][0] = $producto['idsucursal'];
                    $pricheRest[1][0] =  ($producto['precio'] * $producto['quantity']);
                    $countArrayRest++;
                }
            }

            for($i = 0; $i < $countArrayRest; $i++) 
            {
                $consultatipospedidos = $conexion -> prepare("SELECT t.idtipospedido, t.descripciontipospedido, d.idsucursal FROM tipospedido AS t INNER JOIN detalletipospedido AS d ON t.idtipospedido = d.idtipospedido 
                WHERE d.idsucursal = ? AND d.disponibilidadtipospedido = 1"
                );
                $consultatipospedidos -> execute(array($restaurants[0][$i]));
                $consultatipospedidos = $consultatipospedidos -> fetchAll(PDO::FETCH_ASSOC);

                $consultaformaspago = $conexion -> prepare("SELECT f.idformaspago, f.descripcionformaspago, d.idsucursal FROM formaspago AS f INNER JOIN detalleformaspago AS d ON f.idformaspago = d.idformaspago WHERE d.idsucursal = ? AND d.disponibilidadformaspago = 1");
                $consultaformaspago -> execute(array($restaurants[0][$i]));
                $consultaformaspago = $consultaformaspago -> fetchAll(PDO::FETCH_ASSOC);

                $restaurants[0][$i] = array(0 => $consultatipospedidos, 1 => $consultaformaspago);
            }
        }
        #var_dump($restaurants[0][0][0]); die;
        if (!isset($idRestaurante)) {
            header('Location: index.php');
        } else {
            
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
	<title>El Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Carrito | <?php echo $nombreRestaurante ?></title>
    <link rel="shorcut icon" href="img/logo-icono.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/estilos.css">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" href="css/carrito.css">
<body>

    <div class='logo-icono d-none d-md-block'>
        <a href="index.php"><img src="img/logo-icon-512-color.png" alt=""></a>
    </div>

    <div class='logo-icono right-2p d-none d-md-block'>
        <a href="cuenta/index.php"><img src="<?php echo $_SESSION['photo'] ?>" class='border rounded-circle' alt=""></a>
    </div>

    <header class="header-restaurante">
        <div>
            <?php echo "<img src='".$bannerSucursal."' >" ?>
        </div>
        
        <?php require 'menu/menurestaurants.php'; ?>

    </header>
    <main class="carro">
        <main class="contenedor-carrito">
  
                <section class="carrito-carrito"> 

                <div class="bgp">

                    <h1 class='h2 text-uppercase  fw-600imp'> Carrito </h1>

                </div>

                <div class="text-carrito fw-500">
                        <ul>
                            <li>Antes de hacer algún pedido, deberás actualizar tus datos &nbsp; <a href="cuenta/micuenta.php" class="badge badge-info text-white">Actualizar Datos</a></li>			
                        </ul>
                </div>

                    <div class="carrito">
                                <table class="table">
                                    <thead class="thead-light">
                                    <?php
                                    if($cont != 0){ ?>
                                        <tr>                   
                                            <th scope="col">Producto</th>
                                            <th scope="col">Cantidad</th>
                                            <th scope="col">Precio Unit.</th>
                                            <th scope="col">Precio Total</th>
                                            <th scope="col">Restaurante</th>
                                            <th scope="col">Más</th>
                                        </tr>
                                    <?php } ?>
                                    </thead>
                                    <?php
                                    if($cont == 0){ ?>
                                    <tbody>
                                        <img class="car-no-item mt-4" src="img/car-no-item.png" alt="">
                                        <h4 class="no-item-font mt-3">No hay productos en tu carrito</h4>
                                        <a href="hacerpedido.php?view=<?php echo $idRestaurante ?>"><button type="button" class="btn btn-primary mt-3 fw-600imp">Seguir Comprando</button></a>
                                    </tbody>
                                   <?php }  else{                                   
                                    foreach($consultaCar as $producto) 
                                    { ?>
                                        <tbody>
                                            <tr class="trcarrito">
                                                    <td><?php echo $producto['nomproducto'] ?></td>
                                                    <td><?php echo $producto['quantity'] ?></td>
                                                    <td>S/. <?php echo $producto['precio'] ?></td>
                                                    <td>S/.<?php 
                                                            $Nproducto = $producto['precio']*$producto['quantity'];  
                                                            echo number_format($Nproducto, 2, '.', ' ');
                                                            $NproductoT = $NproductoT + $Nproducto; ?>
                                                    </td>

                                                    <td><?php echo $producto['nomsucursal'] ?></td>

                                                    <td class='text-center px-0 py-2'>
                                                        <a class="btn btn-danger" href="eliminarcarrito.php?id=<?php echo $producto['idproducto']; ?>&view=<?php echo $_GET['view'] ?>">
                                                            <i class="far fa-trash-alt "></i> &nbsp; Eliminar 
                                                        </a>
                                                    </td>
                                            </tr>
                                        </tbody>
                                    <?php } } ?>
                                    <?php
                                    if($cont != 0){ ?>
                                    <thead>
                                        <tr>                   
                                            <th style="visibility: hidden"> Prueba</th>
                                            <th style="visibility: hidden">Prueba</th>
                                            <th style="visibility: hidden">Prueba</th>
                                            <th>Monto Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <td style="visibility: hidden"></td>
                                    <td style="visibility: hidden"></td>
                                    <td style="visibility: hidden"></td>
                                    <td>S/.<?php
                                            echo number_format($NproductoT, 2, '.', ' '); ?></td>
                                    </tbody>
                                    <?php } ?>
                                </table>

                                <?php if($cont != 0){ ?>
                                
                                    <form action="pedido/continuarpedido.php" method='post'>
                                    
                                        <?php for($i = 0; $i < $countArrayRest; $i++) 
                                        { ?>
                                            <h1 class='h2 text-left w-70 mb-4 mx-auto fw-600imp'>Restaurante: <?php echo $restaurants[1][$i] ?> <span class='h6'>(Total a pagar: S/. <?php echo $pricheRest[1][$i] ?> )</span></h1>

                                            <div class="contenedor-pedidos">
                                                <div class="btn-group-vertical direccion-tipos">
                                                    <p>Tipos de pedido:</p>
                                                        <select class="carrtio-pedidopago" name="tipopedido<?php echo $i ?>">
                                                            <?php foreach ($restaurants[0][$i][0] as $tipopedido) { ?>
                                                                <option value="<?php echo $tipopedido['idtipospedido'] ?>"><?php echo $tipopedido['descripciontipospedido'] ?></option>
                                                            <?php }  ?>
                                                        </select>
                                                </div>
                                                <div class="btn-group-vertical direccion-tipos">
                                                    <p>Forma de Pago:</p>
                                                        <select class="carrtio-pedidopago" name="formapago<?php echo $i ?>">
                                                            <?php foreach ($restaurants[0][$i][1] as $formaspago) { ?>
                                                                <option value="<?php echo $formaspago['idformaspago'] ?>"><?php echo $formaspago['descripcionformaspago'] ?></option>
                                                            <?php }  ?>
                                                        </select>
                                                </div>
                                            </div>

                                            <br>
                                            <br>

                                        <?php } ?>  
                                        
                                        <p>Pedido con la seguridad que nos caracteriza.</p>
                                        <button type="submit" class="btn btn-primary">Continuar</button>

                                    </form>

                                <?php } ?>
                                
                    </div> 
                </section>
        </main>
    </main>
                <footer class="footer-inicio">
                    <div class= "contenedor-general">
                        <div>© 2020 El Buen Gusto Peruano SAC. Todos los derechos reservados</div>
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

?>