<?php 

    require '../../conexion.php';
    header('Cache-Control: no cache');
    session_cache_limiter('private_no_expire');
    session_start();

    if (!isset($_SESSION['idusuario'])) 
    {
        header('Location: ../../index.php');
    }
    else 
    {
        $queryProfile = $conexion -> prepare("SELECT id_profile FROM detail_usuario_profile WHERE state = 1 AND idusuario = ? AND id_profile = 2");
        $queryProfile -> execute(array($_SESSION['idusuario']));
        $queryProfile = $queryProfile -> fetch(PDO::FETCH_ASSOC);

        if (isset($queryProfile['id_profile'])) 
        {
            $profileManager = true;
        } 
        else
        {
            $profileManager = false;
        }

    }
    
    if (!isset($_GET['view'])) {
        header('Location: ../../index.php');
    } else {
       $consultaVerificarRestaurante = 'SELECT * FROM sucursal WHERE estado = 1';

       $idRestaurante;

       $resultados = $conexion -> prepare($consultaVerificarRestaurante);
       $resultados -> execute();
       $resultados = $resultados -> fetchAll(PDO::FETCH_ASSOC);

       foreach($resultados as $row) {
           if ($row['idsucursal'] ==  $_GET['view']) {
               $idRestaurante = $row['idsucursal'];
           break;
        }
    }
    
    if($profileManager == true)  {
        $consultaManager = $conexion -> prepare("SELECT access_id FROM access WHERE state = 1 AND idusuario = ? AND idsucursal = ?");
        $consultaManager -> execute(array($_SESSION['idusuario'], $_GET['view']));
        $consultaManager = $consultaManager -> fetch(PDO::FETCH_ASSOC);

          if($consultaManager == false){

              $profileManager = false;
              
        }
    }

        if (isset($_GET['categoria']) && isset($_GET['id'])) {

            $resultados = $conexion -> prepare(
                'UPDATE productos SET estado = 0 WHERE idcategoriaproducto = ? AND idproducto = ?'
            );
            $resultados -> execute(array($_GET['categoria'],$_GET['id']));
  

            if ($resultados) {
                header("Location: productos.php?view=".$_GET['view']);
            }
        }

    }


?>
