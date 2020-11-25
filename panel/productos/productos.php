<?php   
     require '../../conexion.php';

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

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        $agregarproducto = $conexion -> prepare('INSERT INTO productos(idcategoriaproducto,nomproducto,precio,stock) VALUES (?,?,?,?)');
        $agregarproducto -> execute(array($_POST['categoria'], $_POST['nuevo_producto'], floatval($_POST['precio']), $_POST['stock']));

    }

    $consultaProductos = $conexion -> prepare(
        'SELECT p.idproducto, p.idcategoriaproducto, p.nomproducto, p.precio, p.stock, p.estado, c.idsucursal, c.descripcioncategoriaproducto, c.estado
         FROM productos AS p INNER JOIN categoriaproductos AS c ON p.idcategoriaproducto = c.idcategoriaproducto
         WHERE c.idsucursal = ? AND p.estado = 1 AND c.estado = 1'
    );
    $consultaProductos -> execute(array($_GET['view']));
    $consultaProductos = $consultaProductos -> fetchAll(PDO::FETCH_ASSOC);

    $consultaCategorias = $conexion -> prepare(
        'SELECT * FROM categoriaproductos WHERE idsucursal = ? AND estado = 1'
    );
    $consultaCategorias -> execute(array($_GET['view']));
    $consultaCategorias = $consultaCategorias -> fetchAll(PDO::FETCH_ASSOC);

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
    <title>Productos</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.add.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">

            <?php require '../../menu/menupanel.php'; ?>

            <div class='container p-0 main-panel ml-auto mr-0 my-0 mw-f19-85 mw-f18-84 mw-f17-83 mw-f16-82 mw-f15-81 mw-f14-80 mw-100 z-index-auto'>

                <div class="line-top-panel row h-4r m-0 py-0 px-4 justify-content-between align-items-center">
                    <div class='container-button-menu text-white fw-700 fs-30  no-select'> 
                        <i class="fas fa-bars button-show-menu-panel d-f14-none d-inline" role="button"> &nbsp;</i>  
                        ENCARGADO
                    </div>
                </div>

                <div class="row w-f14-80 w-90 m-auto contenido-listar">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100 this-is-products'>PRODUCTOS</h1>

                    <div class="col-12 form-add-manager">

                    <form class='form-panel mt-5' method = "post">
                    <p>Categoria: 
                        <select name="categoria">            
                            <?php foreach($consultaCategorias as $row) { ?>
                                <option value="<?php echo $row['idcategoriaproducto'] ?>"> <?php echo $row['descripcioncategoriaproducto'] ?> </option>
                            <?php } ?>
                        </select>
                    </p>

                    <p>Nuevo Producto: <input type="text" name="nuevo_producto" required></p>  
                    <p>Precio: <input type="number" name="precio" step='0.01' required></p>
                    <p>Stock: <input type="number" name="stock" required></p>
                    
                    <div class='form-group d-flex'>
                        <button type="button" class="cancel-add-manager btn btn-light ml-auto mt-3 mr-3">Cancelar</button>
                        <button class='btn btn-primary mt-3 px-4 fw-600'>Añadir</button>
                    </div>

                </form>

                    </div>

                    <div class="direccion-a">
                        <a class="buttom-add-manager btn btn-primary bottom">Agregar</a>
                    </div>
                    <table class="table mt-4">
                        <thead class='thead-light'>
                            <tr>                    
                                <th class="th" scope="col">Categoria</th>
                                <th class="th" scope="col">Producto</th>
                                <th class="th" scope="col">Precio</th>
                                <th class="th" scope="col">Stock</th>
                                <th class="th text-center" colspan="2">Más</th>
                            </tr>
                        </thead>
                        <?php foreach($consultaProductos as $producto) {?>
                            <tbody>
                                <tr>
                                    <td><?php echo $producto['descripcioncategoriaproducto'] ?></td>
                                    <td><?php echo $producto['nomproducto'] ?></td>
                                    <td><?php echo $producto['precio'] ?></td>
                                    <td><?php echo $producto['stock'] ?></td>
                                    <td class='text-center'><a href="actualizar.php?view=<?php echo $idRestaurante ?>&id=<?php echo $producto['idproducto']; ?>&categoria=<?php echo $producto['idcategoriaproducto']; ?>"><i class="far fa-edit"></i></a></td>
                                    <td class='text-center'><a href="eliminar.php?view=<?php echo $idRestaurante ?>&id=<?php echo $producto['idproducto']; ?>&categoria=<?php echo $producto['idcategoriaproducto']; ?>"><i class="far fa-trash-alt"></i></a></td>
                                </tr>
                            </tbody>
                        <?php } ?>
                    </table>   
                </div>


            </div>

        </div>
    </main>

    <script src="../../js/jquery-3.5.1.min.js"></script>
    <script src="../../js/bootstrap.add.js"></script>
    <script src="../../sweetalert/sweetalert210.js"></script>
    <script src="../../js/script.js"></script>

</body>
</html>
<?php

    }

?>