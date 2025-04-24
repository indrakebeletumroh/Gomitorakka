<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <!-- Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        #map {
            height: 600px;
        }

        #btn-lacak, #btn-tambah-marker {
            margin: 10px 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        #btn-lacak:hover, #btn-tambah-marker:hover {
            background-color: #45a049;
        }

        .crosshair-cursor {
            cursor: crosshair !important;
        }

        #infoBox {
            position: absolute;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%);
            min-width: 200px;
            background-color: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.3);
            padding: 10px;
            z-index: 1000;
            display: none;
            align-items: center;
            gap: 10px;
        }

        #infoBox i {
            color: #4CAF50;
            font-size: 20px;
        }
    </style>
</head>
<body>
    <h2>Selamat datang di HomePage!</h2>
    <a href="{{ route('logout') }}">Logout</a>

    <br>
    <button id="btn-lacak">📍 Lacak Lokasi Saya</button>
    <button id="btn-tambah-marker">➕ Tambah Marker</button>

    <div id="map"></div>
    <div id="infoBox">
        <i class="fa fa-trash"></i> <span id="infoText">Tempat Sampah</span>
    </div>

    <script>
        var map = L.map('map', {
            center: [-6.734268503720979, 108.53808001002696],
            zoom: 15,
            minZoom: 14,
            maxZoom: 18
        });

        var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);
        var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var esriStreet = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}');

        var tempatSampahLayer = L.layerGroup().addTo(map);
        var tpsLiarLayer = L.layerGroup().addTo(map);

        var baseLayers = {
            "OpenStreetMap": openStreetMap,
            "ESRI Street": esriStreet,
            "Satellite": satellite
        };

        var overlays = {
            "Tempat Sampah Umum": tempatSampahLayer,
            "TPS Liar": tpsLiarLayer
        };

        L.control.layers(baseLayers, overlays).addTo(map);

        L.Control.geocoder({ defaultMarkGeocode: false })
            .on('markgeocode', function(e) {
                var center = e.geocode.center;
                map.setView(center, 18);
                L.marker(center).addTo(map)
                    .bindPopup(e.geocode.name)
                    .openPopup();
            })
            .addTo(map);

        let lokasiSayaMarker = null;

        document.getElementById('btn-lacak').addEventListener('click', function () {
            if ("geolocation" in navigator) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    if (lokasiSayaMarker) {
                        map.removeLayer(lokasiSayaMarker);
                    }

                    lokasiSayaMarker = L.marker([userLat, userLng]).addTo(map)
                        .bindPopup("Lokasi Anda")
                        .openPopup();

                    map.setView([userLat, userLng], 18);
                }, function(error) {
                    alert("Gagal mendapatkan lokasi: " + error.message);
                });
            } else {
                alert("Browser tidak mendukung Geolocation");
            }
        });

        const tempatSampahIcon = L.divIcon({
            className: '',
            html: `
                <div style="position: relative;width: 20px;height: 20px;background-color: #4CAF50;border-radius: 50%;display: flex;justify-content: center;align-items: center;box-shadow: 0 0 3px rgba(0,0,0,0.5);">
                    <i class="fa fa-trash" style="color: white; font-size: 10px;"></i>
                    <div style="position: absolute;bottom: -6px;width: 0;height: 0;border-left: 6px solid transparent;border-right: 6px solid transparent;border-top: 6px solid #4CAF50;"></div>
                </div>
            `,
            iconSize: [20, 26],
            iconAnchor: [10, 26],
            popupAnchor: [0, -20]
        });

        let isAddingMarker = false;
        const mapElement = document.getElementById('map');
        const infoBox = document.getElementById('infoBox');
        const infoText = document.getElementById('infoText');

        document.getElementById('btn-tambah-marker').addEventListener('click', function () {
            isAddingMarker = true;
            mapElement.classList.add('crosshair-cursor');
        });

        map.on('click', function(e) {
            if (isAddingMarker) {
                const { lat, lng } = e.latlng;

                const marker = L.marker(e.latlng, { icon: tempatSampahIcon }).addTo(tempatSampahLayer);
                marker.on('click', function () {
                    infoText.textContent = "Tempat Sampah";
                    infoBox.style.display = 'flex';
                });

                fetch("/markers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        lat: lat,
                        lng: lng,
                        jenis: "Tempat Sampah"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log(data.message);
                })
                .catch(err => console.error(err));

                isAddingMarker = false;
                mapElement.classList.remove('crosshair-cursor');
            } else {
                infoBox.style.display = 'none';
            }
        });
    </script>
</body>
</html>
