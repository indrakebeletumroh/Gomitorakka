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
    0%, 100% {
      box-shadow: 0 0 0px rgba(34, 197, 94, 0.4);
    }
    50% {
      box-shadow: 0 0 40px rgba(34, 197, 94, 0.8);
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

<!-- Cards -->
<div class="flex justify-center gap-16 py-28 flex-wrap">
  <div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Shoes" />
    </figure>
    <div class="card-body">
      <h2 class="card-title">Card Title</h2>
      <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
      <div class="card-actions justify-end">
        <button class="btn btn-primary">Buy Now</button>
      </div>
    </div>
  </div>
  <div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Shoes" />
    </figure>
    <div class="card-body">
      <h2 class="card-title">Card Title</h2>
      <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
      <div class="card-actions justify-end">
        <button class="btn btn-primary">Buy Now</button>
      </div>
    </div>
  </div>
  <div class="card bg-base-100 w-96 shadow-sm">
    <figure>
      <img src="https://img.daisyui.com/images/stock/photo-1606107557195-0e29a4b5b4aa.webp" alt="Shoes" />
    </figure>
    <div class="card-body">
      <h2 class="card-title">Card Title</h2>
      <p>A card component has a figure, a body part, and inside body there are title and actions parts</p>
      <div class="card-actions justify-end">
        <button class="btn btn-primary">Buy Now</button>
      </div>
    </div>
  </div>
</div>

@include('layouts.footer')





</body>
</html>
