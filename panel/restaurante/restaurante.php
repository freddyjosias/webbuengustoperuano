<?php

    require '../../conexion.php';

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

    if($_SERVER['REQUEST_METHOD'] == 'POST') {

        $resultados = $conexion -> prepare('UPDATE sucursal SET nomsucursal = ?, telefono = ?, correosucursal = ?, direcsucursal = ?, horaatencioninicio = ?, horaatencioncierre = ? WHERE idsucursal = ?');
        $resultados -> execute(array($_POST['res-actualizada'], $_POST['tele-actualizada'], $_POST['email-actualizada'], $_POST['dire-actualizada'], $_POST['horai-actualizada'], $_POST['horac-actualizada'], $_SESSION['sucursal']));

    }

    $consulta = $conexion -> prepare('SELECT * FROM sucursal WHERE idsucursal = ?');
    $consulta -> execute(array($_SESSION['sucursal']));
    $consulta = $consulta -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Restaurante</title>
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
            
            <div class='formulario-panel container p-0 main-panel m-0 mw-85 w-85'>

                <h1 class='h3 text-center mt-5 font-weight-bold w-100'>Información Restaurante</h1>

                <form action="" class='form-panel mt-5' method = "post">

                    <p> Nombre Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['nomsucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo nombre: <input value="<?php echo $row['nomsucursal'] ?>" type="text" name = 'res-actualizada'></p>

                    <p> Telefono Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['telefono'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo Telefono: <input value="<?php echo $row['telefono'] ?>" type="text" name = 'tele-actualizada'></p>

                    <p> Correo Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['correosucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nuevo Correo: <input value="<?php echo $row['correosucursal'] ?>" type="text" name = 'email-actualizada'></p>

                    <p> Dirección Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['direcsucursal'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Dirección: <input value="<?php echo $row['direcsucursal'] ?>" type="text" name = 'dire-actualizada'></p>

                    <p> Hora inicio atención del Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['horaatencioninicio'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Hora: <input value="<?php echo $row['horaatencioninicio'] ?>" type="time" name = 'horai-actualizada'></p>

                    <p> Hora cierre atención del Restaurante:&nbsp;  
                            <?php foreach($consulta as $row) { ?>
                                <?php echo $row['horaatencioncierre'] ?>
                            <?php } ?>
                    </p>
                    <p>Nueva Hora: <input value="<?php echo $row['horaatencioncierre'] ?>" type="time" name = 'horac-actualizada'></p>
                    
                    <input type="submit" value="Actualizar">

                </form>

            </div>

        </div>
    </main>

</body>
</html>
