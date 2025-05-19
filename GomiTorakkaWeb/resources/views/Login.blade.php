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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif

    <style>
        .login-container {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
        }

        .btn-login {
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .btn-login:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
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
    </style>
</head>

<body class="min-h-screen bg-gray-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Animated Logo/Icon -->
        <div class="flex justify-center mb-8">
            <div class="floating animate__animated animate__fadeIn">
                <img src="{{ asset('images/gomitorakko.png') }}" alt="" style="width: 120px;">
            </div>
        </div>

        <!-- Login Form -->
        <form action="{{ route('form_login.submit') }}" method="post" class="animate__animated animate__fadeInUp">
            @csrf
            <div class="login-container bg-white rounded-xl shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-emerald-200/50">
                <div class="p-8">
                    <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Welcome Back</h1>
                    <p class="text-center text-gray-500 mb-8">Log in to your account</p>

                    <div class="space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                            <input type="text" name="username"
                                class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                placeholder="Enter your username" required>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                            <input type="password" name="password"
                                class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                placeholder="Enter your password" required>
                        </div>

                        <div class="flex items-center justify-between">
                            <div class="flex items-center">

                            </div>


                        </div>

                        <button type="submit" class="btn-login w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline">
                            Login
                        </button>
                    </div>
                </div>

                <div class="px-8 py-4 bg-gray-50 text-center">
                    <p class="text-gray-600">Don't have an account?
                        <a href="/register" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-300">Register here</a>
                    </p>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        // Add some interactive animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-field');

            inputs.forEach(input => {
                // Add focus/blur effects
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('animate__animated', 'animate__pulse');
                });

                input.addEventListener('blur', function() {
                    this.parentNode.classList.remove('animate__animated', 'animate__pulse');
                });
            });

            // Form submission animation
            const form = document.querySelector('form');
            form.addEventListener('submit', function(e) {
                const btn = this.querySelector('button[type="submit"]');
                btn.classList.add('animate__animated', 'animate__pulse');
                setTimeout(() => {
                    btn.classList.remove('animate__animated', 'animate__pulse');
                }, 1000);
            });
        });
    </script>
</body>

</html>