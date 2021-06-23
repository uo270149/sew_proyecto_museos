"use strict";
class CargarMuseos {
    constructor() { }

    cargarDatos(latUsuario, longUsuario) {
        $.ajax({
            dataType: "xml",
            url: 'museos.xml',
            method: 'GET',
            success: function (datos) {

                var stringDatos = "<table>"
                //cabecera de la tabla
                stringDatos += "<thead>";
                stringDatos += "<tr>";
                stringDatos += "<th>Marcar Favorito</th>"
                stringDatos += "<th>Nombre del Museo</th>";
                stringDatos += "<th>Descripción</th>";
                stringDatos += "<th>Latitud</th>";
                stringDatos += "<th>Longitud</th>";
                stringDatos += "<th>Obras Relevantes</th>";
                stringDatos += "<th>Otros</th>"; //masInfo
                stringDatos += "<th>Detalles</th>";
                stringDatos += "<th>Exposiciones</th>"
                stringDatos += "</tr>";
                stringDatos += "</thead>";
                //cuerpo de la tabla
                stringDatos += "<tbody>";
                //Extracción de los datos contenidos en el XML
                $('museo', datos).each(function () {
                    var latitudMuseo = $('latitud', this).text();
                    var longitudMuseo = $('longitud', this).text();
                    // distancia entre la posicion del usuario y la del museo
                    var distancia = Math.sqrt(Math.pow(latUsuario - latitudMuseo, 2) + Math.pow(longUsuario - longitudMuseo, 2));
                    // umbral ara mostrar los museos
                    if (distancia < 15000) {
                        var codigoMuseo = $(this).attr("codigo");
                        var nombreMuseo = $('nombre', this).text();
                        var descripcionMuseo = $('descripcion', this).text();
                        stringDatos += "<tr>";
                        stringDatos += "<td id=\"museo_" + codigoMuseo + "\">";
                        idb.dibujarEstrellaFav(codigoMuseo); // dibujar la estrella cuando marca un museo como favorito

                        stringDatos += "</td>";

                        stringDatos += "<td>" + nombreMuseo + "</td>";
                        stringDatos += "<td>" + descripcionMuseo + "</td>";
                        stringDatos += "<td>" + latitudMuseo + "</td>";
                        stringDatos += "<td>" + longitudMuseo + "</td>";
                        stringDatos += "<td>";
                        stringDatos += "<ul>";
                        $('obra', this).each(function () {
                            var nombreObra = $('nombreObra', this).text();
                            var autorObra = $('autorObra', this).text();
                            var fotosObra = $('fotosObra', this).attr("valor");
                            var enlaceObra = $('enlaceObra', this).attr("valor");
                            stringDatos += "<li>";
                            stringDatos += "<dl>";
                            stringDatos += "<dt>Nombre:</dt><dd>" + nombreObra + "</dd>";
                            stringDatos += "<dt>Autor:</dt><dd>" + autorObra + "</dd>";
                            var enlaceFoto = "<a href=\"" + fotosObra + "\">Foto de la obra</a>"
                            stringDatos += "<dt>Foto:</dt><dd>" + enlaceFoto + "</dd>";
                            var enlaceObraTexto = "<a href=\"" + enlaceObra + "\">Info sobre la obra</a>"
                            stringDatos += "<dt>Enlace:</dt><dd>" + enlaceObraTexto + "</dd>";
                            stringDatos += "</dl>";
                            stringDatos += "</li>";
                        });
                        stringDatos += "</ul>";
                        stringDatos += "</td>";
                        var masInfo = $('masInfo', this).attr("valor");
                        var enlaceMasInfo = "<a href=\"" + masInfo + "\">Página Oficial de " + nombreMuseo + "</a>";
                        stringDatos += "<td>" + enlaceMasInfo + "</td>";
                        stringDatos += "<td>" + "<a href=\"museo.html?nombre=" + nombreMuseo + "\">Detalles</a>" + "</td>";
                        stringDatos += "<td>" + "<a href=\"exposiciones.php?codigo=" + codigoMuseo + "\">Exposiciones</a>" + "</td>";
                        stringDatos += "</tr>";
                    }
                });
                stringDatos += "</tbody>";
                stringDatos += "</table>";

                $("#museosCercanos").append(stringDatos);
            },
            error: function () {
                $("h3").html("ERROR: No se puede obtener XML");
                $("h4").remove();
                $("h5").remove();
                $("p").remove();
            }
        });
    }
}
var cm = new CargarMuseos();
