<?php

    session_start();

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 3) {
            header('Location: ../../index.php');
        }
    } else {
        header('Location: ../../index.php');
    }

    require '../../conexion.php';

    if (isset($_POST['email'])) {
        
        $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 3 WHERE emailusuario = ?');
        $updateProfile -> execute(array($_POST['email']));


        $insetadoExito = true;

    }

?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Encargado</title>
    <link rel="shorcut icon" href="../../img/logo-icono.png">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/bootstrap.add.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">

</head>
<body>

    <main>
    <div class="container-fluid panel-control mw-1920p p-0">
            
            <?php
                require '../../menu/menupaneladmin.php';
            ?>

            

            <div class='container p-0 main-panel m-0 mw-85 w-85'>

                <div class="line-top-panel row h-4r">
                    
                </div>
                
                <div class="row w-80 m-auto">
                <h1 class='h3 text-center mt-5 font-weight-bold w-100'>AÑADIR ADMINISTRADOR</h1>

                <form class='text-center w-100 mt-4' method='post'>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Ingrese el email del nuevo administrador:</label>
                        <input type="email" name='email' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                    </div>                
                    <div class='form-group d-flex'>
                        <button class='btn btn-primary ml-auto mt-3'>Añadir</button>
                    </div>

                </form>

            </div>

        </div>

        </div>
    </main>
    
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>

</body>
</html>