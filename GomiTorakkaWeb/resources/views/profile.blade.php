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
    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
        <style>
            /* Custom Styles */
        </style>
    @endif
</head>
<body>
@include('layouts.navbar')
<!-- Profile Section -->
<div class="flex justify-center items-center py-8 pt-40">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <div class="flex items-center space-x-4">
            <div class="w-16 h-16 rounded-full bg-gray-200 flex items-center justify-center">
                <span class="text-xl font-semibold text-gray-600">P</span>
            </div>
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Profile Name</h2>
                <p class="text-gray-500">Age: <span class="font-bold text-gray-800">25</span></p>
            </div>
        </div>
    </div>
</div>
@include('layouts.footer')
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>
</html>
