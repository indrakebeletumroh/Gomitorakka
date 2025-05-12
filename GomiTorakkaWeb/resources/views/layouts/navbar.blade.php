<!-- Navbar -->
<nav id="navbar" class="navbar sticky top-0 left-0 right-0 z-50 bg-base-100 transition-all duration-300 shadow-md relative">
  <div class="flex items-center justify-between w-full px-8">
    <!-- Burger Menu Button -->
    <div class="block sm:hidden mr-4">
      <button id="burgerMenuButton" class="text-2xl" onclick="toggleBurgerMenu()">
        <i class="fas fa-bars"></i>
      </button>
    </div>

    <!-- Logo with Your Clover -->
    <a class="text-2xl font-bold flex items-center">
      <i class="fas fa-clover text-green-600 mr-2 text-3xl"></i>
      <span class="logo-text font-black text-gray-900">Gomi<span class="text-green-600">Torakka</span></span>
    </a>

    <!-- Menu (Visible on desktop) -->
    <ul id="menu" class="menu menu-horizontal px-1 flex-1 justify-center space-x-4 hidden sm:flex">
      <li>
        <a href="/" class="hover:text-green-600 transition-colors flex items-center gap-2 border-b-2 border-transparent pb-1">
          <i class="fas fa-home w-5 text-center"></i>
          <span>Home</span>
        </a>
      </li>
      <li>
        <a href="/feed" class="hover:text-green-600 transition-colors flex items-center gap-2 border-b-2 border-transparent pb-1">
          <i class="fas fa-newspaper w-5 text-center"></i>
          <span>Feed</span>
        </a>
      </li>
      <li>
        <a href="/maps" class="hover:text-green-600 transition-colors flex items-center gap-2 border-b-2 border-transparent pb-1">
          <i class="fas fa-map-marked-alt w-5 text-center"></i>
          <span>Tracker</span>
        </a>
      </li>
    </ul>

    <!-- Profile & Inbox Button -->
    <div class="flex-none gap-2">
      <button onclick="toggleInbox()" class="btn btn-ghost btn-circle text-lg relative hover:text-green-600">
        <i class="fas fa-inbox"></i>
        <span class="badge badge-sm badge-error absolute top-0 right-0 bg-green-600 border-green-600">3</span>
      </button>
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar hover:ring-2 hover:ring-green-600 transition-all">
          <div class="w-10 rounded-full">
            <img id="previewImage"
              src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}"
              alt="Profile Picture"
              class="rounded-full">
          </div>
        </label>
        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 border border-green-100">
          <li><a href="/profile" class="hover:text-green-600">Profile</a></li>
          <li><a class="hover:text-green-600">Settings</a></li>
          <li><a class="text-red-500 hover:text-red-700" href="/logout">Logout</a></li>
        </ul>
      </div>
    </div>
  </div>

  <!-- Mobile Menu -->
  <ul id="mobileMenu" class="menu bg-base-100 w-full p-4 space-y-4 sm:hidden absolute top-0 left-0 right-0 shadow-md hidden border-b-2 border-green-600">
    <li>
      <a href="/" class="hover:text-green-600 flex items-center gap-3 text-lg border-b-2 border-transparent pb-1">
        <i class="fas fa-home w-6 text-center"></i>
        <span>Home</span>
      </a>
    </li>
    <li>
      <a href="#" class="hover:text-green-600 flex items-center gap-3 text-lg border-b-2 border-transparent pb-1">
        <i class="fas fa-newspaper w-6 text-center"></i>
        <span>Feed</span>
      </a>
    </li>
    <li>
      <a href="/maps" class="hover:text-green-600 flex items-center gap-3 text-lg border-b-2 border-transparent pb-1">
        <i class="fas fa-map-marked-alt w-6 text-center"></i>
        <span>Tracker</span>
      </a>
    </li>
    <li>
      <button class="text-xl w-full text-center hover:text-green-600 flex items-center justify-center gap-2" onclick="toggleBurgerMenu()">
        <i class="fas fa-times"></i>
        <span>Close</span>
      </button>
    </li>
  </ul>

  <!-- Inbox Panel -->
  <div id="inboxPanel" class="absolute top-full right-5 w-80 bg-white border-2 border-green-200 rounded-lg shadow-lg p-4 z-50 hidden opacity-0 translate-y-5 transition-all duration-300 ease-in-out mt-2">
    <div class="flex justify-between items-center mb-2">
      <h3 class="font-bold text-lg text-green-700 flex items-center gap-2">
        <i class="fas fa-inbox"></i>
        <span>Inbox</span>
      </h3>
      <button onclick="toggleInbox()" class="btn btn-sm btn-circle btn-ghost hover:text-green-600">✕</button>
    </div>
    <ul class="space-y-2">
      <li class="bg-green-50 p-3 rounded-lg border border-green-100 hover:bg-green-100 transition-colors flex items-center gap-2">
        <i class="fas fa-bell text-green-600"></i>
        <span>Welcome to GomiTorakka!</span>
      </li>
      <li class="bg-green-50 p-3 rounded-lg border border-green-100 hover:bg-green-100 transition-colors flex items-center gap-2">
        <i class="fas fa-shipping-fast text-green-600"></i>
        <span>Your order has shipped.</span>
      </li>
      <li class="bg-green-50 p-3 rounded-lg border border-green-100 hover:bg-green-100 transition-colors flex items-center gap-2">
        <i class="fas fa-tag text-green-600"></i>
        <span>New promotions available!</span>
      </li>
    </ul>
  </div>
</nav>

<!-- Scripts -->
<script>
  function toggleInbox() {
    const panel = document.getElementById('inboxPanel');
    if (panel.classList.contains('hidden')) {
      panel.classList.remove('hidden');
      setTimeout(() => {
        panel.classList.remove('opacity-0', 'translate-y-5');
      }, 10);
    } else {
      panel.classList.add('opacity-0', 'translate-y-5');
      setTimeout(() => {
        panel.classList.add('hidden');
      }, 300);
    }
  }

  function toggleBurgerMenu() {
    const mobileMenu = document.getElementById("mobileMenu");
    mobileMenu.classList.toggle("hidden");
  }

  window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 20) {
      navbar.classList.add("bg-white", "shadow-lg", "transition-all");
    } else {
      navbar.classList.remove("bg-white", "shadow-lg");
    }
  });

  // Add active border functionality
  document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    const navLinks = document.querySelectorAll('#menu a, #mobileMenu a');

    navLinks.forEach(link => {
      const linkPath = link.getAttribute('href');

      if (linkPath === currentPath) {
        link.classList.add('border-green-600');
        link.classList.remove('border-transparent');
      }
    });
  });
</script>

<!-- Tailwind CSS Animations -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script>
  // Custom entry animation
  document.body.classList.add('animate-fade-in');
</script>

<style>
  .navbar a {
    transition: border-color 0.2s ease-in-out;
  }

  #navbar {
    position: sticky;
    top: 0;
  }

  #inboxPanel {
    position: absolute;
    top: 100%;
    right: 1.25rem;
    margin-top: 0.5rem;
  }

  @keyframes fade-in {
    from {
      opacity: 0;
      transform: translateY(10px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
  }

  @keyframes fade-in-up {
    from {
      opacity: 0;
      transform: translateY(30px);
    }

    to {
      opacity: 1;
      transform: translateY(0);
    }
  }

  .animate-fade-in-up {
    animation: fade-in-up 1s ease-out;
  }
</style>