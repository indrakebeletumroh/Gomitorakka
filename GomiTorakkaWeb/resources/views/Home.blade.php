<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GomiTorakka - Smart Waste Management</title>

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
    @keyframes fall {
      0% {
        transform: translateY(-100px) rotate(0deg);
        opacity: 1;
      }

      100% {
        transform: translateY(100vh) rotate(360deg);
        opacity: 0;
      }
    }

    .leaf {
      position: absolute;
      width: 40px;
      height: 40px;
      background-image: url('/images/leaf.png');
      background-size: contain;
      background-repeat: no-repeat;
      opacity: 0.8;
      animation: fall linear infinite;
    }

    .leaf:nth-child(1) {
      left: 10%;
      animation-duration: 10s;
      animation-delay: 0s;
    }

    .leaf:nth-child(2) {
      left: 30%;
      animation-duration: 12s;
      animation-delay: 2s;
    }

    .leaf:nth-child(3) {
      left: 50%;
      animation-duration: 14s;
      animation-delay: 4s;
    }

    .leaf:nth-child(4) {
      left: 70%;
      animation-duration: 11s;
      animation-delay: 1s;
    }

    .leaf:nth-child(5) {
      left: 90%;
      animation-duration: 13s;
      animation-delay: 3s;
    }

    .animate-fade-in-up {
      animation: fadeInUp 1s ease-out forwards;
    }

    @keyframes fadeInUp {
      0% {
        opacity: 0;
        transform: translateY(50px);
      }

      100% {
        opacity: 1;
        transform: translateY(0);
      }
    }

    .feature-icon {
      background: rgba(16, 185, 129, 0.1);
      width: 60px;
      height: 60px;
      border-radius: 16px;
      display: flex;
      align-items: center;
      justify-content: center;
      margin-right: 20px;
      flex-shrink: 0;
      transition: all 0.3s ease;
    }

    .feature-card:hover .feature-icon {
      background: rgba(16, 185, 129, 0.2);
      transform: scale(1.1);
    }

    .feature-card {
      transition: all 0.3s ease;
    }

    .feature-card:hover {
      transform: translateY(-5px);
    }
  </style>
</head>

<body class="animate-fade-in transition-all duration-500 ease-out">

  @include('layouts.navbar')

  <!-- Hero Section -->
  <div class="hero bg-emerald-100 min-h-screen pt-1">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
    </div>

    <div class="hero-content text-center z-10">
      <div class="max-w-md animate-fade-in-up">
        <h1 class="text-5xl font-bold">Hello {{ Session::get('username') }} <br>Welcome To Gomi<span class="text-green-700">Torakka</span></h1>
        <p class="py-6">Revolutionizing waste management with smart tracking and eco-friendly solutions for a cleaner tomorrow.</p>
        <button class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500 animate-bounce">Get Started</button>
      </div>
    </div>
  </div>

  <!-- About Section with Animation -->
  <div class="py-28 bg-gray-50">
    <div class="container mx-auto px-4">
      <div class="text-center mb-16">
        <h1 class="text-4xl font-bold text-green-600 mb-6 animate-fade-in-up">Our Eco-Friendly Features</h1>
        <p class="text-xl text-gray-700 mx-auto max-w-4xl animate-fade-in-up">
          GomiTorakka combines technology with sustainability to transform how you manage waste. Our platform helps you reduce environmental impact while making waste management effortless.
        </p>
      </div>
      
      <div class="grid md:grid-cols-2 gap-8 max-w-6xl mx-auto">
        <!-- Feature 1 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-calendar-check text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Smart Pickup Scheduling</h3>
            <p class="text-gray-600">Automated reminders and optimized pickup schedules tailored to your location and waste generation patterns.</p>
          </div>
        </div>

        <!-- Feature 2 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-recycle text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Waste Sorting Guide</h3>
            <p class="text-gray-600">Interactive guides to help you properly separate recyclables, compost, and landfill waste with confidence.</p>
          </div>
        </div>

        <!-- Feature 3 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-chart-line text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Real-Time Analytics</h3>
            <p class="text-gray-600">Track your waste reduction progress with detailed reports and environmental impact metrics.</p>
          </div>
        </div>

        <!-- Feature 4 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-map-marked-alt text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Collection Point Locator</h3>
            <p class="text-gray-600">Find nearby recycling centers and special waste disposal facilities with our interactive map.</p>
          </div>
        </div>

        <!-- Feature 5 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-leaf text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Carbon Footprint Tracker</h3>
            <p class="text-gray-600">See how your recycling efforts translate into CO2 savings and environmental benefits.</p>
          </div>
        </div>

        <!-- Feature 6 -->
        <div class="feature-card bg-white p-6 rounded-xl shadow-md hover:shadow-lg animate-fade-in-up flex items-start">
          <div class="feature-icon text-green-500">
            <i class="fas fa-bell text-2xl"></i>
          </div>
          <div>
            <h3 class="text-xl font-semibold text-gray-800 mb-2">Custom Notifications</h3>
            <p class="text-gray-600">Personalized alerts for collection days, special disposals, and community clean-up events.</p>
          </div>
        </div>
      </div>

      <!-- Stats Section -->
      <div class="mt-20 grid md:grid-cols-3 gap-6 max-w-6xl mx-auto animate-fade-in-up">
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <div class="text-4xl font-bold text-green-600 mb-2">10K+</div>
          <div class="text-gray-600">Active Users</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <div class="text-4xl font-bold text-green-600 mb-2">500+</div>
          <div class="text-gray-600">Tons Recycled</div>
        </div>
        <div class="bg-white p-6 rounded-xl shadow text-center">
          <div class="text-4xl font-bold text-green-600 mb-2">100%</div>
          <div class="text-gray-600">Eco-Friendly</div>
        </div>
      </div>
    </div>
  </div>

  @include('layouts.footer')

</body>
</html>