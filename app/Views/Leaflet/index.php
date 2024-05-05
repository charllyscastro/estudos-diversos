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
    </style>
</head>

<body>
    <div class="titulo">
        <h3>Leaflet</h3>
    </div>
    <div id="map"></div>
</body>

</html>

<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
<script>
    // Map initialize
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

    /** Marker */
    var myIcon = L.icon({
        iconUrl: '<?php echo site_url('img/caveira.png') ?>',
        iconSize: [40,40]
    });

    var draggable = {draggable: true}; // Deixa o elemento arrastável;
    var singleMarker = L.marker([-3.758190, -38.542984], {icon: myIcon});
    var popup = singleMarker.bindPopup('Aqui é o Ceará <br>' + singleMarker.getLatLng()).openPopup();
    popup.addTo(map);

    console.log(singleMarker.toGeoJSON().geometry.coordinates);
    console.log('lat: ' + singleMarker.toGeoJSON().geometry.coordinates[1]);
    console.log('lng: ' + singleMarker.toGeoJSON().geometry.coordinates[0]);
</script>