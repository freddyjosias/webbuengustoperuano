<li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>"id="op0">Bienvenida</a></li>
<li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>"id="op1">Pedidos</a></li>
<li><a href="nosotros.php?view=<?php echo $idRestaurante ?>"id="op2">Nosotros</a></li>
    <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
        <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
            <li><a href="panel.php">Panel</a></li>
        <?php } ?> 
    <?php } ?> 
<li><a href="anadircarrito.php?view=<?php echo $idRestaurante ?>"id="op3"><img src="img/carrito.png" class="carrito-compras"></a></li>