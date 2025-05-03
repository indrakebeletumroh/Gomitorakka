<!-- Navbar -->
<nav id="navbar" class="navbar fixed top-0 left-0 right-0 z-50 bg-base-100 transition-all duration-300">
  <div class="flex-1">
    <a class="text-2xl font-bold text-green">GomiTorakka</a>
    <ul class="menu menu-horizontal px-1 hidden sm:flex">
      <li><a href="#">Home</a></li>
      <li><a href="#">Feed</a></li>
      <li><a href="#">Tracker</a></li>
    </ul>
  </div>
  <div class="flex-none gap-2">
    <button onclick="toggleInbox()" class="btn btn-ghost btn-circle text-lg relative">
      <i class="fas fa-inbox"></i>
      <span class="badge badge-sm badge-error absolute top-0 right-0">3</span>
    </button>
    <div class="dropdown dropdown-end">
      <label tabindex="0" class="btn btn-ghost btn-circle avatar">
        <div class="w-10 rounded-full">
          <img src="https://i.pravatar.cc/100?u=profile" />
        </div>
      </label>
      <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52">
        <li><a>Profile</a></li>
        <li><a>Settings</a></li>
        <li><a>Logout</a></li>
      </ul>
    </div>
  </div>
</nav>

<!-- Inbox Panel -->
<div id="inboxPanel" class="fixed top-20 right-5 w-80 bg-white border border-gray-200 rounded-lg shadow-lg p-4 z-50 hidden opacity-0 translate-y-5 transition-all duration-300 ease-in-out">
  <div class="flex justify-between items-center mb-2">
    <h3 class="font-bold text-lg">Inbox</h3>
    <button onclick="toggleInbox()" class="btn btn-sm btn-circle btn-ghost">✕</button>
  </div>
  <ul class="space-y-2">
    <li class="bg-base-200 p-2 rounded">📥 Welcome to GomiTorakka!</li>
    <li class="bg-base-200 p-2 rounded">📥 Your order has shipped.</li>
    <li class="bg-base-200 p-2 rounded">📥 New promotions available!</li>
  </ul>
</div>

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

  window.addEventListener("scroll", () => {
    const navbar = document.getElementById("navbar");
    if (window.scrollY > 20) {
      navbar.classList.add("navbar-scrolled");
    } else {
      navbar.classList.remove("navbar-scrolled");
    }
  });

  
</script>

<!-- Tailwind CSS Animations -->
<script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
<script>
  // Custom entry animation
  document.body.classList.add('animate-fade-in');
</script>

<style>
  @keyframes fade-in {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in {
    animation: fade-in 0.6s ease-out forwards;
  }

  @keyframes fade-in-up {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }

  .animate-fade-in-up {
    animation: fade-in-up 1s ease-out;
  }
</style>