<!-- Navbar -->
<meta name="csrf-token" content="{{ csrf_token() }}">
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
      @if (Session::has('uid'))
      <button onclick="toggleInbox()" class="btn btn-ghost btn-circle text-lg relative hover:text-green-600">

        @php
        $unreadCount = \App\Models\Inbox::where('user_id', Session::get('uid'))
        ->where('status', 'unread')
        ->count();
        @endphp

        <i class="fas fa-inbox"></i>
        @if ($unreadCount > 0)
        <span id="notifBadge" class="badge badge-sm badge-error absolute top-0 right-0 bg-green-600 border-green-600">
          {{ $unreadCount }}
        </span>
        @endif
      </button>
      @endif

      @if (Session::has('uid'))
      <div class="dropdown dropdown-end">
        <label tabindex="0" class="btn btn-ghost btn-circle avatar hover:ring-2 hover:ring-green-600 transition-all">
          <div class="w-10 rounded-full">
            <img id="navbarProfileImage"
              src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}"
              alt="Profile Picture"
              class="rounded-full">
          </div>
        </label>

        <ul tabindex="0" class="menu menu-sm dropdown-content mt-3 z-[1] p-2 shadow bg-base-100 rounded-box w-52 border border-green-100">
          <li><a href="/profile" class="hover:text-green-600">Profile</a></li>
          @if (Session::has('username'))
          @if (Session::get('role') == 'admin')
          <li><a class="text-green-600 hover:text-green-800" href="/request">Request Panel</a></li>
          <li><a class="text-green-600 hover:text-green-800" href="/adminpanel">Admin Panel</a></li>
          @endif
          <li><a class="text-red-500 hover:text-red-700" href="/logout">Logout</a></li>

        </ul>
        @endif
      </div>
      @else
      <button class="btn btn-primary text-white hover:bg-green-400 hover:border-none hover:text-gray-700"><a href="/login">LOGIN</a></button>
      @endif



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
        <a href="/feed" class="hover:text-green-600 flex items-center gap-3 text-lg border-b-2 border-transparent pb-1">
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
    <!-- Inbox Panel -->
    <div id="inboxPanel" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg p-4 border border-green-100 z-50 hidden opacity-0 translate-y-5 transition-all duration-300">
      <div class="flex justify-between items-center mb-2">
        <h3 class="text-green-700 font-semibold">Inbox</h3>
        <button onclick="toggleInbox()" class="btn btn-sm btn-circle btn-ghost hover:text-green-600">✕</button>
      </div>
      <ul id="inboxList" class="space-y-2">
        <li>Memuat pesan...</li>
      </ul>


</nav>

@if (Session::has('username'))
<script>
  async function toggleInbox() {
    const panel = document.getElementById('inboxPanel');
    const inboxList = document.getElementById('inboxList');

    if (panel.classList.contains('hidden')) {
      // Tampilkan panel
      panel.classList.remove('hidden');
      setTimeout(() => {
        panel.classList.remove('opacity-0', 'translate-y-5');
      }, 10);

      try {
        const response = await fetch(`/api/inbox`);
        const data = await response.json();

        if (data.length === 0) {
          inboxList.innerHTML = '<li class="text-gray-500">No message.</li>';
        } else {
          const messagesHtml = data.map(item => {
            const isRejected = item.message.toLowerCase().includes("rejected");
            const bgColor = isRejected ?
              "bg-red-100 border-red-100 hover:bg-red-50" :
              "bg-green-50 border-green-100 hover:bg-green-100";

            return `
            <li class="${bgColor} p-3 rounded-lg border transition-colors">
              <div class="font-semibold">${item.title}</div>
              <div class="text-sm text-gray-700">${item.message}</div>
            </li>
          `;
          }).join('');

          inboxList.innerHTML = `
          <li class="mb-2 flex justify-between items-center">
            <button onclick="markAllAsRead()" class="text-sm text-blue-600 hover:underline">
              Mark All as Read
            </button>
          </li>
          ${messagesHtml}
        `;
        }
      } catch (error) {
        inboxList.innerHTML = '<li class="text-red-500">Failed to load message.</li>';
      }
    } else {
      // Tutup panel
      panel.classList.add('opacity-0', 'translate-y-5');
      setTimeout(() => {
        panel.classList.add('hidden');
      }, 300);
    }
  }
</script>

@endif

<!-- Scripts -->
<script>
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

  function markAllAsRead() {
    fetch('/inbox/mark-all-as-read', {
        method: 'POST',
        headers: {
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
          'Content-Type': 'application/json'
        },
        body: JSON.stringify({})
      })
      .then(response => response.json())
      .then(data => {
        console.log(data.message);

        // Hapus elemen badge notifikasi
        const notifBadge = document.getElementById('notifBadge');
        if (notifBadge) {
          notifBadge.remove();
        }

        // Refresh isi inbox
        toggleInbox();
        setTimeout(() => toggleInbox(), 400);
      })
      .catch(error => {
        console.error('Error saat markAllAsRead:', error);
      });
  }
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