<!DOCTYPE html>
<html>

<head>
    <title>Maps - GomiTorakka</title>
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">

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
            z-index: 0;
            /* Make sure the map is in the background */
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

        #navbar {
            z-index: 10;
            /* Navbar stays on top */
        }

        .drawer-open {
            left: 0 !important;
        }

        .crosshair-cursor {
            cursor: crosshair;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <br>
    <div class=" px-20">
        <button id="btn-lacak" class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500">📍 Lacak Lokasi Saya</button>
        <button id="btn-tambah-marker" class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500 ">➕ Tambah Marker</button>

        <div id="map"></div>
        <div id="infoBox">
            <i class="fa fa-trash"></i> <span id="infoText">Tempat Sampah</span>
        </div>
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

                    // Tambahkan marker baru dengan icon pending
                    const newMarker = L.marker([selectedLatLng.lat, selectedLatLng.lng], {
                        icon: createTempatSampahIcon("pending")
                    }).addTo(tempatSampahLayer);
                    newMarker.bindPopup(desc);

                    closeDrawer();
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