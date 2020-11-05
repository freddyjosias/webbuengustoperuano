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

    $resultadosR = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE estado = 1');
    $resultadosR -> execute();
    $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);

    if (isset($_POST['email'])) {
        
        $updateProfile = $conexion -> prepare('UPDATE usuario SET id_profile = 2 WHERE emailusuario = ?');
        $updateProfile -> execute(array($_POST['email']));

        $obtenerIdU = $conexion -> prepare('SELECT idusuario FROM usuario WHERE emailusuario = ?');
        $obtenerIdU -> execute(array($_POST['email']));
        $obtenerIdU = $obtenerIdU -> fetchAll(PDO::FETCH_ASSOC);

        $insertAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES(?, ?)');
        $insertAccess -> execute(array($obtenerIdU[0]['idusuario'], $_POST['restaurant']));

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
    <link rel="shorcut icon" href="../../img/favicon.ico">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" href="../../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="../../">Regresar</a></li>
                    <li><a href="listar.php">Encargados</a></li>
                    <li><a href="../restaurantes/listar.php">Restaurantes</a></li>
                </ul>
            </nav>

            <div class='container p-5'>
                
                <h1 class='h3 text-center font-weight-bold'>AÑADIR ENCARGADO</h1>

                
                <?php 
                    if (isset($obtenerIdU)) {

                        foreach($resultadosR as $val) {
                            if ($val['idsucursal'] == $_POST['restaurant']) {
                                $namRestaurant = $val['nomsucursal'];
                            }
                        }

                        ?>

                            <div class='alert alert-success mt-4' role='alert'>
                                El usuario con correo electrónico <strong><?php echo $_POST['email'] ?></strong> se agrego como encargado del restaurante <strong><?php echo $namRestaurant ?></strong> correctamente &nbsp; <i class="far fa-check-circle"></i>
                            </div>

                        <?php
                    }
                ?>

                <form class='mt-4' method='post'>
                    <div class="form-group">
                        <label for="exampleFormControlInput1">Ingrese el email del nuevo encargado:</label>
                        <input type="email" name='email' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleFormControlSelect1">Seleccione de que restaurante sera encargado:</label>
                        <select class="form-control" id="exampleFormControlSelect1" name='restaurant' required>
                        
                            <?php
                                foreach($resultadosR as $val) {
                                    ?> <option value='<?php echo $val['idsucursal'] ?>'> <?php echo $val['nomsucursal'] ?> </option> <?php
                                }
                            ?>

                        </select>
                    </div>
                    
                    <div class='form-group d-flex'>
                        <button class='btn btn-primary ml-auto mt-3'>Añadir</button>
                    </div>

                </form>

            </div>

        </div>
    </main>
    
    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>

</body>
</html>