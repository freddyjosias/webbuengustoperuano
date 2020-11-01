<?php

    session_start();

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 3) {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }

    require '../conexion.php';

    if (isset($_POST['create'])) {

        $name = 'Restaurante ' . rand(1000000, 9999999);
        $direction = 'N/A';
        $phone = 'N/A';
        $img = 'img/no-imagen.png';
        $textWelcome = 'Lorem ipsum, dolor sit amet consectetur adipisicing elit. Similique id quae velit architecto voluptatum officiis eos facere natus perspiciatis rem, quos officia sint itaque mollitia, repellat unde, temporibus odio soluta? Vero necessitatibus odit facilis facere similique debitis rerum, nemo voluptatum minima mollitia porro perspiciatis aut ullam tenetur dolore quae voluptates magnam optio. Dolorem commodi rerum numquam atque consequatur, veniam iste?';
        $textFood = 'Lorem ipsum dolor, sit amet consectetur adipisicing elit. Suscipit, voluptatum!';
        $time = '00:00:00';
        $email = 'none@email.com';

        $NewRest = $conexion -> prepare('INSERT INTO sucursal(nomsucursal, direcsucursal, telefono, banner, imgbienvenida, textobienvenida, imgdestacado1, platodestacado1, imgdestacado2, platodestacado2, imgdestacado3, platodestacado3, horaatencioninicio, horaatencioncierre, correosucursal) VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $NewRest -> execute(array($name, $direction, $phone, $img, $img, $textWelcome, $img, $textFood, $img, $textFood, $img, $textFood, $time, $time, $email));

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


    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Añadir Restaurante</title>
    <link rel="shorcut icon" href="../img/favicon.ico">
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/bootstrap.add.css">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="../">Regresar</a></li>
                    <li><a href="listarencargados.php">Listar Encargados</a></li>
                    <li><a href="anadirencargado.php">Añadir Encargado</a></li>
                    <li><a href="eliminarencargado.php">Eliminar Encargado</a></li>
                    <li><a href="listarrestaurantes.php">Listar Restaurantes</a></li>
                    <li><a href="anadirrestaurante.php">Añadir Restaurante</a></li>
                    <li><a href="eliminarrestaurante.php">Eliminar Restaurante</a></li>
                </ul>
            </nav>

            <div class='container p-5'>
                
                <h1 class='h3 text-center font-weight-bold'>AÑADIR RESTAURANTE</h1>

                <form action="" method="post" class='text-center mt-5'>
                    <button class='btn btn-primary' name='create' value='true'>Añadir nuevo restaurante</button>
                </form>

                <?php if(isset($name)) { ?>
                    <div class='alert alert-success text-center mt-5' role='alert'>
                        Restaurante creado con éxito. <br>
                        El nuevo restaurante se llama <strong> <?php echo $name ?><strong>
                    </div>
                <?php } ?>

            </div>

        </div>
    </main>

    <script src="../js/jquery-3.5.1.min.js"></script>
    <script src="../js/script.js"></script>

</body>
</html>