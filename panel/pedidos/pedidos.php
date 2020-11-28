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
        $nameRest;

        $resultados = $conexion -> prepare($consultaVerificarRestaurante);
        $resultados -> execute();
        $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

        foreach($resultados as $row) {
            if ($row['idsucursal'] ==  $_GET['view']) {
                $idRestaurante = $row['idsucursal'];
                $nameRest = $row['nomsucursal'];
            break;
        }

        if(!isset($idRestaurante))
        {
            header('Location: ../../index.php');
        }
    }

    if($profileManager == true)  
    {
        $consultaManager = $conexion -> prepare("SELECT access_id FROM access WHERE state = 1 AND idusuario = ? AND idsucursal = ?");
        $consultaManager -> execute(array($_SESSION['idusuario'], $_GET['view']));
        $consultaManager = $consultaManager -> fetch(PDO::FETCH_ASSOC);

        if($consultaManager == false)
        {
            header('Location: ../../index.php');
        }
    }
     
    $resultadosText = $conexion -> prepare('SELECT idventa FROM pedidos WHERE idsucursal = ?');
    $resultadosText -> execute(array($_GET['view']));
    $resultadosText = $resultadosText -> fetchAll(PDO::FETCH_ASSOC); 



?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Bienvenida</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/bootstrap.add.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
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

                    <div class='text-white fw-600 fs-22 mr-5 no-select'>  
                        Restaurante: <?php echo $nameRest ?>
                    </div>

                </div>

                <div class="row w-f14-80 w-90 m-auto contenido-listar">
                    
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100 this-is-order'>PEDIDOS</h1>

                    <h5 class='bg-info p-2 text-white fw-600 mb-3 mt-4 w-100'>PEDIDOS SIN ENTREGAR:</h5> 

                    <?php 
                    if($resultadosText) 
                    { 
                    ?>

                    <table class="table">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">First</th>
                        <th scope="col">Last</th>
                        <th scope="col">Handle</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <th scope="row">1</th>
                        <td>Mark</td>
                        <td>Otto</td>
                        <td>@mdo</td>
                        </tr>
                        <tr>
                        <th scope="row">2</th>
                        <td>Jacob</td>
                        <td>Thornton</td>
                        <td>@fat</td>
                        </tr>
                        <tr>
                        <th scope="row">3</th>
                        <td>Larry</td>
                        <td>the Bird</td>
                        <td>@twitter</td>
                        </tr>
                    </tbody>
                    </table>

                    <?php 
                    } 
                    else
                    { 
                    ?>

                        <p class='w-100 text-center'>Usted no tiene pedidos sin entregar</p>

                    <?php 
                    } 
                    ?>

                    <h5 class='bg-info p-2 text-white fw-600 mb-3 mt-4 w-100'>PEDIDOS ENTREGADOS:</h5>

                    <?php 
                    if($resultadosText) 
                    { 
                    ?>

                        

                    <?php 
                    } 
                    else
                    {
                    ?>

                        <p class='w-100 text-center'>Usted no tiene pedidos entregados</p>      

                    <?php 
                    } 
                    ?>

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
