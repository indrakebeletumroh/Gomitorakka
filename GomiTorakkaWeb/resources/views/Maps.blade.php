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

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif
    <style>
        #map {
            height: 600px;
        }

        #btn-lacak,
        #btn-tambah-marker {
            margin: 10px 5px;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 8px;
            cursor: pointer;
        }

        #btn-lacak:hover,
        #btn-tambah-marker:hover {
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
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
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
    @include('layouts.navbar')

    <br>
    <div class="py-30 px-20">
        <button id="btn-lacak" class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500">📍 Lacak Lokasi Saya</button>
        <button id="btn-tambah-marker" class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500 ">➕ Tambah Marker</button>

        <div id="map"></div>
        <div id="infoBox">
            <i class="fa fa-trash"></i> <span id="infoText">Tempat Sampah</span>
        </div>
    </div>
    @include('layouts.footer')
    <script>
        var map = L.map('map', {
            center: [-6.7342685, 108.5380800],
            zoom: 15,
            minZoom: 14,
            maxZoom: 18
        });

        // Basemaps
        var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);
        var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');
        var esriStreet = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Street_Map/MapServer/tile/{z}/{y}/{x}');

        // Layer tempat sampah
        var tempatSampahLayer = L.layerGroup().addTo(map);
        var overlays = {
            "Tempat Sampah Umum": tempatSampahLayer
        };

        // Kontrol layer
        L.control.layers({
            "Satellite": satellite,
            "OSM": openStreetMap
        }, overlays).addTo(map);

        // Tambah search lokasi (geocoder)
        L.Control.geocoder({
            defaultMarkGeocode: true
        }).addTo(map);

        // Icon custom
        const tempatSampahIcon = L.divIcon({
            className: '',
            html: `
                <div style="position: relative; pointer-events: auto; cursor: pointer; width: 20px; height: 20px; background-color: #4CAF50; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 0 3px rgba(0,0,0,0.5);">
                    <i class="fa fa-trash" style="color: white; font-size: 10px;"></i>
                    <div style="position: absolute; bottom: -6px; width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid #4CAF50;"></div>
                </div>
            `,
            iconSize: [20, 26],
            iconAnchor: [10, 26],
            popupAnchor: [0, -20]
        });

        // Ambil marker dari database
        fetch("/markers")
            .then(res => res.json())
            .then(data => {
                data.forEach(marker => {
                    const m = L.marker([marker.latitude, marker.longitude], {
                        icon: tempatSampahIcon
                    }).addTo(tempatSampahLayer);
                    m.bindPopup(marker.description || "Tempat Sampah");
                });
            });

        // Tambah marker manual
        let isAddingMarker = false;
        document.getElementById('btn-tambah-marker').addEventListener('click', () => {
            isAddingMarker = true;
            document.getElementById('map').classList.add('crosshair-cursor');
        });

        map.on('click', function(e) {
            if (!isAddingMarker) return;

            const {
                lat,
                lng
            } = e.latlng;
            const marker = L.marker([lat, lng], {
                icon: tempatSampahIcon
            }).addTo(tempatSampahLayer);
            marker.bindPopup("Tempat Sampah").openPopup();

            fetch("/markers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        latitude: lat,
                        longitude: lng,
                        description: "Tempat Sampah",
                        status: "aktif"
                    })
                })
                .then(res => res.json())
                .then(data => console.log(data.message))
                .catch(err => console.error(err));

            isAddingMarker = false;
            document.getElementById('map').classList.remove('crosshair-cursor');
        });

        // Lacak lokasi saya
        document.getElementById('btn-lacak').addEventListener('click', function() {
            map.locate({
                setView: true,
                maxZoom: 17
            });

            map.on('locationfound', function(e) {
                const radius = 5;

                L.marker(e.latlng).addTo(map)
                    .bindPopup("Lokasi Saat Ini").openPopup();

                L.circle(e.latlng, {
                    radius: radius,
                    color: '#136AEC',
                    fillColor: '#136AEC',
                    fillOpacity: 0.3
                }).addTo(map);
            });

        });
    </script>
</body>

</html>