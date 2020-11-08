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

    $resultadosEn = $conexion -> prepare('SELECT * FROM sucursal WHERE idsucursal = ?');
    $resultadosEn -> execute(array($_SESSION['sucursal']));
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);
        
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Destacados</title>
    <link rel="shorcut icon" href="../../img/favicon.png">
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

            <div class='container p-0 main-panel m-0 mw-85 w-85'>

                <div class="line-top-panel row h-4r">
                    
                </div>
                
                <div class="row w-80 m-auto">
                    <h1 class='h3 text-center mt-5 font-weight-bold w-100'>PLATOS DESTACADOS</h1>

                    <table class="table mt-4">
                    <thead class='thead-light letra-panel'>
                        <tr>
                            <th scope="col" class='text-center'><p>N°</p></th>
                            <th scope="col"><p>Imágen</p></th>
                            <th scope="col"><p>Texto</p></th>
                            <th class='text-center' scope="col"><p>Configurar</p></th>
                        </tr>
                    </thead>
                    <tbody>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>1</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado1'] ?>" alt=""></td>
                                <td><?php echo $val['platodestacado1'] ?></td>
                                <td class='text-center'><a href="actualizar1.php"><i class="far fa-edit"></i></a></td>
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>2</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado2'] ?>" alt=""></td>
                                <td><?php echo $val['platodestacado2'] ?></td>
                                <td class='text-center'><a href="actualizar2.php"><i class="far fa-edit"></i></a></td>                            
                            <?php } ?>
                            </tr>
                            <tr>
                            <?php foreach($resultadosEn as $val) { ?>
                                <th scope="row" class='text-center'>3</th>
                                <td class="destacado-panel"><img src="../../<?php echo $val['imgdestacado3'] ?>" alt=""></td>
                                <td><?php echo $val['platodestacado3'] ?></td>
                                <td class='text-center'><a href="actualizar3.php"><i class="far fa-edit"></i></a></td>
                            <?php } ?>
                            </tr>

                    </tbody>
                    </table>
                </div>
                

            </div>


        </div>
    </main>

</body>
</html>

