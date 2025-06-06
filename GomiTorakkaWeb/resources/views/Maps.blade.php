<!DOCTYPE html>
<html data-theme="emerald">

<head>
    <title>Waste Management Map - GomiTorakka</title>
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">

    <!-- Leaflet CSS & JS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.3/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.3/dist/leaflet.js"></script>

    <!-- Leaflet Geocoder -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Animate.css -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />

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
        :root {
            --primary-color: #10b981;
            --primary-hover: #059669;
            --danger-color: #ef4444;
            --warning-color: #f59e0b;
        }

        body {
            font-family: 'Instrument Sans', 'Roboto', sans-serif;
            overflow-x: hidden;
        }

        #map {
            height: 80vh;
            min-height: 600px;
            border-radius: 16px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            z-index: 0;
            transition: all 0.3s ease;
        }

        #map:hover {
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
        }

        .map-container {
            position: relative;
            padding: 0;
            margin: 0 auto;
            max-width: 1400px;
        }

        .map-controls {
            position: absolute;
            bottom: 20px;
            /* ubah dari top ke bottom */
            left: 20px;
            /* ubah dari right ke left */
            z-index: 1000;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }


        .map-btn {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: white;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            color: var(--primary-color);
            font-size: 20px;
            border: none;
        }

        .map-btn:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.2);
            background: var(--primary-color);
            color: white;
        }

        .map-btn.active {
            background: var(--primary-color);
            color: white;
            animation: pulse 2s infinite;
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
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            padding: 12px 16px;
            z-index: 1000;
            display: none;
            align-items: center;
            gap: 12px;
            backdrop-filter: blur(5px);
            background-color: rgba(255, 255, 255, 0.9);
            border: 1px solid rgba(0, 0, 0, 0.1);
        }

        #infoBox i {
            color: var(--primary-color);
            font-size: 22px;
        }

        #infoText {
            font-weight: 500;
            color: #333;
        }

        .leaflet-popup-content-wrapper {
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15) !important;
            padding: 0 !important;
            overflow: hidden;
        }

        .leaflet-popup-content {
            margin: 0 !important;
            width: 100% !important;
        }

        .popup-form {
            padding: 16px;
            min-width: 250px;
        }

        .popup-form label {
            display: block;
            font-weight: 600;
            margin-bottom: 8px;
            color: #333;
        }

        .popup-form input {
            width: 100%;
            padding: 10px 12px;
            border: 1px solid #ddd;
            border-radius: 8px;
            margin-bottom: 16px;
            transition: all 0.3s;
            font-size: 14px;
        }

        .popup-form input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.2);
        }

        .popup-buttons {
            display: flex;
            gap: 10px;
        }

        .popup-btn {
            flex: 1;
            padding: 10px;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            border: none;
            font-size: 14px;
        }

        .popup-btn-save {
            background: var(--primary-color);
            color: white;
        }

        .popup-btn-save:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
        }

        .popup-btn-cancel {
            background: #f1f1f1;
            color: #555;
        }

        .popup-btn-cancel:hover {
            background: #e0e0e0;
            transform: translateY(-2px);
        }

        .loading-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2000;
            border-radius: 16px;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s;
        }

        .loading-overlay.active {
            opacity: 1;
            pointer-events: auto;
        }

        .loading-spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
            }

            70% {
                box-shadow: 0 0 0 10px rgba(16, 185, 129, 0);
            }

            100% {
                box-shadow: 0 0 0 0 rgba(16, 185, 129, 0);
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .floating {
            animation: float 3s ease-in-out infinite;
        }

        .marker-pulse {
            animation: pulse 2s infinite;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            #map {
                height: 70vh;
                min-height: 400px;
                border-radius: 0;
            }

            .map-controls {
                top: 10px;
                right: 10px;
            }

            .map-btn {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <div class="container mx-auto px-4 py-8 animate_animated animate_fadeIn">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Waste Management Map</h1>
            <p class="text-lg text-gray-600">Track and manage waste collection points in your area</p>
        </div>

        <div class="map-container animate_animated animate_fadeInUp">
            <!-- Loading Overlay -->
            <div class="loading-overlay" id="loadingOverlay">
                <div class="loading-spinner"></div>
            </div>

            <!-- Map Controls -->
            <div class="map-controls">
                <button id="btn-lacak" class="map-btn" title="Locate Me">
                    <i class="fas fa-location-arrow"></i>
                </button>
                <button id="btn-tambah-marker" class="map-btn" title="Add Waste Point">
                    <i class="fas fa-plus"></i>
                </button>
            </div>

            <!-- The Map -->
            <div id="map"></div>

            <!-- Info Box -->
            <div id="infoBox" class="animate_animated animate_fadeIn">
                <i class="fas fa-trash-alt"></i>
                <span id="infoText">Waste Collection Point</span>
            </div>

            <div id="markerFormOverlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; display: none; background: rgba(0,0,0,0.3); z-index: 1999;">
                <div id="markerFormDrawer" style="position: fixed; top: 0; left: -400px; width: 350px; height: 100%; background: white; box-shadow: 2px 0 10px rgba(0,0,0,0.3); z-index: 2000; padding: 20px; transition: left 0.3s ease-in-out;">
                    <label>Status:</label><br>
                    <div id="markerStatus" style="margin: 10px 0 20px 0; padding: 10px; border-radius: 5px; font-weight: 600; color: white; width: fit-content;">
                        <!-- status text & warna akan di-set lewat JS -->
                    </div>
                    <label for="markerDesc">Deskripsi:</label>
                    <textarea id="markerDesc" placeholder="Contoh: Dekat pos ronda" style="width: 100%; margin: 10px 0 20px 0; padding: 10px; border: 1px solid #ccc; border-radius: 5px; resize: vertical; min-height: 300px;"></textarea>
                    <div style="display: flex; justify-content: flex-end; gap: 10px;">
                        <button id="cancelDrawerBtn" style="background-color: #ccc; border: none; padding: 10px 15px; border-radius: 5px;">Batal</button>
                        <button id="submitDrawerBtn" style="background-color: #4CAF50; color: white; border: none; padding: 10px 15px; border-radius: 5px;">Simpan</button>
                    </div>
                </div>
            </div>
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
                        icon: createTempatSampahIcon(marker.status)
                    }).addTo(tempatSampahLayer);

                    m.description = marker.description || "Tempat Sampah";

                    m.on("click", function() {
                        selectedLatLng = {
                            lat: marker.latitude,
                            lng: marker.longitude
                        };
                        descInput.value = m.description;
                        openDrawer(true, marker.status); // buka drawer mode VIEW + status
                    });

                });
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

        let isAddingMarker = false;
        let tempMarker = null;
        let selectedLatLng = null;

        const drawer = document.getElementById("markerFormDrawer");
        const descInput = document.getElementById("markerDesc");
        const cancelBtn = document.getElementById("cancelDrawerBtn");
        const submitBtn = document.getElementById("submitDrawerBtn");

        function createTempatSampahIcon(status) {
            let color;
            switch (status) {
                case "approved":
                    color = "#4CAF50"; // hijau
                    break;
                case "pending":
                    color = "#FFC107"; // kuning
                    break;
                default:
                    color = "#FF0000"; // abu-abu
            }

            return L.divIcon({
                className: '',
                html: ` 
            <div style="position: relative; pointer-events: auto; cursor: pointer; width: 20px; height: 20px; background-color: ${color}; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 0 3px rgba(0,0,0,0.5);">
                <i class="fa fa-trash" style="color: white; font-size: 10px;"></i>
                <div style="position: absolute; bottom: -6px; width: 0; height: 0; border-left: 6px solid transparent; border-right: 6px solid transparent; border-top: 6px solid ${color};"></div>
            </div>
        `,
                iconSize: [20, 26],
                iconAnchor: [10, 26],
                popupAnchor: [0, -20]
            });
        }

        let isViewMode = false;

        function openDrawer(isView = false, status = null) {
            document.getElementById("markerFormOverlay").style.display = "block";
            setTimeout(() => {
                drawer.style.left = "0";
            }, 10); // Delay kecil biar animasi jalan

            isViewMode = isView;

            if (isViewMode) {
                descInput.readOnly = true;
                submitBtn.style.display = "none";
                cancelBtn.style.display = "none";

                // Tampilkan status dengan warna
                const statusDiv = document.getElementById("markerStatus");
                if (status) {
                    let bgColor;
                    let text;
                    switch (status.toLowerCase()) {
                        case "approved":
                            bgColor = "#4CAF50"; // hijau
                            text = "Approved";
                            break;
                        case "pending":
                            bgColor = "#FFC107"; // kuning
                            text = "Pending";
                            break;
                        case "rejected":
                            bgColor = "#F44336"; // merah
                            text = "Rejected";
                            break;
                        default:
                            bgColor = "#888";
                            text = "Unknown";
                    }
                    statusDiv.style.backgroundColor = bgColor;
                    statusDiv.textContent = text;
                    statusDiv.style.display = "block";
                } else {
                    statusDiv.style.display = "none";
                }
            } else {
                descInput.readOnly = false;
                submitBtn.style.display = "inline-block";
                cancelBtn.style.display = "inline-block";

                // Sembunyikan status kalau form input baru
                const statusDiv = document.getElementById("markerStatus");
                statusDiv.style.display = "none";

                descInput.value = "";
            }
        }


        function closeDrawer() {
            drawer.style.left = "-400px";
            setTimeout(() => {
                document.getElementById("markerFormOverlay").style.display = "none";
            }, 300); // Tunggu animasi selesai

            if (tempMarker) {
                map.removeLayer(tempMarker);
                tempMarker = null;
            }
            selectedLatLng = null;
            isAddingMarker = false;
            isViewMode = false;
            document.getElementById('map').classList.remove('crosshair-cursor');
        }



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
            selectedLatLng = e.latlng;

            tempMarker = L.marker([lat, lng], {
                icon: createTempatSampahIcon("pending")
            }).addTo(tempatSampahLayer);

            openDrawer();
        });

        cancelBtn.addEventListener("click", () => {
            closeDrawer();
        });

        submitBtn.addEventListener("click", () => {
            const desc = descInput.value.trim();
            if (!desc || !selectedLatLng) {
                alert("Deskripsi tidak boleh kosong.");
                return;
            }

            fetch("/markers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({
                        latitude: selectedLatLng.lat,
                        longitude: selectedLatLng.lng,
                        description: desc,
                        status: "pending"
                    })
                })
                .then(res => res.json())
                .then(data => {
                    // Hapus tempMarker lama
                    if (tempMarker) {
                        map.removeLayer(tempMarker);
                        tempMarker = null;
                    }

                    // Tutup drawer dan reset form
                    closeDrawer();

                    // Refresh halaman
                    location.reload();
                })
                .catch(err => {
                    alert("Gagal menyimpan marker.");
                    console.error(err);
                });
        });



        document.getElementById("markerFormOverlay").addEventListener("click", function(e) {
            if (!drawer.contains(e.target)) {
                closeDrawer();
            }
        });
    </script>
</body>

</html>