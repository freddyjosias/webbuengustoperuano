<?php

    session_start();

    require '../conexion.php';

    $errorAlert = 0;

    if (isset($_SESSION['idusuario'])) {

        $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 3");
        $queryProfile -> execute(array($_SESSION['idusuario']));
        $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);

        if (isset($queryProfile['id_profile'])) 
        {
            $profileAdmin = true;
        } 
        else
        {
            $profileAdmin = false;
        }

        if (!$profileAdmin) {
            header('Location: ../index.php');
        }
        
    } else {
        header('Location: ../index.php');
    }

    if (isset($_POST['createrestaurant'])) {

        $nameR = 'Restaurante ' . rand(1000000, 9999999);
        $directionR = 'N/A';
        $phoneR = 'N/A';
        $imgR = 'img/no.png';
        $textWelcomeR = 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique id quae velit architecto voluptatum officiis eos facere natus perspiciatis rem, quos officia sint itaque mollitia, repellat unde, temporibus odio soluta? Vero necessitatibus odit facilis facere similique debitis rerum, nemo voluptatum minima mollitia porro perspiciatis aut ullam tenetur dolore quae voluptates magnam optio. Dolorem commodi rerum numquam atque consequatur, veniam iste?';
        $textFoodR = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit, voluptatum!';
        $timeR = '00:00:00';
        $emailR = 'none@email.com';

        $NewRest = $conexion -> prepare('INSERT INTO sucursal(nomsucursal, direcsucursal, telefono, banner, imgbienvenida, textobienvenida, imgdestacado1, platodestacado1, imgdestacado2, platodestacado2, imgdestacado3, platodestacado3, horaatencioninicio, horaatencioncierre, correosucursal) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $NewRest -> execute(array($nameR, $directionR, $phoneR, $imgR, $imgR, $textWelcomeR, $imgR, $textFoodR, $imgR, $textFoodR, $imgR, $textFoodR, $timeR, $timeR, $emailR));

        $idInseted = $conexion -> prepare('SELECT LAST_INSERT_ID()');
        $idInseted -> execute();
        $idInseted = $idInseted -> fetch(PDO::FETCH_ASSOC);

        $createForms = $conexion -> prepare('INSERT INTO detalletipospedido(idtipospedido, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(1, $idInseted["LAST_INSERT_ID()"]));

        $createForms = $conexion -> prepare('INSERT INTO detalletipospedido(idtipospedido, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(2, $idInseted["LAST_INSERT_ID()"]));

        $createForms = $conexion -> prepare('INSERT INTO detalletipospedido(idtipospedido, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(3, $idInseted["LAST_INSERT_ID()"]));

        $createForms = $conexion -> prepare('INSERT INTO detalleformaspago(idformaspago, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(1, $idInseted["LAST_INSERT_ID()"]));

        $createForms = $conexion -> prepare('INSERT INTO detalleformaspago(idformaspago, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(2, $idInseted["LAST_INSERT_ID()"]));

        $createForms = $conexion -> prepare('INSERT INTO detalleformaspago(idformaspago, idsucursal) VALUES(?, ?)');
        $createForms -> execute(array(3, $idInseted["LAST_INSERT_ID()"]));

        $errorAlert = 10;

    }

    function deleteManager($user_id, $store_id) {
        
        $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 0 WHERE idusuario = ? AND idsucursal = ?');
        $updateStateAccess -> execute(array($user_id, $store_id));

        $countAccess = $conexion -> prepare('SELECT count(access_id) as count FROM access WHERE idusuario = ? AND state = 1');
        $countAccess -> execute(array($user_id));
        $countAccess = $countAccess -> fetch(PDO::FETCH_ASSOC);

        if ($countAccess['count'] == 0)
        {
            $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 0 WHERE idusuario = ? AND id_profile = 2');
            $updateStateManager -> execute(array($user_id));
        }
        
    }

    if (isset($_POST['iddeletesucursal'])) 
    {
        $nameRest = $conexion -> prepare('SELECT nomsucursal FROM sucursal WHERE idsucursal = ? AND estado = 1');
        $nameRest -> execute(array($_POST['iddeletesucursal']));
        $nameRest = $nameRest -> fetch(PDO::FETCH_ASSOC);
        
        if (!$nameRest) {
            $nameRest['nomsucursal'] = '';
        }

        $deleteRestaurant = $conexion -> prepare('UPDATE sucursal SET estado = 0 WHERE idsucursal = ?');
        $deleteRestaurant -> execute(array($_POST['iddeletesucursal']));

        $countAccess = $conexion -> prepare('SELECT idusuario FROM access WHERE idsucursal = ? AND state = 1');
        $countAccess -> execute(array($_POST['iddeletesucursal']));
        $countAccess = $countAccess -> fetchAll(PDO::FETCH_ASSOC);

        $counterAccess = count($countAccess);

        for ($i = 0; $i < $counterAccess; $i++) 
        { 
            deleteManager($countAccess[$i]['idusuario'], $_POST['iddeletesucursal']);
        }

        $errorAlert = 11;

    }

    $resultadosRes = $conexion -> prepare('SELECT idsucursal, nomsucursal, correosucursal, telefono FROM sucursal WHERE estado = 1');
    $resultadosRes -> execute();
    $resultadosRes = $resultadosRes -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Restaurantes</title>
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../css/formularios.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            <?php

                require '../menu/menupaneladmin.php';

            ?>

            <div class='container p-0 main-panel m-0 mw-85 w-85'>

                <div class="line-top-panel row h-4r m-0 p-0 align-items-center">
                    <div class='text-white fw-700 fs-30 col-12'>ADMINISTRADOR</div> 
                </div>

                <div class="row w-80 m-auto">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100 this-is-restaurant'>RESTAURANTES</h1>

                    <div class="btn-color-princi ml-auto">
                        <form action="" method="post">

                            <input type="text" value='true' name='createrestaurant' class='d-none'>

                            <button class="btn btn-primary bottom fw-600">Crear Restaurante</button>

                        </form>
                    </div>

                    <table class="table mt-4">
                        <thead class='thead-light fs-18'>
                            <tr>
                                <th scope="col" class='text-center'>N°</th>
                                <th scope="col">Nombre</th>
                                <th scope="col">Correo</th>
                                <th scope="col">Teléfono</th>
                                <th class='text-center' scope="col">Más</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php 
                            $cont = 0;
                            foreach($resultadosRes as $val) { 
                            $cont++;
                        ?>
                                <tr class='fs-17 fw-500'>
                                    <th scope="row" class='text-center'><?php echo $cont ?></th>
                                    <td class='py-3'><?php echo $val['nomsucursal'] ?></td>
                                    <td class='py-3'><?php echo $val['correosucursal'] ?></td>
                                    <td class='py-3'><?php echo $val['telefono'] ?></td>

                                    <td class='text-center px-0 py-2'>

                                        <form action="" method="post" class='m-0 p-0'>

                                            <input type="text" name='iddeletesucursal' value='<?php echo $val['idsucursal'] ?>' class='d-none'>

                                            <button class='btn btn-danger'>
                                                <i class="far fa-trash-alt "></i> &nbsp; Eliminar
                                            </button>

                                        </form>
                                        
                                    </td>

                                </tr>
                        <?php } ?>

                        </tbody>
                    </table>

                </div>

            </div>

        </div>
    </main>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/bootstrap.add.js"></script>
    <script src="../sweetalert/sweetalert210.js"></script>
    <script src="../js/script.js"></script>

    <?php
        if ($errorAlert == 10) 
        {
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'success',
                    title: 'Restaurante creado con éxito',
                    html: 'El nuevo restaurante se llama <b> <?php echo $nameR ?></b>'
                })

            </script>
                
            <?php
        } else if ($errorAlert == 11) 
        {
            ?>

            <script>

                Swal.fire
                ({
                    icon: 'success',
                    title: 'El restaurante <?php echo $nameRest['nomsucursal'] ?> se eliminó con éxito',
                    html: 'junto a todos sus encargados'
                })

            </script>
                
            <?php
        } 
    ?>

</body>
</html>