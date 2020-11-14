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

    $consultaCategorias = $conexion -> prepare('SELECT idcategoriaproducto, idsucursal, descripcioncategoriaproducto FROM categoriaproductos WHERE idsucursal = ?');
    $consultaCategorias -> execute(array($_GET['view']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);
    

    if (isset($_GET['categoria'])) {
        $consultaCategoria = $conexion -> prepare('SELECT * FROM categoriaproductos WHERE idcategoriaproducto = ?');
        $consultaCategoria -> execute(array($_GET['categoria']));
        $consultaCategoria = $consultaCategoria -> fetch(PDO::FETCH_ASSOC);
    }

    if (isset($_GET['id'])) {
        $consultaProductoA = $conexion -> prepare('SELECT*FROM productos WHERE idproducto = ?');
        $consultaProductoA -> execute(array($_GET['id']));
        $consultaProductoA = $consultaProductoA -> fetch(PDO::FETCH_ASSOC);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE productos SET nomproducto = ?, precio = ?, stock = ? WHERE idproducto = ?');
        $resultados -> execute(array($_POST['nuevonombre'],$_POST['nuevoprecio'],$_POST['nuevostock'], $_GET['id']));

        if ($resultados) {
            header("Location: listar.php?view=".$_GET['view']);
        }

    }

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
    <title>Actualizar Producto</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
</head>
<body>

    <main>
    <div class="container-fluid panel-control mw-1920p p-0">

        <?php require '../../menu/menupanel.php'; ?>

        <div class='formulario-panel container p-0 main-panel m-0 mw-85 w-85'>

            <h1 class='h3 text-center mt-5 font-weight-bold w-100'>Actualizar Producto</h1>

                <form action="" method="get"  class='form-panel'>
                    <p>Categoria Escogida: 
                        <?php echo $consultaCategoria['descripcioncategoriaproducto']; ?>
                    </p>
                </form>
                
                <?php if(isset($_GET['categoria']))   {    ?>       
                <form  action="" method="get"  class='form-panel'>

                    <input type="number" name="categoria" id="cate-edit-pro" value="<?php echo $_GET['categoria'] ?>">

                    <p>Producto Elegido:  
                        <?php echo $consultaProductoA['nomproducto']; ?>
                    </p>
                </form>

                <?php }  ?>                     
                <?php if(isset($_GET['categoria']) && isset($_GET['id'])) { ?>         
                    <form action="" class='form-panel' method = "post">
                        <p>Nuevo nombre: <input value="<?php echo $consultaProductoA['nomproducto'] ?>" type="text" name="nuevonombre" required></p>  
                        
                        <p>Precio: <?php echo $consultaProductoA['precio'] ?></p>
                        <p>Nuevo precio: <input value="<?php echo $consultaProductoA['precio'] ?>" type="number" name="nuevoprecio" step='0.01' required></p>

                        <p>Stock: <?php echo $consultaProductoA['stock'] ?></p>
                        <p>Nuevo Stock: <input value="<?php echo $consultaProductoA['stock'] ?>" type="number" name="nuevostock" required></p>
                        
                        <input class="btn btn-secondary bottom" type="submit" value="Actualizar Producto">
                    </form>
                <?php } ?>     

            </div>

        </div>
    </main>
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>
</body>
</html>
<?php

    }

?>