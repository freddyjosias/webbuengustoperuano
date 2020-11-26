<?php
    
    session_start();
    #var_dump($_POST); die;
    if (!isset($_SESSION['idusuario']) || !isset($_POST['rest0'])) 
    {
        header('Location: ../');
    }

    require '../conexion.php';

    $consultaUsuario = $conexion -> prepare('SELECT emailusuario, nombreusuario, apellidousuario, dniusuario, photo, direccionusuario, referenciausuario, telefonousuario FROM usuario WHERE idusuario = ?');
    $consultaUsuario -> execute(array($_SESSION['idusuario']));
    $consultaUsuario = $consultaUsuario -> fetch(PDO::FETCH_ASSOC);

    $i = 0;
    $restDetail = array(0 => array(), 1 => array(), 2 => array());

    while(isset($_POST['rest' . $i]))
    {
        $restDetail[0][$i] = $_POST['rest' . $i];
        $restDetail[1][$i] = $_POST['tipopedido' . $i];
        $restDetail[2][$i] = $_POST['formapago' . $i];
        $i++;
    }

    function resultRest($key)
    {
        $result = $GLOBALS['conexion'] -> prepare('SELECT nomsucursal FROM sucursal WHERE sucursal.estado = 1 AND sucursal.idsucursal = ?');
        $result -> execute(array($key));
        $result = $result -> fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

?>

<!DOCTYPE html>
<html>
<head>
	<title>Buen Gusto Peruano</title>
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

    <div class="contenedor-general bg-white py-3 px-5">
        
        <h1 class='text-center fw-700'><ins>DATOS DE LA COMPRA</ins></h1>

        <form action="">

            <h5 class='bg-info p-2 text-white fw-600 mb-3'>DATOS PERSONALES:</h5>

            <div class="row">

                <div class="col-12">

                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label for="inputEmail4">Correo electrónico:</label>

                            <fieldset disabled class='m-0 p-0'>
                                <input type="email" id="disabledTextInput" class="form-control" value="<?php echo $consultaUsuario['emailusuario'] ?>" required>
                            </fieldset>

                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputPassword6">Nombres:</label>
                            <input type="text" class="form-control" id="inputPassword6" value="<?php echo $consultaUsuario['nombreusuario'] ?>" name="nombre" required>
                        </div>

                        <div class="form-group col-md-4">
                            <label for="inputPassword7">Apellido:</label>
                            <input type="text" class="form-control" id="inputPassword7" value="<?php echo $consultaUsuario['apellidousuario'] ?>" name="apellido" required>
                        </div>

                    </div>

                </div>
                
            </div>

            <div class="form-row">

                <div class="form-group col-md-2">
                    <label for="inputAddress3">DNI:</label>
                    <input type="text" class="form-control ls-20" id="inputAddress3" placeholder="88888888" value="<?php echo $consultaUsuario['dniusuario'] ?>" name="dni" required>
                </div>

                <div class="form-group col-md-10">
                    <label for="inputAddress">Dirección:</label>
                    <input type="text" class="form-control" id="inputAddress" placeholder="Av. Lima #1202" value="<?php echo $consultaUsuario['direccionusuario'] ?>" name="direccion" required>
                </div>

                <div class="form-group col-md-2">
                    <label for="inputAddress2">Teléfono:</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="987 654 321"  value="<?php echo $consultaUsuario['telefonousuario'] ?>" name="telefono" required>
                </div>

                <div class="form-group col-md-10">
                    <label for="inputAddress2">Referecia:</label>
                    <input type="text" class="form-control" id="inputAddress2" placeholder="Departamento, barrio o piso"  value="<?php echo $consultaUsuario['referenciausuario'] ?>" name="referencia" required>
                </div>

            </div>

            <?php foreach($restDetail[0] as $key) 
            { 
                $restBlock = resultRest($key);        
            ?>


                <h5 class='bg-info p-2 text-white fw-600 mb-3 mt-4'>RESTAURANTE: <?php echo $restBlock[0]['nomsucursal'] ?></h5>
            <?php } ?>

            <div class='text-center'>
                <button type='submit' class='btn btn-primary h5 fw-600'>COMPLETAR COMPRA</button>
            </div>
        
        </form>




    </div>


</body>
</html>