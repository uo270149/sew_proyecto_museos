"use strict";
class gestorIndexedDB {
    constructor() {
        console.log("openDb ...");
        var req = indexedDB.open("favoritos", 1);
        req.onsuccess = (evt) => {
            // Equal to: db = req.result;
            this.db = evt.target.result;
            console.log("openDb DONE");
        };
        req.onerror = function (evt) {
            console.error("openDb:", evt.target.errorCode);
        };

        req.onupgradeneeded = function (evt) {
            console.log("openDb.onupgradeneeded");
            var store = evt.currentTarget.result.createObjectStore(
                "museosFavoritos", { keyPath: 'codigoMuseo' });
        };
    }

    existe(codigoMuseo) {
        var transaction = this.db.transaction(["museosFavoritos"]);
        var objectStore = transaction.objectStore("museosFavoritos");
        var request = objectStore.get(codigoMuseo);
        request.onsuccess = function (evt) {
            console.log(evt);
            console.log(request.result);
        }
        return !!request;
    }

    dibujarEstrellaFav(codigoMuseo) {
        var transaction = this.db.transaction(["museosFavoritos"]);
        var objectStore = transaction.objectStore("museosFavoritos");
        var request = objectStore.get(codigoMuseo);

        request.onsuccess = function (evt) {
            if (request.result) {
                document.getElementById("museo_" + codigoMuseo).innerHTML = "<span class=\"favorito\">"+"&#9733;</span>";
            } else {
                document.getElementById("museo_" + codigoMuseo).innerHTML = "<button onclick=idb.insertar('" + codigoMuseo + "')>Favorito</button>";
            }
        }
    }

    insertar(codigoMuseo) {
        var transaction = this.db.transaction(["museosFavoritos"], "readwrite");

        // Do something when all the data is added to the database.
        transaction.oncomplete = function (event) {
            console.log("All done!");
            document.getElementById("museo_" + codigoMuseo).innerHTML = "<span class=\"favorito\">"+"&#9733;</span>";
        };

        transaction.onerror = function (event) {
            // Don't forget to handle errors!
        };

        var objectStore = transaction.objectStore("museosFavoritos");

        var request = objectStore.add({ codigoMuseo: codigoMuseo });
        request.onsuccess = function (event) {
            // event.target.result === customer.ssn;
        };

    }
}
var idb = new gestorIndexedDB();