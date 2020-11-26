<?php
    
    session_start();
    #var_dump($_POST); die;
    if (!isset($_SESSION['idusuario']) || !isset($_POST['tipopedido0'])) 
    {
        header('Location: ../');
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

    <div class="contenedor-general bg-white">
        h
    </div>


</body>
</html>