<!DOCTYPE html>
<html data-theme="emerald">

<head>
    <meta name="is-logged-in" content="{{ session()->has('uid') ? 'true' : 'false' }}">

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
            margin: 0;
            padding: 0;
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
            left: 20px;
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
            transform: translateY(-3px);
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
                bottom: 10px;
                left: 10px;
            }

            .map-btn {
                width: 44px;
                height: 44px;
                font-size: 18px;
            }

            #markerFormDrawer {
                width: 85%;
                left: -85%;
            }
        }

        /* Form drawer styles */
        #markerFormOverlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            display: none;
            background: rgba(0, 0, 0, 0.3);
            z-index: 1999;
        }

        #markerFormDrawer {
            position: fixed;
            top: 0;
            left: -400px;
            width: 350px;
            height: 100%;
            background: white;
            box-shadow: 2px 0 10px rgba(0, 0, 0, 0.3);
            z-index: 2000;
            padding: 20px;
            transition: left 0.3s ease-in-out;
            overflow-y: auto;
        }

        #markerStatus {
            margin: 10px 0 20px 0;
            padding: 10px;
            border-radius: 5px;
            font-weight: 600;
            color: white;
            width: fit-content;
        }

        #markerDesc {
            width: 100%;
            margin: 10px 0 20px 0;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            min-height: 100px;
        }

        .drawer-footer {
            display: flex;
            justify-content: flex-end;
            gap: 10px;
            margin-top: 20px;
        }

        .drawer-btn {
            padding: 10px 15px;
            border-radius: 5px;
            border: none;
            cursor: pointer;
            font-weight: 600;
        }

        .drawer-btn-cancel {
            background-color: #ccc;
            color: #333;
        }

        .drawer-btn-submit {
            background-color: #4CAF50;
            color: white;
        }

        /* Image preview */
        .image-preview-container {
            margin-top: 15px;
            display: none;
        }

        .image-preview-title {
            font-weight: 600;
            margin-bottom: 5px;
        }

        .image-preview {
            max-width: 100%;
            max-height: 200px;
            border-radius: 8px;
            border: 1px solid #ddd;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')

    <div class="container mx-auto px-4 py-8 animate__animated animate__fadeIn">
        <div class="text-center mb-8">
            <h1 class="text-4xl font-bold text-gray-800 mb-2">Waste Management Map</h1>
            <p class="text-lg text-gray-600">Track and manage waste collection points in your area</p>
        </div>

        <div class="map-container animate__animated animate__fadeInUp">
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
            <div id="infoBox" class="animate__animated animate__fadeIn">
                <i class="fas fa-trash-alt"></i>
                <span id="infoText">Waste Collection Point</span>
            </div>

            <!-- Marker Form Drawer -->
            <div id="markerFormOverlay">
                <div id="markerFormDrawer">
                    <h3 class="text-xl font-bold mb-4">Waste Point Details</h3>

                    <label>Status:</label>
                    <!-- Image preview container -->
                    <div class="image-preview-container" id="imagePreviewContainer">
                        <div class="image-preview-title">Image Preview:</div>
                        <img id="imagePreview" class="image-preview" />
                    </div>
                    <div id="markerStatus">
                        <!-- Status will be set via JS -->
                    </div>

                    <label for="markerDesc">Description:</label>
                    <textarea id="markerDesc" placeholder="e.g., Near the guard post"></textarea>

                    <div class="mb-4">
                        <label for="imageInput" class="block text-sm font-medium text-gray-700 mb-1">Upload Marker Image</label>
                        <label for="imageInput" class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 text-gray-400 mb-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                <p class="text-sm text-gray-500">Click to upload</p>
                            </div>
                            <input id="imageInput" type="file" accept="image/*" class="hidden" />
                        </label>
                    </div>

                    <input type="hidden" id="croppedImageFilename" />

                    <div class="drawer-footer">
                        <button id="cancelDrawerBtn" class="drawer-btn drawer-btn-cancel">Cancel</button>
                        <button id="submitDrawerBtn" class="drawer-btn drawer-btn-submit">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script>
        // Initialize map
        var map = L.map('map', {
            center: [-6.7342685, 108.5380800],
            zoom: 15,
            minZoom: 14,
            maxZoom: 18
        });

        // Basemaps
        var satellite = L.tileLayer('https://server.arcgisonline.com/ArcGIS/rest/services/World_Imagery/MapServer/tile/{z}/{y}/{x}').addTo(map);
        var openStreetMap = L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png');

        // Waste collection layer
        var tempatSampahLayer = L.layerGroup().addTo(map);
        var overlays = {
            "Waste Collection Points": tempatSampahLayer
        };

        // Layer control
        L.control.layers({
            "Satellite": satellite,
            "OSM": openStreetMap
        }, overlays).addTo(map);

        // Add geocoder
        L.Control.geocoder({
            defaultMarkGeocode: true
        }).addTo(map);

        // Custom icon function
        function createTempatSampahIcon(status) {
            let color;
            switch (status) {
                case "approved":
                    color = "#4CAF50"; // green
                    break;
                case "pending":
                    color = "#FFC107"; // yellow
                    break;
                case "rejected":
                    color = "#F44336"; // red
                    break;
                default:
                    color = "#9E9E9E"; // gray
            }

            return L.divIcon({
                className: '',
                html: `
                    <div style="position: relative; pointer-events: auto; cursor: pointer; width: 24px; height: 24px; background-color: ${color}; border-radius: 50%; display: flex; justify-content: center; align-items: center; box-shadow: 0 0 5px rgba(0,0,0,0.5);">
                        <i class="fa fa-trash" style="color: white; font-size: 12px;"></i>
                        <div style="position: absolute; bottom: -8px; width: 0; height: 0; border-left: 8px solid transparent; border-right: 8px solid transparent; border-top: 8px solid ${color};"></div>
                    </div>
                `,
                iconSize: [24, 32],
                iconAnchor: [12, 32],
                popupAnchor: [0, -25]
            });
        }

        // Show loading overlay
        function showLoading() {
            document.getElementById('loadingOverlay').classList.add('active');
        }

        // Hide loading overlay
        function hideLoading() {
            document.getElementById('loadingOverlay').classList.remove('active');
        }

        // Fetch markers from server
        function fetchMarkers() {
            showLoading();
            fetch("/markers")
                .then(res => res.json())
                .then(data => {
                    tempatSampahLayer.clearLayers();

                    data.forEach(marker => {
                        const m = L.marker([marker.latitude, marker.longitude], {
                            icon: createTempatSampahIcon(marker.status)
                        }).addTo(tempatSampahLayer);

                        m.description = marker.description || "Waste Collection Point";
                        m.status = marker.status;
                        m.image = marker.image || null;

                        m.on("click", function() {
                            showMarkerDetails(marker);
                        });
                    });
                })
                .catch(err => {
                    console.error("Error fetching markers:", err);
                })
                .finally(() => {
                    hideLoading();
                });
        }

        // Show marker details in drawer
        function showMarkerDetails(marker) {
            selectedMarker = marker;

            // Set drawer content
            document.getElementById('markerDesc').value = marker.description || '';
            document.getElementById('croppedImageFilename').value = marker.image || '';

            // Set status display
            const statusDiv = document.getElementById('markerStatus');
            let statusText, statusColor;

            switch (marker.status.toLowerCase()) {
                case 'approved':
                    statusText = 'Approved';
                    statusColor = '#4CAF50';
                    break;
                case 'pending':
                    statusText = 'Pending Approval';
                    statusColor = '#FFC107';
                    break;
                case 'rejected':
                    statusText = 'Rejected';
                    statusColor = '#F44336';
                    break;
                default:
                    statusText = 'Unknown';
                    statusColor = '#9E9E9E';
            }

            statusDiv.textContent = statusText;
            statusDiv.style.backgroundColor = statusColor;

            // Show image preview if exists
            const previewContainer = document.getElementById('imagePreviewContainer');
            const imagePreview = document.getElementById('imagePreview');

            if (marker.image_url) {
                imagePreview.src = marker.image_url;
                previewContainer.style.display = 'block';
            } else if (marker.image) {
                imagePreview.src = '/storage/marker-images/' + marker.image;
                previewContainer.style.display = 'block';
            } else {
                previewContainer.style.display = 'none';
            }

            // Open drawer
            openDrawer(true);
        }

        // Locate user
        document.getElementById('btn-lacak').addEventListener('click', function() {
            map.locate({
                setView: true,
                maxZoom: 17
            });

            map.on('locationfound', function(e) {
                const radius = 5;

                L.marker(e.latlng).addTo(map)
                    .bindPopup("Your Location").openPopup();

                L.circle(e.latlng, {
                    radius: radius,
                    color: '#136AEC',
                    fillColor: '#136AEC',
                    fillOpacity: 0.3
                }).addTo(map);
            });
        });

        // Variables
        let isAddingMarker = false;
        let tempMarker = null;
        let selectedLatLng = null;
        let selectedMarker = null;

        // Drawer functions
        function openDrawer(isViewMode = false) {
            const drawer = document.getElementById('markerFormDrawer');
            const overlay = document.getElementById('markerFormOverlay');
            const descInput = document.getElementById('markerDesc');
            const statusDiv = document.getElementById('markerStatus');
            const submitBtn = document.getElementById('submitDrawerBtn');

            overlay.style.display = 'block';
            setTimeout(() => {
                drawer.style.left = '0';
            }, 10);

            if (isViewMode) {
                // View mode - disable editing
                descInput.readOnly = true;
                document.getElementById('imageInput').disabled = true;
                submitBtn.style.display = 'none';
                statusDiv.style.display = 'block';
            } else {
                // Edit/Add mode - enable editing
                descInput.readOnly = false;
                document.getElementById('imageInput').disabled = false;
                submitBtn.style.display = 'block';
                statusDiv.style.display = 'none';
                document.getElementById('imagePreviewContainer').style.display = 'none';
            }
        }

        function closeDrawer() {
            const drawer = document.getElementById('markerFormDrawer');
            const overlay = document.getElementById('markerFormOverlay');

            drawer.style.left = '-400px';
            setTimeout(() => {
                overlay.style.display = 'none';
            }, 300);

            // Reset form
            document.getElementById('markerDesc').value = '';
            document.getElementById('imageInput').value = '';
            document.getElementById('croppedImageFilename').value = '';
            document.getElementById('imagePreviewContainer').style.display = 'none';

            // Cleanup
            if (tempMarker) {
                map.removeLayer(tempMarker);
                tempMarker = null;
            }

            isAddingMarker = false;
            document.getElementById('map').classList.remove('crosshair-cursor');
        }

        const isLoggedIn = document.querySelector('meta[name="is-logged-in"]').getAttribute('content') === 'true';

        document.getElementById('btn-tambah-marker').addEventListener('click', () => {
            if (!isLoggedIn) {
                window.location.href = '/login'; // arahkan ke halaman login
                return;
            }

            isAddingMarker = true;
            document.getElementById('map').classList.add('crosshair-cursor');
            document.getElementById('infoText').textContent = 'Click on map to add waste point';
            document.getElementById('infoBox').style.display = 'flex';

            setTimeout(() => {
                document.getElementById('infoBox').style.display = 'none';
            }, 3000);
        });



        // Map click handler
        map.on('click', function(e) {
            if (!isAddingMarker) return;

            const {
                lat,
                lng
            } = e.latlng;
            selectedLatLng = e.latlng;

            // Remove previous temp marker if exists
            if (tempMarker) {
                map.removeLayer(tempMarker);
            }

            // Create new temp marker
            tempMarker = L.marker([lat, lng], {
                icon: createTempatSampahIcon("pending")
            }).addTo(tempatSampahLayer);

            // Open form drawer
            openDrawer();
        });

        // Cancel drawer button
        document.getElementById('cancelDrawerBtn').addEventListener('click', () => {
            closeDrawer();
        });

        // Submit drawer button
        document.getElementById('submitDrawerBtn').addEventListener('click', () => {
            const desc = document.getElementById('markerDesc').value.trim();
            const image = document.getElementById('croppedImageFilename').value;

            if (!desc) {
                alert("Description is required");
                return;
            }

            if (!selectedLatLng) {
                alert("Please select a location on the map");
                return;
            }

            const markerData = {
                latitude: selectedLatLng.lat,
                longitude: selectedLatLng.lng,
                description: desc,
                status: "pending",
                image: image
            };

            saveMarker(markerData);
        });

        // Save marker to server
        function saveMarker(markerData) {
            showLoading();

            if (!selectedLatLng || isNaN(selectedLatLng.lat) || isNaN(selectedLatLng.lng)) {
                alert('Lokasi tidak valid. Silakan pilih lokasi di peta.');
                hideLoading();
                return;
            }

            fetch("/markers", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        latitude: selectedLatLng.lat,
                        longitude: selectedLatLng.lng,
                        description: markerData.description,
                        image: markerData.image
                    })
                })
                .then(async response => {
                    const contentType = response.headers.get("content-type");
                    if (contentType && contentType.indexOf("application/json") !== -1) {
                        return response.json();
                    } else {
                        const text = await response.text();
                        throw new Error(text.includes('<!DOCTYPE html>') ?
                            'Anda perlu login terlebih dahulu' : text);
                    }
                })
                .then(data => {
                    if (!data.latitude || !data.longitude) {
                        throw new Error('Invalid marker data from server');
                    }

                    const newMarker = L.marker([data.latitude, data.longitude], {
                        icon: createTempatSampahIcon(data.status)
                    }).addTo(tempatSampahLayer);

                    newMarker.description = data.description;
                    newMarker.status = data.status;
                    newMarker.image = data.image;

                    newMarker.on("click", function() {
                        showMarkerDetails(data);
                    });

                    closeDrawer();
                })
                .catch(error => {
                    console.error("Error saving marker:", error);
                    alert("Gagal menyimpan marker: " + error.message);
                })
                .finally(() => {
                    hideLoading();
                });
        }

        // Image upload handler
        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (!file) return;

            // Validasi tipe file
            const validImageTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
            if (!validImageTypes.includes(file.type)) {
                alert('Hanya file JPG, PNG, atau GIF yang diizinkan');
                this.value = '';
                return;
            }

            // Validasi ukuran file (max 2MB)
            if (file.size > 2 * 1024 * 1024) {
                alert('Ukuran file maksimal 2MB');
                this.value = '';
                return;
            }

            showLoading();

            const formData = new FormData();
            formData.append('image', file);
            formData.append('_token', document.querySelector('meta[name="csrf-token"]').content);

            fetch('/upload-marker-image', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        return response.json().then(err => {
                            throw new Error(err.message || 'Server error');
                        });
                    }
                    return response.json();
                })
                .then(data => {
                    if (data.success && data.filename) {
                        document.getElementById('croppedImageFilename').value = data.filename;

                        // Show preview
                        const previewContainer = document.getElementById('imagePreviewContainer');
                        const imagePreview = document.getElementById('imagePreview');
                        imagePreview.src = data.path;
                        previewContainer.style.display = 'block';
                    } else {
                        throw new Error(data.message || 'Upload gambar gagal');
                    }
                })
                .catch(error => {
                    console.error('Error uploading image:', error);
                    alert('Gagal mengupload gambar: ' + (error.message || 'Terjadi kesalahan'));
                })
                .finally(() => {
                    hideLoading();
                });
        });

        // Close drawer when clicking outside
        document.getElementById('markerFormOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeDrawer();
            }
        });

        // Initialize
        document.addEventListener('DOMContentLoaded', function() {
            fetchMarkers();
        });
    </script>
</body>

</html>