<?php

    require '../conexion.php';

    if (isset($_POST['searchinput'])) 
    {
        $sucursalSearch = $conexion -> prepare('SELECT idsucursal, nomsucursal FROM sucursal WHERE nomsucursal LIKE "%' . $_POST['searchinput'] . '%" AND estado = 1');
        $sucursalSearch -> execute();
        $sucursalSearch = $sucursalSearch -> fetchAll(PDO::FETCH_ASSOC);

        $sucursalSearch1 = $conexion -> prepare('SELECT idsucursal, idcategoriaproducto, descripcioncategoriaproducto FROM categoriaproductos WHERE descripcioncategoriaproducto LIKE "%' . $_POST['searchinput'] . '%" AND estado = 1');
        $sucursalSearch1 -> execute();
        $sucursalSearch1 = $sucursalSearch1 -> fetchAll(PDO::FETCH_ASSOC);

        $sucursalSearch2 = $conexion -> prepare(
            'SELECT c.idsucursal, c.idcategoriaproducto, p.idproducto, p.nomproducto 
             FROM productos AS p INNER JOIN categoriaproductos AS c ON p.idcategoriaproducto = c.idcategoriaproducto
             WHERE p.nomproducto LIKE "%' . $_POST['searchinput'] . '%" AND p.estado = 1');
        $sucursalSearch2 -> execute();
        $sucursalSearch2 = $sucursalSearch2 -> fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($sucursalSearch as $key) 
        {
            ?>
            <a class="dropdown-item" href="nosotros.php?view=<?php echo $key['idsucursal'] ?>"><?php echo $key['nomsucursal'] ?></a>
            <?php
        }

        foreach ($sucursalSearch1 as $key) {
            ?>
            <a class="dropdown-item" href="hacerpedido.php?view=<?php echo $key['idsucursal'] ?>"><?php echo $key['descripcioncategoriaproducto'] ?></a>
            <?php
        }

        foreach ($sucursalSearch2 as $key) {
            ?>
            <a class="dropdown-item" href="hacerpedido.php?view=<?php echo $key['idsucursal'] ?>"><?php echo $key['nomproducto'] ?></a>
            <?php
        }
    }

?>