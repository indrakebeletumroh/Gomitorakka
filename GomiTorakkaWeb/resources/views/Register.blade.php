<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - GomiTorakka</title>
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
    <!-- Styles / Scripts -->
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
    @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @else
    @endif

    <style>
        .split-layout {
            display: flex;
            min-height: 100vh;
        }

        .form-section {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 2rem;
        }

        .image-section {
            flex: 1;
            background: url('https://images.unsplash.com/photo-1466611653911-95081537e5b7?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1740&q=80') center/cover no-repeat;
            display: none;
        }

        .register-container {
            background: linear-gradient(135deg, rgba(16, 185, 129, 0.1) 0%, rgba(6, 182, 212, 0.1) 100%);
        }

        .input-field {
            transition: all 0.3s ease;
        }

        .input-field:focus {
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
        }

        .btn-register {
            transition: all 0.5s cubic-bezier(0.68, -0.55, 0.265, 1.55);
        }

        .btn-register:hover {
            transform: translateY(-3px) scale(1.02);
            box-shadow: 0 10px 20px -5px rgba(16, 185, 129, 0.4);
        }

        .password-strength {
            height: 4px;
            margin-top: 4px;
            background: #e0e0e0;
            border-radius: 2px;
            overflow: hidden;
        }

        .password-strength-bar {
            height: 100%;
            width: 0;
            transition: width 0.3s ease;
        }

        .password-requirements {
            margin-top: 8px;
            font-size: 0.85rem;
            color: #666;
        }

        .requirement {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .requirement i {
            margin-right: 8px;
            font-size: 0.8rem;
        }

        .valid {
            color: #10b981;
        }

        .invalid {
            color: #ef4444;
        }

        .password-wrapper {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #9ca3af;
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: #4b5563;
        }

        @media (min-width: 1024px) {
            .image-section {
                display: block;
            }
        }
    </style>
</head>

<body>

    <!-- Form Section -->
    <div class="form-section">
        <div class="w-full max-w-md">
            <!-- Animated Logo/Icon -->
            <div class="flex justify-center mb-8">
                <div class="animate__animated animate__fadeIn">
                    <img src="{{ asset('images/gomitorakko.png') }}" alt="" style="width: 120px;">
                </div>
            </div>

            <!-- Registration Form -->
            <form action="{{ route('form_register.submit') }}" method="post" class="animate__animated animate__fadeInUp" id="registerForm">
                @csrf
                <div class="register-container bg-white rounded-xl shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-emerald-200/50">
                    <div class="p-8">
                        <h1 class="text-3xl font-bold text-center text-gray-800 mb-2">Create Account</h1>
                        <p class="text-center text-gray-500 mb-8">Join our green community today</p>

                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Username</label>
                                <input type="text" name="username"
                                    class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                    placeholder="Enter your username" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Age</label>
                                <input type="number" name="age" min="13" max="120"
                                    class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                    placeholder="Enter your age" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                                <input type="tel" name="phone_number"
                                    class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                    placeholder="Enter your phone number" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                                <input type="email" name="email"
                                    class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                    placeholder="Enter your email" required>
                            </div>

                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                                <div class="password-wrapper">
                                    <input type="password" name="password" id="password"
                                        class="input-field w-full px-4 py-3 rounded-lg border border-gray-300 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500 transition duration-300"
                                        placeholder="Enter your password (min 8 characters)" required
                                        minlength="8">
                                    <i class="toggle-password fas fa-eye" id="togglePassword"></i>
                                </div>
                                <div class="password-strength">
                                    <div class="password-strength-bar" id="passwordStrengthBar"></div>
                                </div>
                                <div class="password-requirements" id="passwordRequirements">
                                    <div class="requirement" id="lengthReq">
                                        <i class="fas" id="lengthIcon">•</i>
                                        <span>Minimum 8 characters</span>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn-register w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-3 px-4 rounded-lg focus:outline-none focus:shadow-outline mt-6">
                                Create Account
                            </button>
                        </div>
                    </div>

                    <div class="px-8 py-4 bg-gray-50 text-center">
                        <p class="text-gray-600">Already have an account?
                            <a href="/login" class="font-medium text-emerald-600 hover:text-emerald-500 transition-colors duration-300">Log in</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const passwordInput = document.getElementById('password');
            const passwordStrengthBar = document.getElementById('passwordStrengthBar');
            const lengthReq = document.getElementById('lengthReq');
            const lengthIcon = document.getElementById('lengthIcon');
            const togglePassword = document.getElementById('togglePassword');

            // Password visibility toggle
            togglePassword.addEventListener('click', function() {
                const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                passwordInput.setAttribute('type', type);
                this.classList.toggle('fa-eye');
                this.classList.toggle('fa-eye-slash');
            });

            // Password validation
            passwordInput.addEventListener('input', function() {
                const password = this.value;

                // Check minimum length
                const isLengthValid = password.length >= 8;

                // Update requirements display
                if (isLengthValid) {
                    lengthReq.classList.add('valid');
                    lengthReq.classList.remove('invalid');
                    lengthIcon.textContent = '✓';
                } else {
                    lengthReq.classList.add('invalid');
                    lengthReq.classList.remove('valid');
                    lengthIcon.textContent = '•';
                }

                // Update strength bar (simple version)
                const strength = Math.min(password.length / 8 * 100, 100);
                passwordStrengthBar.style.width = strength + '%';
                passwordStrengthBar.style.backgroundColor = strength < 50 ? '#ef4444' :
                    strength < 75 ? '#f59e0b' : '#10b981';
            });

            // Form submission validation
            const form = document.getElementById('registerForm');
            form.addEventListener('submit', function(e) {
                const password = passwordInput.value;

                if (password.length < 8) {
                    e.preventDefault();
                    passwordInput.focus();
                    passwordInput.classList.add('border-red-500');
                    alert('Password must be at least 8 characters long');
                }
            });

            // Input focus effects
            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentNode.classList.add('animate__animated', 'animate__pulse');
                });

                input.addEventListener('blur', function() {
                    this.parentNode.classList.remove('animate__animated', 'animate__pulse');
                });
            });
        });
    </script>
</body>

</html>