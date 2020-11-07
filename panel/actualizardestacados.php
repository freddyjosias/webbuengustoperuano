<?php

    require '../conexion.php';

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: index.php');
        }
    } else {
        header('Location: index.php');
    }

    if($_SERVER["REQUEST_METHOD"] == "POST") {

        //Plato destacado 1:
        if(isset($_FILES['imagendestacada1']['name']) && isset($_POST['descripcion1'])) {
            $ruta1 = 'img/'.$_FILES['imagendestacada1']['name']; 
            move_uploaded_file($_FILES['imagendestacada1']['tmp_name'], "../".$ruta1);

            $query1 = $conexion->prepare("UPDATE sucursal SET imgdestacado1 = ? AND platodestacado1 = ? WHERE idsucursal = ?");
            $resultado1 = $query1->execute(array($ruta1,$_POST['descripcion1'] , $_SESSION['sucursal']));
             
        } 
        
        if(isset($_FILES['imagendestacada1']['name']) && $_POST['descripcion1']==""){
            $ruta2 = 'img/'.$_FILES['imagendestacada1']['name']; 
            move_uploaded_file($_FILES['imagendestacada1']['tmp_name'], "../".$ruta2);

            $query2 = $conexion->prepare("UPDATE sucursal SET imgdestacado1 = ? WHERE idsucursal = ?");
            $resultado2 = $query2->execute(array($ruta2, $_SESSION['sucursal']));
        } 
        
        if(isset($_POST['descripcion1']) && $_FILES['imagendestacada1']['name']==""){
            $query3 = $conexion->prepare("UPDATE sucursal SET platodestacado1 = ? WHERE idsucursal = ?");
            $resultado3 = $query3->execute(array($_POST['descripcion1'], $_SESSION['sucursal']));

        }   

        //Plato destacado 2:
        if(isset($_FILES['imagendestacada2']['name']) && isset($_POST['descripcion2'])) {
            $ruta4 = 'img/'.$_FILES['imagendestacada2']['name']; 
            move_uploaded_file($_FILES['imagendestacada2']['tmp_name'], "../".$ruta4);

            $query4 = $conexion->prepare("UPDATE sucursal SET imgdestacado2 = ? AND platodestacado2 = ? WHERE idsucursal = ?");
            $resultado4 = $query4->execute(array($ruta4,$_POST['descripcion2'] , $_SESSION['sucursal']));  
        } 

        if(isset($_FILES['imagendestacada2']['name']) && $_POST['descripcion2']==""){
            $ruta5 = 'img/'.$_FILES['imagendestacada2']['name']; 
            move_uploaded_file($_FILES['imagendestacada2']['tmp_name'], "../".$ruta5);

            $query5 = $conexion->prepare("UPDATE sucursal SET imgdestacado2 = ? WHERE idsucursal = ?");
            $resultado5 = $query5->execute(array($ruta5, $_SESSION['sucursal']));
        } 

        if(isset($_POST['descripcion2']) && $_FILES['imagendestacada2']['name']=="") {
            $query6 = $conexion->prepare("UPDATE sucursal SET platodestacado2 = ? WHERE idsucursal = ?");
            $resultado6 = $query6->execute(array($_POST['descripcion2'], $_SESSION['sucursal']));
        }   

        //Plato destacado 3:
        if(isset($_FILES['imagendestacada3']['name']) && isset($_POST['descripcion3'])) {
            $ruta7 = 'img/'.$_FILES['imagendestacada3']['name']; 
            move_uploaded_file($_FILES['imagendestacada3']['tmp_name'], "../".$ruta7);

            $query7 = $conexion->prepare("UPDATE sucursal SET imgdestacado3 = ? AND platodestacado3 = ? WHERE idsucursal = ?");
            $resultado7 = $query7->execute(array($ruta7,$_POST['descripcion3'] , $_SESSION['sucursal']));  
        } 

        if(isset($_FILES['imagendestacada3']['name']) && $_POST['descripcion3']==""){
            $ruta8 = 'img/'.$_FILES['imagendestacada3']['name']; 
            move_uploaded_file($_FILES['imagendestacada3']['tmp_name'], "../".$ruta8);

            $query8 = $conexion->prepare("UPDATE sucursal SET imgdestacado3 = ? WHERE idsucursal = ?");
            $resultado8 = $query8->execute(array($ruta8, $_SESSION['sucursal']));
        } 

        if(isset($_POST['descripcion3']) && $_FILES['imagendestacada3']['name']=="") {
            $query9 = $conexion->prepare("UPDATE sucursal SET platodestacado3 = ? WHERE idsucursal = ?");
            $resultado9 = $query9->execute(array($_POST['descripcion3'], $_SESSION['sucursal']));
        }   
    }
        
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Actualizar Platos Destacados</title>
    <link rel="shorcut icon" href="../img/favicon.png">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/responpanel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">

            <?php require '../menu/menupanel.php'; ?>

            <div class='formulario-panel'>

                <h1>Actualizar Platos Destacados: </h1>

                <form action="" class='form-panel' method="post" enctype="multipart/form-data">

                    <p>Nueva Imagen Destacada 1: </p>       
                    <input type="file" name="imagendestacada1">
                    <p>Nueva descripción: <input type="text" name="descripcion1"></p>
                    
                    <p>Nueva Imagen Destacada 2: </p>       
                    <input type="file" name="imagendestacada2">
                    <p>Nueva descripción: <input type="text" name="descripcion2"></p>
                    

                    <p>Nueva Imagen Destacada 3: </p>              
                    <input type="file" name="imagendestacada3">
                    <p>Nueva descripción: <input type="text" name="descripcion3"></p><br>
                    
                    <input type="submit" value="Actualizar Platos Destacados">

                </form>

            </div>

        </div>
    </main>

</body>
</html>

