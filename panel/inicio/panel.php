<?php

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

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Panel</title>
    <link rel="shorcut icon" href="../../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../../fontawesome/css/all.min.css">
    <link rel="stylesheet" href="../../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../../css/estilos.css">
    <link rel="stylesheet" type="text/css" href="../../css/responpanel.css">
    <link rel="stylesheet" type="text/css" href="../../css/formularios.css">
    <link rel="stylesheet" type="text/css" href="../../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../../css/panel.css">

</head>
<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">

                    <?php require '../../menu/menupanel.php'; ?>
                    
            <div class='contenido-panel-home container p-0 main-panel m-0 mw-85 w-85'>
                <img class="mt-5" src="../../img/logo-icon-512-color.png">
                <p>Bienvenido a su Panel de Control</p>
                <a class="text-decoration" href="../../bienvenida.php?view=<?php echo $_SESSION['sucursal'] ?>">Ver mi Restaurante</a>
            </div>

        </div>
    </main>

</body>
</html>