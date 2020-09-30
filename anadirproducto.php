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
                    <li><a href="anadircategoria.php">Añadir Categoria</a></li>
                    <li><a href="eliminarcategoria.php">Eliminar Categoria</a></li>
                    <li><a href="actualizarcategoria.php">Actualizar Categoria</a></li>
                    <li><a href="anadirproducto.php">Añadir Producto</a></li>
                    <li><a href="eliminarproducto.php">Eliminar Producto</a></li>
                    <li><a href="actualizarproducto.php">Actualizar Praducto</a></li>
                    <li><a href="formaspago.php">Formas de Pago</a></li>
                    <li><a href="tipospedido.php">Tipos de pedido</a></li>
                </ul>
            </nav>

            <div class='formulario-panel'>

                <h1>Añadir Producto</h1>

                <form action="" class='form-panel'>
                    <p> Categoria: 
                        <select name="" id="">
                            <option value="">Hola</option>
                            <option value="">Mundo</option>
                        </select>
                    </p>

                    <p>Nuevo Producto: <input type="text"></p>  
                    
                    <p>Precio: <input type="number"></p>

                    <p>Stock: <input type="number"></p>
                    
                    <input type="submit" value="Añadir Producto">

                </form>

            </div>

        </div>
    </main>

</body>
</html>