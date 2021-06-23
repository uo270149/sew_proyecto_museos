"use strict";
class GeoLocalizacion {
    constructor(cargarMuseos) {
        this.cargarMuseos = cargarMuseos;
        navigator.geolocation.getCurrentPosition(this.getPosicion.bind(this));
    }

    getPosicion(posicion) {
        this.longitud = posicion.coords.longitude;
        this.latitud = posicion.coords.latitude;
        this.cargarMuseos.cargarDatos(this.latitud, this.longitud);
    }
}
var geo = new GeoLocalizacion(cm);