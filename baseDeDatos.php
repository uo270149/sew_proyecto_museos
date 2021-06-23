<?php
class BaseDatos
{
    private $server;
    private $username;
    private $password;
    private $database;

    public function __construct()
    {
        $this->server = "localhost";
        $this->username = "DBUSER2020";
        $this->password = "DBPSWD2020";
        $this->database = "uniovi_php";
    }

    public function insertEntrada($fechaDeseada, $codigo_expo)
    {
        $controlador = new mysqli_driver();
		$controlador->report_mode=MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;
        $db = new mysqli($this->server, $this->username, $this->password, $this->database);
        
        $query_fechas = $db->prepare("SELECT COUNT(*) AS fecha_expo FROM exposiciones WHERE codigo_expo = ? AND fecha_inicio <= ? AND fecha_fin >= ?");

        if (empty($_POST['fechaDeseada'])) {
            echo "<p id=\"confirm\">Por favor, introduzca una fecha para poder comprobar la disponibilidad de la entrada.</p>";
        } else {
            $query_fechas->bind_param('iss', $codigo_expo, $fechaDeseada, $fechaDeseada);

            $query_fechas->execute();

            $result_fechas = $query_fechas->get_result();
            if ($row_fechas = $result_fechas->fetch_assoc()) {
                $count_fechas = $row_fechas["fecha_expo"];
                if ($count_fechas == 0) {
                    echo "<p>La exposición no está disponible en estas fechas.</p>";
                } else {
                    $query_numEntradas = $db->prepare("SELECT COUNT(*) AS numEntradas FROM entradas WHERE codigo_expo = ? AND fecha_entrada = ?");
                    $query_numEntradas->bind_param('is', $codigo_expo, $fechaDeseada);

                    $query_capacidad = $db->prepare("SELECT capacidad FROM museos, exposiciones WHERE museos.codigo = exposiciones.codigo_museo AND exposiciones.codigo_expo = ?");
                    $query_capacidad->bind_param('i', $codigo_expo);

                    $query_numEntradas->execute();
                    $result_numEntradas = $query_numEntradas->get_result();
                    if ($row_numEntradas = $result_numEntradas->fetch_assoc()) {
                        $count_numEntradas = $row_numEntradas['numEntradas'];

                        $query_capacidad->execute();
                        $result_capacidad = $query_capacidad->get_result();
                        if ($row_capacidad = $result_capacidad->fetch_assoc()) {
                            $capacidad = $row_capacidad['capacidad'];

                            if ($count_numEntradas < $capacidad) {
                                $query_insert = $db->prepare("INSERT INTO entradas(fecha_entrada, codigo_expo) VALUES (?, ?);");
                                $query_insert->bind_param('si', $fechaDeseada, $codigo_expo);
                                $query_insert->execute();
                                $query_insert->close();

                                echo "<p>La entrada ha sido comprada con éxito.</p>";
                            } else {
                                echo "<p>La compra no se ha podido realizar. No quedan entradas disponibles para la fecha deseada.";
                            }
                        } else {
                            echo "<p>Error en la consulta. Por favor, inténtelo más tarde.</p>";
                        }
                    } else {
                        echo "<p>Error en la consulta. Por favor, inténtelo más tarde.</p>";
                    }
                    $query_capacidad->close();
                    $query_numEntradas->close();
                }
            } else {
                echo "<p>Error en la consulta. Por favor, inténtelo más tarde.</p>";
            }


            $query_fechas->close();
        }

        $db->close();
    }

    public function searchDataMuseos()
    {
        $db = new mysqli($this->server, $this->username, $this->password, $this->database);

        $query = $db->prepare("SELECT * FROM Museos");


        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows >= 1) {
            echo "<h2>Datos del Museo</h2>";

            echo "<ul>";

            while ($row = $result->fetch_assoc()) {
                echo "<li>Código del museo: " . $row["codigo"] . "</li>";
                echo "<li>Capacidad de asistentes: " . $row["capacidad"] . "</li>";
            }

            echo "</ul>";
        }

        $query->close();
        $db->close();
    }

    public function searchDataExposiciones()
    {
        if (empty($_POST['nombre_expo'])) {
            echo "<p id=\"confirm\">Introduzca el nombre de la exposición.</p>";
        }

        $db = new mysqli($this->server, $this->username, $this->password, $this->database);

        $query = $db->prepare("SELECT * FROM Exposiciones WHERE nombre_expo = ?");

        $query->bind_param('i', $_POST['nombre_expo']);

        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows >= 1) {
            echo "<h2>Datos de la Exposición con nombre solicitado:</h2>";

            echo "<ul>";

            while ($row = $result->fetch_assoc()) {
                echo "<li>Nombre de la exposición: " . $row["nombre_expo"] . "</li>";
                echo "<li>Fecha de inicio: " . $row["fecha_inicio"] . "</li>";
                echo "<li>Fecha de fin: " . $row["fecha_fin"] . "</li>";
                echo "<li>Precio: " . $row["precio"] . "</li>";
            }

            echo "</ul>";
        }

        $query->close();
        $db->close();
    }

    public function getExposiciones($codigo)
    {
        $db = new mysqli($this->server, $this->username, $this->password, $this->database);

        $query = $db->prepare("SELECT * FROM Exposiciones WHERE codigo_museo = ?");

        $query->bind_param('i', $codigo);

        $query->execute();

        $result = $query->get_result();

        if ($result->num_rows >= 1) {
            echo "<h2>Exposiciones existentes:</h2>";

            echo "<table>";
            echo "<thead>";
            echo "<tr>";
            echo "<th>Nombre de la exposición</th>";
            echo "<th>Fecha de inicio</th>";
            echo "<th>Fecha de fin</th>";
            echo "<th>Precio</th>";
            echo "<th>Entradas</th>";
            echo "</tr>";
            echo "</thead>";

            echo "<tbody>";
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row["nombre_expo"] . "</td>";
                echo "<td>" . $row["fecha_inicio"] . "</td>";
                echo "<td>" . $row["fecha_fin"] . "</td>";
                echo "<td>" . $row["precio"] . "</td>";
                echo "<td>" . "<a href=\"entradas.php?codigo_expo=" . $row["codigo_expo"] . "\">Entradas</a>" . "</td>";
                echo "<tr>";
            }
            echo "<tbody>";
            echo "</table>";
        }

        $query->close();
        $db->close();
    }
}
