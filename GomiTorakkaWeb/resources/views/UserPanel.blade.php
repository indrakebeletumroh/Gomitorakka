<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>GomiTorakka - User Management</title>

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
</head>

<body class="animate-fade-in transition-all duration-500 ease-out">
  @include('layouts.navbar')

  <main class="min-h-[calc(100vh-160px)] bg-base-100/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8 text-center">
        <h1 class="text-4xl font-instrument-sans font-bold text-primary mb-2">
          <i class="fas fa-users-cog mr-2"></i>User Management
        </h1>
        <p class="text-base-content/70">Manage system users and permissions</p>
      </div>

      <!-- Filter -->
      <div class="card bg-base-200 shadow-sm mb-8">
        <div class="card-body py-4">
          <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text font-instrument-sans">Role Filter</span>
                </label>
                <select class="select select-bordered">
                  <option>All Roles</option>
                  <option>Admin</option>
                  <option>User</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text font-instrument-sans">Search</span>
                </label>
                <input type="text" placeholder="Search users..." class="input input-bordered">
              </div>
            </div>
            <button class="btn btn-primary w-full sm:w-auto">
              <i class="fas fa-filter mr-2"></i>Apply Filters
            </button>
          </div>
        </div>
      </div>

      <!-- Table -->
      <div class="card shadow-lg bg-base-100">
        <div class="card-body p-0">
          <div class="overflow-x-auto">
            <table class="table">
              <thead class="bg-base-200">
                <tr class="font-instrument-sans text-lg">
                  <th>User</th>
                  <th>Contact</th>
                  <th>Age</th>
                  <th>Role</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold"></div>
                        <div class="text-sm text-base-content/50">UID: </div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium"></div>
                    <div class="text-sm text-base-content/50"></div>
                  </td>
                  <td></td>
                  <td>
                    <span class="badge badge-lg">
                    </span>
                  </td>
                  <td>
                    <span class="badge badge-lg badge-success">
                      <i class="fas fa-check-circle mr-1"></i>Active
                    </span>
                  </td>
                  <td>
                    <div class="flex gap-2">
                      <button onclick="editModal.showModal()" class="btn btn-sm btn-primary">
                        <i class="fas fa-edit"></i>
                      </button>
                      <div class="dropdown dropdown-end">
                        <div tabindex="0" role="button" class="btn btn-sm btn-secondary">
                          <i class="fas fa-ellipsis-v"></i>
                        </div>
                        <ul tabindex="0" class="dropdown-content z-[1] menu p-2 shadow bg-base-100 rounded-box w-52 border border-base-200">
                          <li>
                            <a onclick="openActionModal('Promote to admin?')" class="text-success hover:bg-success/10">
                              <i class="fas fa-user-shield mr-2"></i>Make Admin
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Deactivate user?')" class="text-warning hover:bg-warning/10">
                              <i class="fas fa-user-slash mr-2"></i>Deactivate
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Permanently delete user?')" class="text-error hover:bg-error/10">
                              <i class="fas fa-trash-alt mr-2"></i>Delete
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
          
          <!-- Pagination -->
          <div class="flex justify-center p-4 bg-base-200/50">
          </div>
        </div>
      </div>
    </div>
  </main>

  @include('layouts.footer')

  <!-- Edit Modal -->
  <dialog id="editModal" class="modal">
    <div class="modal-box max-w-2xl">
      <h3 class="font-instrument-sans text-2xl font-bold mb-4">
        <i class="fas fa-user-edit mr-2"></i>Edit User
      </h3>
      <form class="space-y-4" method="POST" action="">
        @csrf
        
        <input type="hidden" name="uid" id="editUid">

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Username</span>
            </label>
            <input type="text" name="username" class="input input-bordered" required>
          </div>
          
          <div class="form-control">
            <label class="label">
              <span class="label-text">Email</span>
            </label>
            <input type="email" name="email" class="input input-bordered" required>
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Phone Number</span>
            </label>
            <input type="text" name="phone_number" class="input input-bordered">
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Age</span>
            </label>
            <input type="number" name="age" class="input input-bordered">
          </div>

          <div class="form-control">
            <label class="label">
              <span class="label-text">Role</span>
            </label>
            <select name="role" class="select select-bordered">
              <option value="user">User</option>
              <option value="admin">Admin</option>
            </select>
          </div>
        </div>

        <div class="modal-action">
          <button type="button" onclick="editModal.close()" class="btn">Cancel</button>
          <button type="submit" class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </dialog>

  <!-- Action Confirmation Modal -->
  <dialog id="actionModal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-center" id="modalMessage">Are you sure?</h3>
      <div class="modal-action justify-center">
        <form id="actionForm" method="POST">
          @csrf
          <button type="button" class="btn" onclick="actionModal.close()">Cancel</button>
          <button type="submit" class="btn btn-primary">Confirm</button>
        </form>
      </div>
    </div>
  </dialog>

  <script>
    function openActionModal(message, actionUrl, method = 'POST') {
      document.getElementById('modalMessage').innerText = message;
      const form = document.getElementById('actionForm');
      form.action = actionUrl;
      form.method = method;
      
      // Add method spoofing for DELETE/PUT
      if (method !== 'POST') {
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = method;
        form.appendChild(methodInput);
      }
      
      actionModal.showModal();
    }

    // Example edit user data loading
    function loadUserData(user) {
      document.getElementById('editUid').value = user.uid;
      document.querySelector('input[name="username"]').value = user.username;
      document.querySelector('input[name="email"]').value = user.email;
      document.querySelector('input[name="phone_number"]').value = user.phone_number;
      document.querySelector('input[name="age"]').value = user.age;
      document.querySelector('select[name="role"]').value = user.role;
    }
  </script>

</body>
</html>