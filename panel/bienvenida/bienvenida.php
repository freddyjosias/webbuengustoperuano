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
     }
     
     if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevaimagen']['name']; 
        move_uploaded_file($_FILES['nuevaimagen']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET imgbienvenida = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_GET['view'])); 
        
    }
    

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        
        $resultados = $conexion -> prepare('UPDATE sucursal SET textobienvenida = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['nuevotexto'], $_GET['view']));

    }
    
    if($_SERVER["REQUEST_METHOD"] == "POST"){

        $ruta = 'img/'.$_FILES['nuevobanner']['name']; 
        move_uploaded_file($_FILES['nuevobanner']['tmp_name'], "../../".$ruta);

        $query = $conexion->prepare("UPDATE sucursal SET banner = ? WHERE idsucursal = ?");
        $resultado = $query->execute(array($ruta, $_GET['view'])); 
        
    }
    
    $resultadosText = $conexion -> prepare('SELECT textobienvenida FROM sucursal WHERE idsucursal = ?');
    $resultadosText -> execute(array($_GET['view']));
    $resultadosText = $resultadosText -> fetch(PDO::FETCH_ASSOC); 

    $resultadosImg = $conexion -> prepare('SELECT imgbienvenida FROM sucursal WHERE idsucursal = ?');
    $resultadosImg -> execute(array($_GET['view']));
    $resultadosImg = $resultadosImg -> fetch(PDO::FETCH_ASSOC);  

    $resultadosBanner= $conexion -> prepare('SELECT banner FROM sucursal WHERE idsucursal = ?');
    $resultadosBanner -> execute(array($_GET['view']));
    $resultadosBanner = $resultadosBanner -> fetch(PDO::FETCH_ASSOC);  
    
    $platosdestacados= $conexion -> prepare('SELECT imgdestacado1, imgdestacado2, imgdestacado3 FROM sucursal WHERE idsucursal = ?');
    $platosdestacados -> execute(array($_GET['view']));
    $platosdestacados = $platosdestacados -> fetch(PDO::FETCH_ASSOC);  

    $resultadosEn = $conexion -> prepare('SELECT * FROM sucursal WHERE idsucursal = ?');
    $resultadosEn -> execute(array($_GET['view']));
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

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
                                        <th class="th" scope="col">Descripcion</th>
                                        <th class="th text-center" colspan="1"></th>
                                    </tr>
                                </thead>
                        
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100'></h1>

                    <table class="table mt-4">
                    <thead class='thead-light letra-panel'>
                        <tr>
                            <th scope="col" class='text-center'><p>N°</p></th>
                            <th scope="col"><p>Imágen</p></th>
                            <th class='text-center' scope="col"><p>Actualizar</p></th>
                            <th scope="col"><p>Texto</p></th>
                            <th class='text-center' scope="col"><p>Actualizar</p></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>1</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado1'] ?>" alt=""></td>
                                <td class='text-center'><a href="actualizar4.php"><i class="far fa-edit"></i></a></td>
                                <td><?php echo $val['platodestacado1'] ?></td>
                                <td class='text-center'><a href="actualizar1.php"><i class="far fa-edit"></i></a></td>
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>2</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado2'] ?>" alt=""></td>
                                <td class='text-center'><a href="actualizar5.php"><i class="far fa-edit"></i></a></td>
                                <td><?php echo $val['platodestacado2'] ?></td>
                                <td class='text-center'><a href="actualizar2.php"><i class="far fa-edit"></i></a></td>                            
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>3</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado3'] ?>" alt=""></td>
                                <td class='text-center'><a href="actualizar6.php"><i class="far fa-edit"></i></a></td>
                                <td><?php echo $val['platodestacado3'] ?></td>
                                <td class='text-center'><a href="actualizar3.php"><i class="far fa-edit"></i></a></td>
                            <?php } ?>
                            </tr>

                    </tbody>
                    </table>
                </div>
            
                                </tbody>
                        </table>

                </div>


            </div>

        </div>
    </main>

</body>
</html>
