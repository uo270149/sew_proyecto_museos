<?php
require "baseDeDatos.php";

if (isset($_POST["fechaDeseada"])) {
    $fechaDeseada = $_POST["fechaDeseada"];
    $codigo_expo = $_GET["codigo_expo"];
    $bd = new BaseDatos();
    $resultado = $bd->insertEntrada($fechaDeseada, $codigo_expo);
}
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
    <title>Entradas</title>

    <link rel="stylesheet" type="text/css" href="estilo.css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>

</head>

<body>
    <header>
        <h1>Entradas</h1>
    </header>

    <nav>
        <ul id="menu">
            <li><a href="index.html">Museos Cercanos</a></li>
        </ul>
    </nav>

    <main>
        <h2>Comprar Entradas</h2>
        <form method='post'>
            <label for="fechaDeseada">Fecha deseada:</label>
            <input type="date" title="fechaDeseada" name="fechaDeseada"></input>

            <input type='submit' class='button' name='comprarEntrada' title="comprarEntrada" value='Comprar Entrada' />
        </form>

        <?php
			
			if (isset($_POST["fechaDeseada"])) {
				$fechaDeseada = $_POST["fechaDeseada"];
				$codigo_expo = $_GET["codigo_expo"];
				$bd = new BaseDatos();
				$resultado = $bd->insertEntrada($fechaDeseada, $codigo_expo);
			}
		?>
    </main>

    <footer>
        <!--Enlaces a los validadores-->
        <a href="https://validator.w3.org">
            <img class="validator" src="images/HTML5.png" alt=" HTML5 Válido!" /></a>

        <a href="http://jigsaw.w3.org/css-validator/">
            <img class="validator" src="images/CSS3.png" alt="CSS Válido!" /></a>
    </footer>
</body>

</html>