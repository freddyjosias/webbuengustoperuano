<div class="container-fluid p-0 d-none d-md-block">
    <nav class='nav-restaurant z-index-7'>
        <ul>
            <li><a href="bienvenida.php?view=<?php echo $idRestaurante ?>" class="op0 h-100">Bienvenida</a></li>
            <li><a href="hacerpedido.php?view=<?php echo $idRestaurante ?>" class="op1 h-100">Pedidos</a></li>
            <li><a href="nosotros.php?view=<?php echo $idRestaurante ?>" class="op2 h-100">Nosotros</a></li>
                <?php if ($profileManager == true) { ?>
                    <li><a href="panel/bienvenida/paginabienvenida.php?view=<?php echo $idRestaurante ?>" class='h-100'>Panel</a></li>
                <?php } 
                
                $numberCar = $conexion -> prepare('SELECT count(idproducto) as count FROM shop_car WHERE idusuario = ?');
                $numberCar -> execute(array($_SESSION['idusuario']));
                $numberCar = $numberCar -> fetch(PDO::FETCH_ASSOC);
                
                ?> 
            <li>
                <a href="carrito.php?view=<?php echo $idRestaurante ?>" class='op3 h-100 align-items-center'>
                    <i class="fas fa-shopping-cart"> </i> <span class="badge badge-secondary h1 ml-1 bg-white text-dark"><?php echo $numberCar['count'] ?></span>
                </a>
            </li>
        </ul>
    </nav>
</div>

<nav class="navbar-restaurant z-index-7 navbar navbar-expand-lg navbar-light d-block d-md-none p-0 border border-white border-top-0 broder-right-0 border-left-0">
    <div class="contenedor-general">
        <div class="container w-100 d-flex p-0 m-0 mw-100">

            <div class='logo-icono d-block d-md-none position-static'>
                <a href="index.php"><img src="img/logo-icon-512-color.png" alt=""></a>
            </div>

            <div class='logo-icono mr-auto ml-3 d-block d-md-none position-static'>
                <a href="usuario.php"><img src="<?php echo $_SESSION['photo'] ?>" class='border rounded-circle' alt=""></a>
            </div>

            <div class='h-100 align-items-center'>
                <div class="container m-0 p-0">
                    <p class="navbar-toggler w-auto no-select p-0 m-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="text-white fw-600">MENÚ &nbsp; <i class="fas fa-bars"></i></span>
                    </p>
                </div>
            </div>
            
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
                <?php if ($profileManager == true) { ?>
                    <li class='d-flex'><a class='text-white w-100 py-2' href="panel/bienvenida/paginabienvenida.php?view=<?php echo $idRestaurante ?>">Panel</a></li>
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