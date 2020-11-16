<?php

    session_start();

    require 'conexion.php';

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

    $errorAlert = 0;

    if (isset($_POST['emailaddmanager'])) {

        $existUser = $conexion -> prepare('SELECT idusuario, nombreusuario, apellidousuario FROM usuario WHERE emailusuario = ? AND estado = 1');
        $existUser -> execute(array($_POST['emailaddmanager']));
        $existUser = $existUser -> fetch(PDO::FETCH_ASSOC);

        if ($existUser) 
        {
            $existManager = $conexion -> prepare('SELECT state FROM detail_usuario_profile WHERE idusuario = ? AND id_profile = 2');
            $existManager -> execute(array($existUser['idusuario']));
            $existManager = $existManager -> fetch(PDO::FETCH_ASSOC);

            $existRestaurant = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE idsucursal = ? AND estado = 1');
            $existRestaurant -> execute(array($_POST['restaurant']));
            $existRestaurant = $existRestaurant -> fetch(PDO::FETCH_ASSOC);

            if ($existRestaurant) 
            {
                $existAccess = $conexion -> prepare('SELECT state FROM access WHERE idusuario = ? AND idsucursal = ?');
                $existAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                $existAccess = $existAccess -> fetch(PDO::FETCH_ASSOC);
        
                if ($existManager) 
                {
                    if ($existAccess && $existManager['state'] == 1) 
                    {
                        if ($existAccess['state'] == 1) 
                        {
                            $errorAlert = 3;
                        } 
                        else 
                        {
                            $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 1 WHERE idusuario = ? AND idsucursal = ?');
                            $updateStateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                        }
                    }
                    else 
                    {
                        $updateStateManager = $conexion -> prepare('UPDATE detail_usuario_profile SET state = 1 WHERE idusuario = ? AND id_profile = 2');
                        $updateStateManager -> execute(array($existUser['idusuario']));

                        $updateStateAccess = $conexion -> prepare('UPDATE access SET state = 1 WHERE idusuario = ? AND idsucursal = ?');
                        $updateStateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));
                    }

                    if (!$existAccess) {
                        
                        $crateAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES (?, ?)');
                        $crateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));

                    }

                    if ($errorAlert == 0) 
                    {
                        $errorAlert = 10;
                    }
                    
                } 
                else 
                {
                    $crateManager = $conexion -> prepare('INSERT INTO detail_usuario_profile(idusuario, id_profile) VALUES (?, 2)');
                    $crateManager -> execute(array($existUser['idusuario']));

                    $crateAccess = $conexion -> prepare('INSERT INTO access(idusuario, idsucursal) VALUES (?, ?)');
                    $crateAccess -> execute(array($existUser['idusuario'], $existRestaurant['idsucursal']));

                    $errorAlert = 10;
                }

            }
            else
            {
                $errorAlert = 2;
            }
            
        }
        else 
        {
            $errorAlert = 1;
        }

    }
    


    $resultadosR = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE estado = 1');
    $resultadosR -> execute();
    $resultadosR = $resultadosR -> fetchAll(PDO::FETCH_ASSOC);

    $resultadosEn = $conexion -> prepare('SELECT a.idusuario, u.nombreusuario, u.apellidousuario, s.nomsucursal, u.emailusuario, s.idsucursal FROM access as a INNER JOIN usuario as u ON a.idusuario = u.idusuario INNER JOIN detail_usuario_profile as m ON a.idusuario = m.idusuario INNER JOIN sucursal as s ON s.idsucursal = a.idsucursal WHERE a.state = 1 AND s.estado = 1 AND m.state = 1 AND m.id_profile = 2 AND u.estado = 1 ORDER BY s.nomsucursal, u.nombreusuario');
    $resultadosEn -> execute();
    $resultadosEn = $resultadosEn -> fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Comentarios</title>
    <link rel="shorcut icon" href="img/logo-icon-512-color.png">
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fontawesome/css/all.min.css">
    <link rel="stylesheet" href="css/bootstrap.add.css">
    <link rel="stylesheet" href="css/normalize.css">
    <link rel="stylesheet" type="text/css" href="css/estilos.css">
    <link rel="stylesheet" type="text/css" href="css/formularios.css">
    <link rel="stylesheet" type="text/css" href="css/responsivepanel.css">

</head>

<body>

    <main>
        <div class="container-fluid panel-control mw-1920p p-0">
            

            <div class='container p-0 main-panel ml-auto mr-0 my-0 mw-f19-85 mw-f18-84 mw-f17-83 mw-f16-82 mw-f15-81 mw-f14-80 mw-100 z-index-auto'>

                
                
                <div class="row w-f14-80 w-90 m-auto contenedor-panel-admin">
                    <h1 class='h3 text-center mt-5 mb-3 font-weight-bold w-100 this-is-manager'>ENCARGADOS</h1>

                    <div class="col-12 form-add-manager">
                        
                        <form class='text-center w-100 mt-0' method='post'>
                            <div class="form-group">
                                <label for="exampleFormControlInput1" class='d-flex'>Ingrese el email del nuevo encargado:</label>
                                <input type="email" name='emailaddmanager' class="form-control" id="exampleFormControlInput1" placeholder="name@example.com" value='<?php echo ($errorAlert == 1) ? $_POST['emailaddmanager'] : '' ?>' required>
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlSelect1" class='d-flex'>Escribir Texto:</label>
                                <textarea type="text" name="descripcion" name='' required></textarea>

                                </select>
                            </div>
                            
                            <div class='form-group d-flex'>
                                <button type="button" class="cancel-add-manager btn btn-light ml-auto mt-3 mr-3">Cancelar</button>
                                <button class='btn btn-primary mt-3 px-4 fw-600'>Añadir</button>
                            </div>

                        </form>

                    </div>

                    <div class="btn-color-princi ml-auto">
                        <a class="buttom-add-manager btn btn-primary bottom fw-600">Agregar Encargado</a>
                    </div>

                    <table class="table mt-4">
                    <thead class='thead-light fs-18'>
                        <tr>
                            <th scope="col" class='text-center'>Comentarios Realizados:</th>

                        </tr>
                    </thead>
                    </table>
                </div>
                

            </div>

        </div>
    </main>

    <script src="js/jquery-3.5.1.min.js"></script>
    <script src="js/bootstrap.add.js"></script>
    <script src="sweetalert/sweetalert210.js"></script>
    <script src="js/script.js"></script>


</body>
</html>