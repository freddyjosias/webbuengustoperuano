<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Quienes Somos - Restaurante 1</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="css/normalize.css">
	<link rel="stylesheet" type="text/css" href="css/estilos.css">

</head>
<body>

    <main>
        <div class="contenedor-general panel-control">
            <nav>
                <ul>
                    <li><a href="panel.php">Inicio</a></li>
                    <li><a href="anadir-categoria.php">Añadir Categoria</a></li>
                    <li><a href="eliminar-categoria.php">Eliminar Categoria</a></li>
                    <li><a href="actualizar-categoria.php">Actualizar Categoria</a></li>
                    <li><a href="anadir-producto.php">Añadir Producto</a></li>
                    <li><a href="eliminar-producto.php">Eliminar Producto</a></li>
                    <li><a href="actualizar-producto.php">Actualizar Praducto</a></li>
                    <li><a href="formas-pago.php">Formas de Pago</a></li>
                    <li><a href="tipos-pedido.php">Tipos de pedido</a></li>
                </ul>
            </nav>

            <div class='formulario-panel'>

                <h1>Actualizar Producto</h1>

                <form action="">

                    <p> Elegir Producto: 
                        <select name="" id="">
                            <option value="">Hola</option>
                            <option value="">Mundo</option>
                        </select>
                    </p>

                    <input type="submit" value="Selecionar">

                </form>

                <form action="">

                    <p>Nombre: </p>
                    <p>Nuevo nombre: <input type="text"></p>  
                    
                    <p>Precio: </p>
                    <p>Nuevo precio: <input type="number"></p>

                    <p>Stock</p>
                    <p>Nuevo Stock: <input type="number"></p>
                    
                    <input type="submit" value="Actualizar Producto">

                </form>

            </div>

        </div>
    </main>

</body>
</html>