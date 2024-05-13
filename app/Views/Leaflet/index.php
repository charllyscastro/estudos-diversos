<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />

    <!-- leaflet routing machine css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.css" />

    <!-- leaflet control geocoder css -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />

    <style>
        body {
            margin: 0;
            padding: 0;
        }

        .titulo {
            width: 100%;
            height: 25px;
            text-align: center;
        }

        #map {
            width: 100%;
            height: 90vh;
        }

        /* retira o icone do canto inferior direito */
        .leaflet-control-attribution {
            display: none !important;
        }

        .coordinate {
            position: absolute;
            bottom: 10px;
            right: 2%;
        }

        /* Mudar a cor do popup */
        .leaflet-popup-content-wrapper,
        .leaflet-popup-tip {
            background-color: #000;
            color: #fff;
            border: 2px solid red;
        }

        .leaflet-popup-close-button span {
            color: #fff;
        }
    </style>
</head>

<body>
    <div class="titulo">
        <h3>Leaflet</h3>
    </div>
    <div id="map">
        <div class="leaflet-control coordinate"></div>
    </div>
</body>

</html>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<!-- leaflet routing machine js -->
<script src="https://unpkg.com/leaflet-routing-machine@latest/dist/leaflet-routing-machine.js"></script>

<!-- leaflet geocoder control js -->
<script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

<script src="<?php echo site_url('geojson/point.js') ?>"></script>
<script src="<?php echo site_url('geojson/bpm1.js') ?>"></script>
<script src="<?php echo site_url('geojson/bpm3.js') ?>"></script>
<script src="<?php echo site_url('geojson/bpm5.js') ?>"></script>




<script>
    /*************************
     *      Map initialize    *
     **************************/
    var map = L.map('map').setView([-3.758190, -38.542984], 12);

    var osm = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    });
    // osm.addTo(map);

    var dark = L.tileLayer('https://{s}.basemaps.cartocdn.com/dark_all/{z}/{x}/{y}{r}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors &copy; <a href="https://carto.com/attributions">CARTO</a>',
        subdomains: 'abcd',
        maxZoom: 20
    });

    // dark.addTo(map);


    /**
    Hybrid: s,h;
    Satellite: s;
    Streets: m;
    Terrain: p;
     */

    var googleHybrid = L.tileLayer('http://{s}.google.com/vt?lyrs=s,h&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    // googleHybrid.addTo(map);

    var googleTerrain = L.tileLayer('http://{s}.google.com/vt?lyrs=p&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    // googleTerrain.addTo(map);

    var googleStreets = L.tileLayer('http://{s}.google.com/vt?lyrs=m&x={x}&y={y}&z={z}', {
        maxZoom: 20,
        subdomains: ['mt0', 'mt1', 'mt2', 'mt3']
    });

    googleStreets.addTo(map);

    var nexrad = L.tileLayer.wms("http://mesonet.agron.iastate.edu/cgi-bin/wms/nexrad/n0r.cgi", {
        layers: 'nexrad-n0r-900913',
        format: 'image/png',
        transparent: true,
        attribution: "Weather data © 2012 IEM Nexrad"
    });


    /**********************
     *       Marker       *
     **********************/

    // var myIcon = L.icon({
    //     iconUrl: '<?php //echo site_url('img/caveira.png') 
                        ?>',
    //     iconSize: [40, 40]
    // });

    // var draggable = {
    //     draggable: true
    // }; // Deixa o elemento arrastável;
    // var singleMarker = L.marker([-3.758190, -38.542984], {
    //     icon: myIcon
    // });
    // var popup = singleMarker.bindPopup('Aqui é o Ceará <br>' + singleMarker.getLatLng()).openPopup();
    // popup.addTo(map);

    // console.log(singleMarker.toGeoJSON().geometry.coordinates);
    // console.log('lat: ' + singleMarker.toGeoJSON().geometry.coordinates[1]);
    // console.log('lng: ' + singleMarker.toGeoJSON().geometry.coordinates[0]);



    /*************************
     *      Geojson           *
     **************************/
    // Se quiser apresentar todos os dados de uma vez, os dados tem que vir no formato
    /**
     * var pointJson = {
        "type": "FeatureCollection",
        "features": [
            {
                "type": "Feature",
                "properties": {},
                "geometry": {
                    "coordinates": [
                        -38.587820958793856,
                        -3.712248634258927
                    ],
                    "type": "Point"
                }
            },
        }
        */
    // L.geoJson(pointJson).addTo(map);

    // POINT - Fazendo o map para cada item do json, ao vir os dados do model pode apresentar dessa forma
    // pointJson['features'].map((feature) => {
    //     var singleMarker = L.marker([feature['geometry']['coordinates'][1], feature['geometry']['coordinates'][0]], {
    //         icon: myIcon
    //     });
    //     var popup = singleMarker.bindPopup('Aqui é o Ceará <br>' + singleMarker.getLatLng()).openPopup();
    //     popup.addTo(map);
    // });

    // L.geoJSON(bpm1).addTo(map);
    // L.geoJSON(bpm3, {
    //     onEachFeature: function(feature, layer) {
    //         layer.bindPopup(feature.properties.bpm)
    //         layer.on('mouseover', function(e) {
    //             this.openPopup();
    //         });
    //         layer.on('mouseout', function(e) {
    //             this.closePopup();
    //         })
    //     }
    // }).addTo(map);


    // var pointData = L.geoJSON(bpm5, {
    //     onEachFeature: function(feature, layer) {

    //         // layer.bindPopup(feature.properties.bpm);
    //         // layer.on('mouseover', function(e) {
    //         //     this.openPopup(e.latlng);

    //         // });
    //         // layer.on('mousemove', function(e) {
    //         //     this.openPopup(e.latlng);

    //         // });
    //         // layer.on('mouseout', function(e) {
    //         //     this.closePopup();
    //         // });


    //         // Adicione uma legenda ao marcador
    //         layer.bindTooltip(feature.properties.bpm, {
    //             permanent: true,
    //             direction: 'center',
    //             className: 'feature-label'
    //         });
    //     },
    //     style: {
    //         fillColor: bpm5.features[0].properties.color,
    //         fillOpacity: 0.2,
    //         color: bpm5.features[0].properties.color,
    //     }
    // }).addTo(map);


    /*************************
     *   Layer controller     *
     **************************/

    var baseMaps = {
        "osm": osm,
        "dark": dark,
        "googleHybrid": googleHybrid,
        "googleStreet": googleStreets,
        "googleTerrain": googleTerrain,

    }

    var overlayMaps = {
        // "Marker": singleMarker,
        // "Point Data": pointData,
        "nexrad": nexrad
    }

    L.control.layers(baseMaps, overlayMaps, {
        collapsed: false
    }).addTo(map);


    /*************************
     *   Leftlet Events        *
     **************************/
    // map.on('mouseover', function() {
    //     console.log('Your mouse is over the map');
    // });

    // map.on('mousemove', function(e) {
    //     document.getElementsByClassName('coordinate')[0].innerHTML = 'lat: ' + e.latlng.lat + ' / lng: ' + e.latlng.lng;
    //     console.log('lat: ' + e.latlng.lat, 'lng: ' + e.latlng.lng)
    // });

    /** Adiciona vários marcadores e exclui cada um individual*/

    // var markers = {};
    // map.on('click', function(e) {
    //     var id = Date.now();
    //     var singleMarker = L.marker([e.latlng.lat, e.latlng.lng], {
    //         icon: myIcon
    //     });
    //     singleMarker.id = id;
    //     markers[id] = singleMarker;
    //     var popup = singleMarker.bindPopup('<a href="#" onClick="excluir('+id+')">Excluir</a>').openPopup();
    //     popup.addTo(map);

    // })

    // function excluir(id) {
    //     var marker = markers[id];
    //     // console.log(link.parentNode._source);
    //     map.removeLayer(marker);
    //     delete markers[id];
    // }

    /**Adicionando apenas um marcador e excluindo o anterior */

    // var marker;

    // map.on('click', function(e) {
    //     // Remove o marcador anterior, se existir
    //     if (marker) {
    //         map.removeLayer(marker);
    //     }

    //     // Cria um novo marcador
    //     marker = L.marker([e.latlng.lat, e.latlng.lng], {
    //         icon: myIcon
    //     }).addTo(map);

    //     var popup = marker.bindPopup('<a href="#" style="text-decoration: none" onclick="excluir()">Excluir</a>');
    //     popup.addTo(map);
    //     console.log('lat: ' + e.latlng.lat, 'long: ' + e.latlng.lng)
    // });

    // function excluir() {
    //     // Remove o marcador atual
    //     map.removeLayer(marker);
    //     // Define marker como nulo para indicar que não há nenhum marcador no mapa
    //     marker = null;
    // }

    /******************************
     *  Rastreador de localização *
     ******************************/
    // Atenção!!! só funciona se https estiver ativado
    // if(!navigator.geolocation){
    //     console.log("Your browser doesn't support geolocation feature!")
    // }else{
    //     // Intervalo de 5 seg
    //     setInterval(() => {
    //         navigator.geolocation.getCurrentPosition(getPosition);
    //     }, 5000);
    // }

    // var marker, circle;

    // function getPosition(position){
    //     // console.log(position);
    //     var lat = position.coords.latitude;
    //     var long = position.coords.longitude;
    //     var accuracy = position.coords.accuracy; //Precisao

    //     //Necessario para não haver sobreposicao
    //     if(marker){
    //         map.removeLayer(marker);
    //     }

    //     if(circle){
    //         map.removeLayer(circle);
    //     }

    //     marker = L.marker([lat, long]);
    //     circle = L.circle([lat, long], {radius: accuracy}); //Adiciona um circulo de acordo com a presicao

    //     var featureGroup = L.featureGroup([marker, circle]).addTo(map);

    //     map.fitBounds(featureGroup.getBounds());

    //     console.log("Your coordinate is lat: " + lat + " long: " + long + " Accuracy: " + accuracy);
    // }

    /******************************
     *         Roteamento         *
     ******************************/
    // marker icon
    // var carIcon = L.icon({
    //     iconUrl: '<?php //echo site_url('img/vtr.png') 
                        ?>',
    //     iconSize: [30, 30]
    // });

    // //marker
    // var marker = L.marker([-3.758190, -38.542984], {
    //     icon: carIcon
    // }).addTo(map);

    // //map click event
    // map.on('click', function(e) {

    //     var secondMarker = L.marker([e.latlng.lat, e.latlng.lng]).addTo(map);
    //     L.Routing.control({
    //         waypoints: [
    //             L.latLng(-3.758190, -38.542984),
    //             L.latLng(e.latlng.lat, e.latlng.lng)
    //         ]
    //     }).on('routesfound', function(e) {
    //         e.routes[0].coordinates.forEach(function(coord, index) {
    //             setTimeout(() => {
    //                 marker.setLatLng([coord.lat, coord.lng]);
    //             }, 100 * index);
    //         });
    //     }).addTo(map);
    // });

    /******************************
     *      Imagem Pop-up         *
     ******************************/
    // var marker = L.marker([-3.758190, -38.542984], {
    //     draggable: true, //arrastavel
    //     title: "Texto hover do ponto", //Texto apresentado hover mouse
    //     opacity: 0.5, // Opacidade
    // })
    // .addTo(map)
    // .bindPopup('<h1> Marker </h1> <p> This is the marker text </p> <img width="300px" src="<?php echo site_url('img/aurora.jpg') ?>" />') //adiciona popup
    // .openPopup(); // Abre o popup por padrao

    /*************************
     *   Pesquisar lugares   *
     *************************/
    L.tileLayer('https://{s}.tile.osm.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://osm.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);
    L.Control.geocoder()
    // Adiciona um retangulo pelas coordenadas norte, sul, leste, oeste
    // .on('markgeocode', function(e) {
    //     console.log(e);
    //     var bbox = e.geocode.bbox;
    //     var poly = L.polygon([
    //         bbox.getSouthEast(),
    //         bbox.getNorthEast(),
    //         bbox.getNorthWest(),
    //         bbox.getSouthWest()
    //     ]).addTo(map);
    //     map.fitBounds(poly.getBounds());
    // })

    //Adiciona um circulo no meio do ponto
    .on('markgeocode', function(e) {
        console.log(e);
        var center = e.geocode.center;
        var circle = L.circle([center.lat, center.lng]).addTo(map);
        map.fitBounds(circle.getBounds());
    })
    .addTo(map);

</script>

<!-- circle = L.circle([lat, long], {radius: accuracy}); //Adiciona um circulo de acordo com a presicao -->