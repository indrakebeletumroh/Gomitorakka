<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Document</title>

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



    @keyframes pulse-green {

      0%,
      100% {
        box-shadow: 0 0 0px rgba(34, 197, 94, 0.4);
      }

      50% {
        box-shadow: 0 0 40px rgba(34, 197, 94, 0.8);
      }
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
  </style>

</head>

<body class="animate-fade-in transition-all duration-500 ease-out">

  @include('layouts.navbar')

  <!-- Hero Section -->
  <div class="hero bg-emerald-100 min-h-screen pt-24">
    <div class="absolute top-0 left-0 w-full h-full pointer-events-none overflow-hidden z-0">
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
      <div class="leaf"></div>
    </div>

    <div class="hero-content text-center z-10">
      <div class="max-w-md animate-fade-in-up">
        <h1 class="text-5xl font-bold">Welcome To Gomi<span class="text-green-700">Torakka</span></h1>
        <p class="py-6">Provident cupiditate voluptatem et in. Quaerat fugiat ut assumenda excepturi exercitationem quasi. In deleniti eaque aut repudiandae et a id nisi.</p>
        <button class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700 hover:-rotate-5 hover:duration-3500 animate-bounce" id="startBtn">Get Started</button>
      </div>
    </div>
  </div>

  <!-- About Section with Animation -->
  <div class="py-28 bg-gray-50">
    <div class="text-center">
      <h1 class="text-4xl font-bold text-green mb-6 animate-fade-in-up">About GomiTorakka</h1>
      <p class="text-xl text-gray-700 mx-auto max-w-4xl animate-fade-in-up">
        GomiTorakka is your ultimate companion for waste management. With our easy-to-use app, you can effortlessly track your trash pickup, sort your waste, and even track your recycling efforts. Join us in making the world cleaner, one step at a time!
      </p>
      <div class="mt-12 mx-20">
        <h2 class="text-3xl font-semibold text-gray-800 mb-6 animate-fade-in-up">Amazing Features You'll Love</h2>
        <div class="grid md:grid-cols-2 gap-8">
          <div class="flex items-start space-x-4 animate-fade-in-up transform transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50 p-6 rounded-lg">
            <div class="flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m2 0h-2a2 2 0 00-2 2v6h-8v-6a2 2 0 00-2-2H3m6-2h8m2 0h-2a2 2 0 01-2 2v6h-8v-6a2 2 0 01-2-2H3m6-2h8" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-800">Track Your Trash Pickup</h3>
              <p class="text-gray-700 mt-2">Never forget a trash pickup again! With GomiTorakka, you’ll receive timely reminders for your scheduled trash collections. Stay organized and never let your trash pile up!</p>
            </div>
          </div>

          <div class="flex items-start space-x-4 animate-fade-in-up transform transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50 p-6 rounded-lg">
            <div class="flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8V4m0 4l-4-4m4 4l4-4M12 4v4m-8 12v4h16v-4H4z" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-800">Sort Your Waste</h3>
              <p class="text-gray-700 mt-2">Easily categorize your waste! Whether it’s recyclables, organic waste, or general trash, GomiTorakka helps you organize your waste effectively. Let’s keep the environment clean!</p>
            </div>
          </div>

          <div class="flex items-start space-x-4 animate-fade-in-up transform transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50 p-6 rounded-lg">
            <div class="flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 7l-5 5m0 0l5 5m-5-5h12" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-800">Track Your Recycling Progress</h3>
              <p class="text-gray-700 mt-2">Feel good about recycling! GomiTorakka tracks your recycling progress, so you can see how much waste you’re saving from landfills. It’s easy, rewarding, and eco-friendly!</p>
            </div>
          </div>

          <div class="flex items-start space-x-4 animate-fade-in-up transform transition-transform duration-300 hover:scale-105 hover:shadow-xl hover:bg-green-50 p-6 rounded-lg">
            <div class="flex-shrink-0">
              <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 8l4 4m0 0l4-4m-4 4V4" />
              </svg>
            </div>
            <div>
              <h3 class="text-xl font-semibold text-gray-800">Reminders and Notifications</h3>
              <p class="text-gray-700 mt-2">Stay on top of your waste management! GomiTorakka sends reminders for your trash pickups and recycling schedules, making sure you stay eco-conscious every step of the way.</p>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

  @include('layouts.footer')

</body>

</html>