<?php   
     require '../../conexion.php';
     header('Cache-Control: no cache');
     session_cache_limiter('private_no_expire');
     session_start();

     if (!isset($_SESSION['sucursal'])) {
         header('Location: ../../index.php');
     }
 
     if (isset($_SESSION['idusuario'])) {
         if ($_SESSION['profile'] != 2) {
             header('Location: ../../index.php');
         }
     } else {
         header('Location: ../../index.php');
     }


     if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevaimagen']['name']; 
        move_uploaded_file($_FILES['nuevaimagen']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET imgbienvenida = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_SESSION['sucursal'])); 
        
    }


    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE sucursal SET textobienvenida = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['nuevotexto'], $_SESSION['sucursal']));

    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevobanner']['name']; 
        move_uploaded_file($_FILES['nuevobanner']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET banner = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_SESSION['sucursal'])); 
        
    }

    $resultadosText = $conexion -> prepare('SELECT textobienvenida FROM sucursal WHERE idsucursal = ?');
    $resultadosText -> execute(array($_SESSION['sucursal']));
    $resultadosText = $resultadosText -> fetch(PDO::FETCH_ASSOC); 

    $resultadosImg = $conexion -> prepare('SELECT imgbienvenida FROM sucursal WHERE idsucursal = ?');
    $resultadosImg -> execute(array($_SESSION['sucursal']));
    $resultadosImg = $resultadosImg -> fetch(PDO::FETCH_ASSOC);  

    $resultadosBanner= $conexion -> prepare('SELECT banner FROM sucursal WHERE idsucursal = ?');
    $resultadosBanner -> execute(array($_SESSION['sucursal']));
    $resultadosBanner = $resultadosBanner -> fetch(PDO::FETCH_ASSOC);  
    
    $platosdestacados= $conexion -> prepare('SELECT imgdestacado1, imgdestacado2, imgdestacado3 FROM sucursal WHERE idsucursal = ?');
    $platosdestacados -> execute(array($_SESSION['sucursal']));
    $platosdestacados = $platosdestacados -> fetch(PDO::FETCH_ASSOC);  

    $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';

        $platodescatado1;
        $platodescatado2;
        $platodescatado3;

    $resultados = $conexion -> prepare($consultaVerificarRestaurante);
    $resultados -> execute();
    $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

    foreach($resultados as $row) {
     
    
            $platodescatado1 = $row['platodestacado1'];
            $platodescatado2 = $row['platodestacado2'];
            $platodescatado3 = $row['platodestacado3'];

    }


    
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Bienvenida</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
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

            <div class='container p-0 main-panel m-0 mw-85 w-85'>
                <div class="contenido-listar">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100'>BIENVENIDA</h1>
                        <table class="table">
                            <thead class='thead-light'>
                                <tr>                    
                                    <th class="th" scope="col">Imagen</th>
                                    <th class="th text-center" colspan="1">Actualizar</th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <td>  
                                            <div class='text-center mt-5 destacado-panel'>
                                                <?php echo "<img class='h-25r border border-dark' src='../../". $resultadosImg['imgbienvenida'] ."' >" ?>
                                            </div>
                                        </td>
                                        <td class='text-center'><a href="actualizarimg.php"><i class="far fa-edit"></i></a></td>
                                    </tr>
                                </tbody>
                            <thead class='thead-light'>
                                <tr>                    
                                    <th class="th" scope="col">Descripcion</th>
                                    <th class="th text-center" colspan="1"></th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo $resultadosText['textobienvenida'] ?></td>
                                        <td class='text-center'><a href="actualizartexto.php"><i class="far fa-edit"></i></a></td>
                                    </tr>
                                </tbody>
                            <thead class='thead-light'>
                                <tr>                    
                                    <th class="th" scope="col">Banner</th>
                                    <th class="th text-center" colspan="1"></th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <div class='text-center mt-5 banner-panel'>
                                                <?php echo "<img class='h-24r border border-dark' src='../../". $resultadosBanner['banner'] ."' >" ?>
                                            </div>
                                        </td>
                                        <td class='text-center'><a href="actualizarbanner.php"><i class="far fa-edit"></i></a></td>
                                    </tr>
                                </tbody>

                                <thead class='thead-light'>
                                <tr>                    
                                    <th class="th" scope="col">Platos Destacados</th>
                                    <th class="th text-center" colspan="1"></th>
                                </tr>
                            </thead>
                                <tbody>
                                    <tr>
                                        <td>  
                                            <div class='text-center mt-5 destacado-panel'>
                                                
                                                <?php echo "<img class='h-25r border border-dark' src='../../". $platosdestacados['imgdestacado1'] ."' >" ?>
                                                <a href=""><i class="far fa-edit"></i></a>
                                                <h3><?php echo $platodescatado1 ?><a href=""><i class="far fa-edit"></i></a></h3>
                                                <?php echo "<img class='h-25r border border-dark' src='../../". $platosdestacados['imgdestacado2'] ."' >" ?>
                                                <a href=""><i class="far fa-edit"></i></a>
                                                <h3> <?php echo $platodescatado2 ?> <a href=""><i class="far fa-edit"></i></a></h3>
                                                <?php echo "<img class='h-25r border border-dark' src='../../". $platosdestacados['imgdestacado3'] ."' >" ?>
                                                <a href=""><i class="far fa-edit"></i></a>
                                                <h3> <?php echo $platodescatado3 ?> <a href=""><i class="far fa-edit"></i></a></h3>
                                            </div>
                                        </td>
                                        <td class='text-center'></td>
                                    </tr>
                                </tbody>
                        </table>

                </div>


            </div>

        </div>
    </main>

</body>
</html>