"use strict";
class WikiDetalles {
    constructor() {
        var paramString = window.location.search;
        var searchParams = new URLSearchParams(paramString);
        this.nombreMuseo = searchParams.get("nombre");
    }

    cargarDetalles() {
        $.ajax({
            dataType: "json",
            url: 'https://es.wikipedia.org/w/api.php?action=query&format=json&prop=extracts&titles=' + this.nombreMuseo + '&exintro=1&explaintext=1&exsectionformat=plain&origin=*',
            method: 'GET',
            success: function (datos) {
                var stringDatos = "";
                var stringTitle = "";
                let info;
                for (let idPagina in datos.query.pages) {
                    info = datos.query.pages[idPagina];
                }
                console.log(info);
                // Comprobar si devuelve algo o no
                if (info.missing) {
                    stringDatos += "Error: no se ha encontrado la página."
                } else {
                    stringTitle += info.title;
                    stringDatos += info.extract;
                }
                $("#nombreMuseo").append(stringTitle);
                $("#detallesMuseo").append("<p>" + stringDatos + "</p>");
            },
            error: function () {
                $("h3").html("ERROR: No se puede obtener JSON");
                $("h4").remove();
                $("h5").remove();
                $("p").remove();
            }
        });
    }
}
var wiki = new WikiDetalles();