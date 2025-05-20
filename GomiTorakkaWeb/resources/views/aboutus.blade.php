<!DOCTYPE html>
<html lang="en" data-theme="emerald">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>About - GomiTorakka - Smart Waste Management</title>
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

    <style>
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        
        .team-card {
            transition: transform 0.3s ease;
        }
        
        .team-card:hover {
            transform: translateY(-5px);
        }
    </style>
</head>

<body class="animate-fade-in">
    @include('layouts.navbar')
    
    <main class="container mx-auto px-4 py-12 max-w-6xl">
        <!-- Hero Section -->
        <section class="text-center mb-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">About GomiTorakka</h1>
            <p class="text-lg opacity-80 max-w-3xl mx-auto">
                Revolutionizing waste management through smart technology and sustainable solutions for a cleaner future.
            </p>
        </section>

        <!-- Mission Section -->
        <section class="mb-16">
            <div class="flex flex-col md:flex-row gap-8 items-center">
                <div class="md:w-1/2">
                    <img src="https://images.unsplash.com/photo-1565402170291-8491f14678db?ixlib=rb-4.0.3&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&auto=format&fit=crop&w=1470&q=80" 
                         alt="Smart Waste Management" 
                         class="rounded-lg shadow-lg w-full">
                </div>
                <div class="md:w-1/2">
                    <h2 class="text-3xl font-bold mb-4">Our Mission</h2>
                    <p class="mb-4">
                        GomiTorakka was born from a simple idea: to make waste management smarter, more efficient, and environmentally friendly. 
                        We combine IoT technology with data analytics to transform how communities handle their waste.
                    </p>
                    <p>
                        Our smart bins and tracking system help reduce overflowing waste, optimize collection routes, 
                        and provide valuable insights for sustainable waste management practices.
                    </p>
                </div>
            </div>
        </section>

        <!-- Team Section -->
        <section class="mb-16">
            <h2 class="text-3xl font-bold mb-12 text-center">Meet The Team</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <!-- Indra -->
                <div class="card bg-base-100 shadow-xl team-card">
                    <figure class="px-10 pt-10">
                        <div class="avatar placeholder">
                            <div class="bg-green-600 text-neutral-content rounded-full w-24">
                                <img src="https://avatars.githubusercontent.com/u/133834106?v=4" alt="">
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Indra</h3>
                        <p class="text-sm opacity-70">Backend Developer | Vice Manager</p>
                        <p class="text-sm">
                            Architect of our robust backend systems and infrastructure, ensuring seamless data flow and reliability.
                        </p>
                        <div class="card-actions mt-4">
                            <div class="flex gap-2">
                                <a href="https://github.com/indrakebeletumroh" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://discordapp.com/users/1182076591770194014" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-discord"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Yanuar -->
                <div class="card bg-base-100 shadow-xl team-card">
                    <figure class="px-10 pt-10">
                        <div class="avatar placeholder">
                            <div class="bg-green-600 text-neutral-content rounded-full w-24">
                                <img src="https://avatars.githubusercontent.com/u/141338502?v=4" alt="">
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Yanuar</h3>
                        <p class="text-sm opacity-70">Frontend Lead | Backend Assist | Developer Manager</p>
                        <p class="text-sm">
                            Leads our UI/UX development while bridging frontend and backend systems for optimal performance.
                        </p>
                        <div class="card-actions mt-4">
                            <div class="flex gap-2">
                                <a href="https://github.com/AEDROID" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://discordapp.com/users/551565982221729817" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-discord"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Arestu -->
                <div class="card bg-base-100 shadow-xl team-card">
                    <figure class="px-10 pt-10">
                        <div class="avatar placeholder">
                            <div class="bg-green-600 text-neutral-content rounded-full w-24">
                                <img src="https://avatars.githubusercontent.com/u/209565257?v=4" alt="">
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Arestu</h3>
                        <p class="text-sm opacity-70">Frontend Developer | Member</p>
                        <p class="text-sm">
                            Crafts beautiful and intuitive interfaces that make waste management accessible to everyone.
                        </p>
                        <div class="card-actions mt-4">
                            <div class="flex gap-2">
                                <a href="https://github.com/2SigmaSkibidi3" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://discordapp.com/users/1080115751635144704" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-discord"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                 <!-- Fajar -->
                <div class="card bg-base-100 shadow-xl team-card">
                    <figure class="px-10 pt-10">
                        <div class="avatar placeholder">
                            <div class="bg-green-600 text-neutral-content rounded-full w-24">
                                <img src="https://avatars.githubusercontent.com/u/156165419?v=4" alt="">
                            </div>
                        </div>
                    </figure>
                    <div class="card-body items-center text-center">
                        <h3 class="card-title">Fajar</h3>
                        <p class="text-sm opacity-70">Database Manager | Member</p>
                        <p class="text-sm">
                            Ensures data integrity and seamless accessibility by expertly designing, organizing, and maintaining databases that power efficient and reliable applications.
                        </p>
                        <div class="card-actions mt-4">
                            <div class="flex gap-2">
                                <a href="https://githubvvvvvv.com/CoderJarzz" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-github"></i>
                                </a>
                                <a href="https://discordapp.com/users/1061456282093092884" class="btn btn-circle btn-sm btn-ghost" target="_blank">
                                    <i class="fab fa-discord"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

       <!-- Technology Section -->
<section class="mb-16">
    <h2 class="text-3xl font-bold mb-8 text-center">Our Technology Stack</h2>
    
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
        <!-- Laravel 12 -->
        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
            <div class="card-body items-center text-center">
                <div class="w-16 h-16 mb-4">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-red-500 fill-current">
                        <path d="M12 0L1.605 6v12L12 24l10.395-6V6L12 0zm0 2.65l8.895 5.1V16.4l-8.895 5.1-8.895-5.1V7.75L12 2.65zM6 15.26v-3.6l6 3.45v3.6l-6-3.45zm9-5.15l-6-3.45v3.6l6 3.45v-3.6z"/>
                    </svg>
                </div>
                <h3 class="card-title">Laravel 12</h3>
                <p class="text-sm">Powerful PHP framework for building robust backend systems and APIs.</p>
                <div class="mt-2">
                    <span class="badge badge-outline">PHP</span>
                    <span class="badge badge-outline">MVC</span>
                    <span class="badge badge-outline">Eloquent</span>
                </div>
            </div>
        </div>
        
        <!-- Tailwind CSS -->
        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
            <div class="card-body items-center text-center">
                <div class="w-16 h-16 mb-4">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-cyan-400 fill-current">
                        <path d="M12.001 4.8c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624C13.666 10.618 15.027 12 18.001 12c3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C16.337 6.182 14.976 4.8 12.001 4.8zm-6 7.2c-3.2 0-5.2 1.6-6 4.8 1.2-1.6 2.6-2.2 4.2-1.8.913.228 1.565.89 2.288 1.624 1.177 1.194 2.538 2.576 5.512 2.576 3.2 0 5.2-1.6 6-4.8-1.2 1.6-2.6 2.2-4.2 1.8-.913-.228-1.565-.89-2.288-1.624C10.337 13.382 8.976 12 6.001 12z"/>
                    </svg>
                </div>
                <h3 class="card-title">Tailwind CSS</h3>
                <p class="text-sm">Utility-first CSS framework for rapid UI development.</p>
                <div class="mt-2">
                    <span class="badge badge-outline">Utility-first</span>
                    <span class="badge badge-outline">Responsive</span>
                    <span class="badge badge-outline">Customizable</span>
                </div>
            </div>
        </div>
        
        <!-- DaisyUI -->
        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
            <div class="card-body items-center text-center">
                <div class="w-16 h-16 mb-4">
                    <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="text-green-500 fill-current">
                        <path d="M12 22C6.477 22 2 17.523 2 12S6.477 2 12 2s10 4.477 10 10-4.477 10-10 10zm-1.446-5.477l2.21-3.742-2.23-3.762a6.018 6.018 0 0 1 2.24-.003l2.225 3.766-2.204 3.742a6.025 6.025 0 0 1-2.24.003z"/>
                    </svg>
                </div>
                <h3 class="card-title">DaisyUI</h3>
                <p class="text-sm">Component library for beautiful, accessible UIs.</p>
                <div class="mt-2">
                    <span class="badge badge-outline">Components</span>
                    <span class="badge badge-outline">Themes</span>
                    <span class="badge badge-outline">Accessible</span>
                </div>
            </div>
        </div>

        <!-- LeafletJS -->
        <div class="card bg-base-100 shadow-md hover:shadow-lg transition-shadow">
            <div class="card-body items-center text-center">
                <div class="w-16 h-16 mb-4">
                    <svg viewBox="0 0 256 256" xmlns="http://www.w3.org/2000/svg" class="text-green-600 fill-current">
                        <path d="M128 0C57.28 0 0 57.28 0 128s57.28 128 128 128 128-57.28 128-128S198.72 0 128 0zm0 240.64c-62.08 0-112.64-50.56-112.64-112.64S65.92 15.36 128 15.36s112.64 50.56 112.64 112.64-50.56 112.64-112.64 112.64zm-7.68-107.52c0 4.16 3.52 7.68 7.68 7.68s7.68-3.52 7.68-7.68-3.52-7.68-7.68-7.68-7.68 3.52-7.68 7.68zm-7.68-76.8c-21.12 0-38.4 17.28-38.4 38.4 0 4.16 3.52 7.68 7.68 7.68s7.68-3.52 7.68-7.68c0-12.8 10.24-23.04 23.04-23.04 4.16 0 7.68-3.52 7.68-7.68s-3.52-7.68-7.68-7.68z"/>
                    </svg>
                </div>
                <h3 class="card-title">LeafletJS</h3>
                <p class="text-sm">Lightweight library for interactive maps and geospatial data.</p>
                <div class="mt-2">
                    <span class="badge badge-outline">Maps</span>
                    <span class="badge badge-outline">GIS</span>
                    <span class="badge badge-outline">Mobile-friendly</span>
                </div>
            </div>
        </div>
    </div>
</section>

    </main>

    @include('layouts.footer')

    <script>
        // Simple animation for team cards
        document.querySelectorAll('.team-card').forEach(card => {
            card.addEventListener('mouseenter', () => {
                card.style.transform = 'translateY(-5px)';
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = '';
            });
        });
    </script>
</body>
</html>