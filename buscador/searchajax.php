<?php

    require '../conexion.php';

    if (isset($_POST['searchinput'])) 
    {
        $sucursalSearch = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE nomsucursal LIKE "%' . $_POST['searchinput'] . '%" AND estado = 1');
        $sucursalSearch -> execute();
        $sucursalSearch = $sucursalSearch -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($sucursalSearch as $key) 
        {
            ?>
            <a class="dropdown-item" href="#"><?php echo $key['nomsucursal'] ?></a>
            <?php
        }
    }

?>