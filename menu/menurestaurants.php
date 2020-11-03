<div class="container-fluid p-0 d-none d-md-block">
    <nav class='nav-restaurant'>
        <ul>
            <li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>" class="op0">Bienvenida</a></li>
            <li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>" class="op1">Pedidos</a></li>
            <li><a href="nosotros.php?view=<?php echo $idRestaurante ?>" class="op2">Nosotros</a></li>
                <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
                    <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
                        <li><a href="panel.php">Panel</a></li>
                    <?php } ?> 
                <?php } ?> 
            <li>
                <a href="carrito.php?view=<?php echo $idRestaurante ?>" class="op3" class='h-100 align-items-center'>
                    <i class="fas fa-shopping-cart"> </i>
                </a>
            </li>
        </ul>
    </nav>
</div>

<nav class="navbar-restaurant navbar navbar-expand-lg navbar-light d-block d-md-none p-0">
    <div class="contenedor-general">
        <div class="container w-100 d-flex p-0 m-0 mw-100">
            <div class='logo-icono d-block d-md-none position-static'>
                <a href="index.php"><img src="img/logo-icono.png" alt=""></a>
            </div>

            <button class="navbar-toggler w-auto" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="text-white"><i class="fas fa-bars"></i></span>
            </button>
        </div>
        
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-restaurant-list navbar-nav mr-auto text-center fs-18">
                <li class='d-flex'>
                    <a class='text-white w-100 py-2 op0' href="bienvenida.php?view=<?php echo $idRestaurante ?>" id="">Bienvenida</a>
                </li>
                <li class='d-flex'>
                    <a  class='text-white w-100 py-2 op1' href="hacerpedido.php?view=<?php echo $idRestaurante ?>" id="">Pedidos</a>
                </li>
                <li class='d-flex'>
                    <a class='text-white w-100 py-2 op2' href="nosotros.php?view=<?php echo $idRestaurante ?>" id="">Nosotros</a>
                </li>
                <?php if ($_SESSION['profile'] == 2 && isset($_SESSION['sucursal'])) { ?>
                    <?php if ($_SESSION['sucursal'] == $_GET['view']) { ?>
                        <li class='d-flex'><a class='text-white w-100 py-2' href="panel.php">Panel</a></li>
                    <?php } ?> 
                <?php } ?> 
                <li class='d-flex'>
                    <a class='text-white w-100 py-2 op3' href="carrito.php?view=<?php echo $idRestaurante ?>" id="" class='h-100 align-items-center'>
                        <i class="fas fa-shopping-cart"> </i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    
</nav>