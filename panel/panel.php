<?php

    session_start();

    if (!isset($_SESSION['sucursal'])) {
        header('Location: ../index.php');
    }

    if (isset($_SESSION['idusuario'])) {
        if ($_SESSION['profile'] != 2) {
            header('Location: ../index.php');
        }
    } else {
        header('Location: ../index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Panel</title>
    <link rel="shorcut icon" href="../img/logo-icon-512-color.png">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">
    <link rel="stylesheet" href="../css/panel.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">

                    <?php require '../menu/menupanel.php'; ?>
                    
            </nav>
            <div class='contenido-panel-home'>
                <img src="../img/logo-icono-new.png">
                <p>Bienvenido a su Panel de Control</p>
                <a href="../bienvenida.php?view=<?php echo $_SESSION['sucursal'] ?>">Ver mi Restaurante</a>
            </div>

        </div>
    </main>

</body>
</html>