<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leaflet</title>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
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


    /*************************
     *      Marker            *
     **************************/

    var myIcon = L.icon({
        iconUrl: '<?php echo site_url('img/caveira.png') ?>',
        iconSize: [40, 40]
    });

    var draggable = {
        draggable: true
    }; // Deixa o elemento arrastável;
    var singleMarker = L.marker([-3.758190, -38.542984], {
        icon: myIcon
    });
    var popup = singleMarker.bindPopup('Aqui é o Ceará <br>' + singleMarker.getLatLng()).openPopup();
    popup.addTo(map);

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
    pointJson['features'].map((feature) => {
        var singleMarker = L.marker([feature['geometry']['coordinates'][1], feature['geometry']['coordinates'][0]], {
            icon: myIcon
        });
        var popup = singleMarker.bindPopup('Aqui é o Ceará <br>' + singleMarker.getLatLng()).openPopup();
        popup.addTo(map);
    });

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
    var pointData = L.geoJSON(bpm5, {
        onEachFeature: function(feature, layer) {
            layer.bindPopup(feature.properties.bpm);
            layer.on('mouseover', function(e) {
                this.openPopup(e.latlng);

            });
            layer.on('mousemove', function(e) {
                this.openPopup(e.latlng);

            });
            layer.on('mouseout', function(e) {
                this.closePopup();
            });
        },
        style: {
            fillColor: bpm5.features[0].properties.color,
            fillOpacity: 0.2,
            color: bpm5.features[0].properties.color,
        }
    }).addTo(map);


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
        "Marker": singleMarker,
        "Point Data": pointData,
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

    //Adiciona vários marcadores e exclui cada um individual
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
    var marker;

    map.on('click', function(e) {
        // Remove o marcador anterior, se existir
        if (marker) {
            map.removeLayer(marker);
        }

        // Cria um novo marcador
        marker = L.marker([e.latlng.lat, e.latlng.lng], {
            icon: myIcon
        }).addTo(map);

        var popup = marker.bindPopup('<a href="#" onclick="excluir()">Excluir</a>').openPopup();
        popup.addTo(map);
    });

    function excluir() {
        // Remove o marcador atual
        map.removeLayer(marker);
        // Define marker como nulo para indicar que não há nenhum marcador no mapa
        marker = null;
    }
</script>