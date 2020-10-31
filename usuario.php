<?php

    session_start();

    if (!isset($_SESSION['idsucursal'])) {
        header('Location: index.php');
    }

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link href="https://fonts.googleapis.com/css2?family=Dosis:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>Usuario</title>
    <link rel="shorcut icon" href="img/favicon.ico">
    <link rel="stylesheet" href="../css/normalize.css">
    <link rel="stylesheet" type="text/css" href="../css/estilos.css">

</head>
<body>
                            
                <header class="header-inicio">
                    <div class="contenedor-general contenido-header-inicio">

                        <div class="contenedor-img">  
                            <img src="img/logo-white.png" class="contenido-header-inicio-img">
                        </div>

                    </div>
                </header>

        <section class="form-register">
                    
                    <div class="form-centro">
                           
                                <input type="email" name="usuario" placeholder="correo electronico" value="@gmail.com">
                                <input type="text" name="titulo" placeholder="Nombres" required>
                                <input type="text" name="titulo" placeholder="Apellidos" required>
                                <input type="text" name="clave" placeholder="Contraseña" required>
                                <input type="number" name="resumen" placeholder="Telefono" required>
                                <input type="Text" name="resumen" placeholder="Dirección" required>
                                <input type="number" name="resumen" placeholder="Dni" required>    
                  
                                <button type="submit">Guardar</button>
                                <button type="submit">Cancelar</button>
                           
                    
                    </div>
            </section>


</body>
</html>