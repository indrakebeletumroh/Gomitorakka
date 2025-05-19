<!DOCTYPE html>
<html lang="en" data-theme="emerald">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - GomiTorakka</title>
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">
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
</head>
<body>
    <div class="flex-row">
        <form action="{{ route('form_login.submit') }}" method="post">
            @csrf
            <div class="flex justify-center pt-50">
            <fieldset class="fieldset bg-base-100 border-base-300 rounded-md w-xs border p-4 gap-2">
            <legend class="fieldset-legend text-3xl">Login</legend>
            <img src="" alt="">
            <label class="label">Username</label>
            <input type="text" class="input focus:outline-2 focus:outline-blue-600 focus:-outline-offset-3" name="username" placeholder="Username" required/>

            <label class="label">Password</label>
            <input type="password" class="input focus:outline-2 focus:outline-blue-600 focus:-outline-offset-3" name="password" placeholder="Password" required/>
            <p class="mt-6 mb-5">Dont Have An Account? <a href="/register" class="text-blue-400">Register</a></p>
            <button class="btn btn-primary  text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:scale-102 hover:-rotate-3 hover:duration-1200">Login</button>
            </fieldset>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</body>
</html>