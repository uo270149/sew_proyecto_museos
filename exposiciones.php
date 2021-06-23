<?php
require "baseDeDatos.php";
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <!-- Datos que describen el documento -->
    <meta name="author" content="Sofía Suárez Fernández UO270149" />
    <meta name="description" content="Sitio web sobre museos." />
    <meta name="keywords" content="Museo,Exposiciones" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta charset="UTF-8" />
    <title>Exposiciones</title>

    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <header>
        <h1>Exposiciones</h1>

        <div id="exposicionesMuseo"></div>
    </header>

    <?php
    $codigo = $_GET['codigo'];

    $bd = new BaseDatos();

    $bd->getExposiciones($codigo);
    ?>

    <footer>
        <!--Enlaces a los validadores-->
        <a href="https://validator.w3.org">
            <img class="validator" src="images/HTML5.png" alt=" HTML5 Válido!" /></a>

        <a href="http://jigsaw.w3.org/css-validator/">
            <img class="validator" src="images/CSS3.png" alt="CSS Válido!" /></a>
    </footer>
</body>

</html>