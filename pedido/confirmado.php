<?php
    
    session_start();

    if (!isset($_SESSION['idusuario']) || !isset($_POST['email']))
    {
        header('Location: ../');
    }

    $restDetail = $_SESSION['restdata'];
    #unset($_SESSION['restdata']);
    #var_dump( $restDetail);
    #var_dump($_POST); die;

    require '../conexion.php';

    date_default_timezone_set('America/Lima');

    $countRest = count($restDetail[0]);
    for($i = 0; $i < $countRest; $i++)
    {

        if($restDetail[1][$i] == 2)
        {
            $stateBuy = 2;
        } 
        else if($restDetail[2][$i] == 3)
        {
            $stateBuy = 1;
        }
        else
        {
            $stateBuy = 0;
        }

        $dataBuyer = '<strong>Nombres:</strong> ' .  $_POST['nombre'] . ' ' . $_POST['apellido'] . '<br><strong>Correo:</strong> ' .  $_POST['email'] . '<br><strong>DNI:</strong> ' .  $_POST['dni'] . '<br><strong>Celular:</strong> ' .  $_POST['telefono'] . '<br><strong>Dirección:</strong> ' .  $_POST['direccion'] . '<br><strong>Referencia:</strong> ' .  $_POST['referencia'];
        
        $queryOrder = $conexion -> prepare("INSERT INTO pedidos(idformaspago, idtipospedido, idusuario, pedidos_hour, pedidos_date, pedidos_data_buyer, state) VALUES(?, ?, ?, ?, ?, ?, ?)");
        $queryOrder -> execute(array($restDetail[2][$i], $restDetail[1][$i], $_SESSION['idusuario'], date('H:i:s'), date('Y-m-d'), $dataBuyer, $stateBuy));

        $lastID = $conexion -> prepare('SELECT LAST_INSERT_ID() as last_insert_id FROM pedidos');
        $lastID -> execute();
        $lastID = $lastID -> fetch(PDO::FETCH_ASSOC);

        $products = $conexion -> prepare('SELECT shop_car.idproducto, shop_car.quantity, stock, precio FROM sucursal INNER JOIN categoriaproductos ON categoriaproductos.idsucursal = sucursal.idsucursal INNER JOIN productos ON productos.idcategoriaproducto = categoriaproductos.idcategoriaproducto INNER JOIN shop_car ON shop_car.idproducto = productos.idproducto WHERE sucursal.estado = 1 AND productos.estado = 1 AND stock > 0 AND categoriaproductos.estado = 1 AND sucursal.idsucursal = ? AND idusuario = ?');
        $products -> execute(array($restDetail[0][$i], $_SESSION['idusuario']));
        $products = $products -> fetchAll(PDO::FETCH_ASSOC);

        foreach($products as $key)
        {
            $createProdOrder = $conexion -> prepare("INSERT INTO detallepedido VALUES(?, ?, ?, ?)");
            $createProdOrder -> execute(array($lastID['last_insert_id'], $key['idproducto'], $key['quantity'], $key['precio']));

            if($key['quantity'] > $key['stock'])
            {
                $key['quantity'] = $key['stock'];
            }

            $createProdOrder = $conexion -> prepare("UPDATE productos SET stock = ? WHERE idproducto = ?");
            $createProdOrder -> execute(array(($key['stock'] - $key['quantity']), $key['idproducto']));

        }
        
    }

    $deleteShopCart = $conexion -> prepare("DELETE FROM shop_car WHERE idusuario = ?");
    $deleteShopCart -> execute(array($_SESSION['idusuario']));

?>

<!DOCTYPE html>
<html>
<head>
	<title>Pedido Confirmado | Buen Gusto Peruano</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
	<link rel="stylesheet" type="text/css" href="../css/estilos.css">
</head>
<body class='bg-light'>
                            
    <header class="header-inicio ">

        <div class="contenedor-general contenido-header-inicio row">

            <div class="contenedor-img col-6 m-0 px-0 py-3 h-4r d-flex">
                <img src="../img/logo-icon-512-color.png" class="h-100">
                <img src="../img/logo-text-1024-white.png" class="h-100 ml-3 d-none d-sm-block">
                <img src="../img/logo-text-1024-white-min.png" class="h-100 ml-3 d-block d-sm-none">
            </div>

            <div class="cerrar-sesion text-right col-6 m-0 p-0 ">
                <div class="container h-100 align-items-center d-flex p-0">

                    <a class='text-white d-flex h3 ml-auto sm-h2  mb-0' title='Información de la cuenta' href="#">
                        <img src="<?php echo $_SESSION['photo'] ?>" alt="" class='border rounded-circle photo-user-home'>
                    </a>
                    
                </div>
            </div>

        </div>

    </header>

    <div class="contenedor-general bg-white my-5">

        <p class='text-center text-success fs-10r mb-0 pb-0'><i class="far fa-check-circle"></i></p>
        <h1 class='text-center fw-700 fs-3r mt-0 pt-0'>PEDIDO COMPLETADO CON ÉXITO</h1>

        <p class='text-center'><a href="../cuenta/mispedidos.php" class='btn btn-success fs-19 mb-5'>Ver mis pedidos</a></p>

    </div>


</body>
</html>