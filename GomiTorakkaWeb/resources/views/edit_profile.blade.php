<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Cropper.js -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.css" rel="stylesheet" />

    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* Custom Styles */
        .profile-picture-container {
            position: relative;
            width: 15rem;
            height: 15rem;
            border-radius: 9999px;
        }

        .profile-picture-container:hover .overlay {
            background-color: rgba(128, 128, 128, 0.5);
            border-radius: 9999px;
        }

        .overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 0;
            transition: opacity 0.3s;
            border-radius: 9999px;
        }

        .profile-picture-container:hover .overlay {
            opacity: 1;
        }

        .profile-picture-container img {
            border-radius: 9999px;
            object-fit: cover;
            width: 100%;
            height: 100%;
            transition: all 0.3s ease-in-out;
        }

        .profile-picture-container label {
            position: absolute;
            inset: 0;
            cursor: pointer;
        }

        /* ... (keep all previous styles the same) ... */

        /* Improved Cropper Modal */
        #cropperModal {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0, 0, 0, 0.7);
            z-index: 9999;
            display: none;
            justify-content: center;
            align-items: center;
            overflow: auto;
        }

        #cropperModal.active {
            display: flex;
        }

        #cropperModal .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 12px;
            width: 90%;
            max-width: 600px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        #cropperModal .cropper-container {
            max-height: 70vh;
            width: 100%;
        }

        #cropperModal .cropper-view-box,
        #cropperModal .cropper-face {
            border-radius: 0;
        }

        #cropperModal .cropper-modal {
            background: rgba(0, 0, 0, 0.7);
        }


        #cropperModal .cropper-bg {
            background-image: none;
            background-color: transparent;
        }

        #cropperModal .cropper-line {
            background-color: rgba(255, 255, 255, 0.4);
        }

        #cropperModal .cropper-point {
            background-color: #3b82f6;
            width: 10px;
            height: 10px;
            opacity: 1;
        }

        #cropperModal img {
            max-width: 100%;
            max-height: 60vh;
            display: block;
        }

        .modal-actions {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }

        .modal-actions button {
            padding: 8px 20px;
            border-radius: 6px;
            font-weight: 500;
            transition: all 0.2s;
        }

        .modal-actions .cancel-btn {
            background-color: #f3f4f6;
            color: #4b5563;
            border: 1px solid #e5e7eb;
        }

        .modal-actions .cancel-btn:hover {
            background-color: #e5e7eb;
        }

        .modal-actions .save-btn {
            background-color: #3b82f6;
            color: white;
            border: 1px solid #3b82f6;
        }

        .modal-actions .save-btn:hover {
            background-color: #2563eb;
        }

        .input-with-icon {
            position: relative;
        }

        .input-with-icon input {
            padding-right: 2.5rem;
        }

        .input-icon {
            position: absolute;
            right: 0.75rem;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #6b7280;
        }

        .input-icon:hover {
            color: #374151;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 1rem;
        }

        .save-button-container {
            grid-column: 1 / -1;
        }
    </style>
</head>

<body>
    @include('layouts.navbar')
    <!-- Profile Section -->
    <div class="flex justify-center items-center py-50">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-4xl">
            <form class="flex flex-col" enctype="multipart/form-data" method="POST">
                @csrf
                <h1 class="text-4xl font-semibold text-gray-800 mb-6 text-center">Profile</h1>

                <div class="flex flex-col md:flex-row gap-8">
                    <!-- Left Column - Profile Picture -->
                    <div class="flex flex-col items-center md:items-start space-y-4">
                        <div class="profile-picture-container mb-4">
                            <div class="overlay">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-white opacity-100" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M17.414 2.586a2 2 0 010 2.828l-8.5 8.5a1 1 0 01-.39.24l-3 1a1 1 0 01-1.264-1.265l1-3a1 1 0 01.24-.39l8.5-8.5a2 2 0 012.828 0zM5.207 12.207l-.707.707L4 14l1.086-.5.707-.707-.586-.586z" />
                                </svg>
                            </div>
                            <img id="previewImage" src="/images/download.jpg" alt="" class="rounded-full">
                            <label for="photo"></label>
                            <input id="photo" name="photo" type="file" accept="image/*" class="hidden" onchange="openCropModal(event)">
                        </div>

                        <p class="text-gray-400">Last Online 12 Minutes Ago</p>
                    </div>

                    <!-- Right Column - Form Inputs -->
                    <div class="flex-1">
                        <div class="form-grid">
                            <div>
                                <label class="text-sm text-gray-500">Nama</label>
                                <input type="text" name="name" value="Yanuar" class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Age</label>
                                <input type="text" name="age" value="25" class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            </div>
                            <div class="input-with-icon">
                                <label class="text-sm text-gray-500">UID</label>
                                <input type="text" name="uid" value="2147612847" readonly class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg bg-gray-100 cursor-not-allowed">
                                <div class="input-icon" onclick="copyToClipboard('uid')">
                                    <i class="far fa-copy"></i>
                                </div>
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Phone Number</label>
                                <input type="text" name="phone" value="+62 2193 2198" class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Gmail</label>
                                <input type="email" name="email" value="yanuar@example.com" class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            </div>
                            <div>
                                <label class="text-sm text-gray-500">Password</label>
                                <input type="password" name="password" placeholder="Enter new password" class="w-full p-3 text-lg font-semibold text-gray-800 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-300">
                            </div>

                            <!-- Save Changes Button - spans full width -->
                            <div class="save-button-container mt-4">
                                <button type="submit" class="w-full bg-blue-500 text-white py-3 px-4 rounded-lg font-semibold hover:bg-white hover:text-blue-500 border border-blue-500 transition duration-300 hover:-rotate-1">
                                    Save Changes
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-between text-sm text-gray-400 mt-8 w-full">
                    <p>Updated At</p>
                    <p>Account Created At</p>
                </div>
            </form>
        </div>
    </div>

    <!-- Cropper Modal -->
    <div id="cropperModal" class="fixed inset-0 bg-gray-900 bg-opacity-70 hidden items-center justify-center p-4">
        <div class="modal-content">
            <div class="cropper-container">
                <img id="cropImage" src="" alt="Image to crop">
            </div>
            <div class="modal-actions">
                <button type="button" class="cancel-btn" onclick="cancelCrop()">
                    <i class="fas fa-times mr-2"></i>Cancel
                </button>
                <button type="button" class="save-btn" onclick="cropImage()">
                    <i class="fas fa-check mr-2"></i>Save Changes
                </button>
            </div>
        </div>
    </div>

    @include('layouts.footer')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.12/cropper.min.js"></script>
    <script>
        let cropper;

        function openCropModal(event) {
            const file = event.target.files[0];
            if (!file) return;

            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.getElementById('cropImage');
                img.src = e.target.result;

                document.getElementById('cropperModal').classList.add('active');
                document.body.classList.add('modal-open');

                img.onload = function() {
                    if (cropper) {
                        cropper.destroy();
                    }
                    cropper = new Cropper(img, {
                        aspectRatio: 1,
                        viewMode: 1,
                        autoCropArea: 0.8,
                        background: false,
                        modal: true,
                        guides: false,
                        highlight: false,
                        cropBoxMovable: true,
                        cropBoxResizable: true,
                        toggleDragModeOnDblclick: false,
                    });
                };
            };
            reader.readAsDataURL(file);
        }

        function cropImage() {
            const canvas = cropper.getCroppedCanvas();
            const croppedImage = canvas.toDataURL('image/jpeg');

            const imgPreview = document.getElementById('previewImage');
            imgPreview.src = croppedImage;

            document.getElementById('cropperModal').classList.remove('active');
            document.body.classList.remove('modal-open');
        }

        function cancelCrop() {
            document.getElementById('cropperModal').classList.remove('active');
            document.body.classList.remove('modal-open');
        }

        function copyToClipboard(fieldName) {
            const input = document.querySelector(`input[name="${fieldName}"]`);
            input.select();
            document.execCommand('copy');

            // Show feedback
            const icon = input.nextElementSibling;
            icon.innerHTML = '<i class="fas fa-check"></i>';
            setTimeout(() => {
                icon.innerHTML = '<i class="far fa-copy"></i>';
            }, 2000);
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>

</html>