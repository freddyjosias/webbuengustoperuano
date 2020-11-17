<?php
    require '../conexion.php';



    $sucursalSearch = $conexion -> prepare('SELECT * FROM sucursal WHERE nomsucursal LIKE "%' . $_GET['view'] . '%" AND estado = 1');
    $sucursalSearch -> execute(array());
    $sucursalSearch = $sucursalSearch -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
	<title>Resultados de la búsqueda</title>
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
<body>
    <div class="text-center w-90 mx-5r">
        <h2 class="h2 fw-700 mt-2r mb-6r">RESULTADOS</h2>
        <?php foreach ($sucursalSearch as $row) { ?>
            <div class="presentacion-restaurantes">
                <a href="hacerpedido.php?view=<?php echo $row['idsucursal']; ?>">
                    <div>
                        <h2><?php echo $row['nomsucursal']; ?>:</h2>
                        <img src="../<?php echo $row['imgbienvenida']; ?>">
                    </div>
                </a>
            </div>
        <?php } ?>
    </div>
</body>
</html>