<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - {{ Session::get('username') }}</title>
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif

    <style>
        /* Custom Styles */
    </style>

</head>

<body>
    @include('layouts.navbar')
    <!-- Profile Section -->
    <div class="flex justify-center items-center py-8 pt-20">
        <div class="bg-white p-8 rounded-lg shadow-lg w-full max-w-lg">
            <div class="flex flex-col items-center">
                <h1 class="text-4xl font-semibold text-gray-800 mb-6">Profile</h1>
                <div class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center mb-2">
                    <!-- Ambil inisial dari username -->
                    <img id="previewImage"
                        src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}"
                        alt="Profile Picture"
                        class="rounded-full">
                </div>
                <p class="text-gray-400 mb-8">Last Online {{ now()->diffForHumans() }}</p>
            </div>

            <div class="space-y-4 text-gray-500">
                <div>
                    <p>UID</p>
                    <span class="font-bold text-gray-800">{{ Session::get('uid') }}</span>
                </div>
                <div>
                    <p>Username</p>
                    <span class="font-bold text-gray-800">{{ Session::get('username') }}</span>
                </div>
                <div>
                    <p>Age</p>
                    <span class="font-bold text-gray-800">{{ Session::get('age') }}</span>
                </div>
                <div>
                    <p>Phone Number</p>
                    <span class="font-bold text-gray-800">{{ Session::get('phone_number') }}</span>
                </div>
                <div>
                    <p>Email</p>
                    <span class="font-bold text-gray-800">{{ Session::get('email') }}</span>
                </div>
                <div>
                    <p>Member Since</p>
                    <span class="font-bold text-gray-800">
                        {{ \Carbon\Carbon::parse(Session::get('created_at'))->format('d F Y') }}
                    </span>
                </div>
            </div>

            <div class="flex justify-center mt-10 gap-5">
                <a href="/edit-profile" class="btn bg-blue-400 text-base-100 w-40 hover:text-blue-400 hover:-rotate-3 hover:duration-800 hover:bg-base-100 hover:border-solid">
                    Edit Profile
                </a>
                <a href="/logout" class="btn bg-red-500 text-base-100 w-40 hover:text-red-500 hover:-rotate-3 hover:duration-800 hover:bg-base-100 hover:border-solid">
                    Log Out
                </a>
            </div>


            <div class="flex justify-between text-sm text-gray-400 mt-10">
                <p>Last Updated: {{ \Carbon\Carbon::parse(Session::get('updated_at'))->diffForHumans() }}</p>
                <p>Account Created: {{ \Carbon\Carbon::parse(Session::get('created_at'))->diffForHumans() }}</p>
            </div>
        </div>
    </div>

    @include('layouts.footer')
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>

</html>