<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>Request-GomiTorakka</title>
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

  @if (file_exists(public_path('build/manifest.json')) || file_exists(public_path('hot')))
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @endif

  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>



<body class="animate-fade-in transition-all duration-500 ease-out">

  @include('layouts.navbar')

  <main class="min-h-[calc(100vh-160px)] bg-base-100/80 py-8">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <!-- Header -->
      <div class="mb-8 text-center">
        <h1 class="text-4xl font-instrument-sans font-bold text-primary mb-2">
          <i class="fas fa-trash-restore mr-2"></i>Marker Request
        </h1>
        <p class="text-base-content/70">Manage collection requests efficiently</p>
      </div>


      <!-- Table -->
      <div class="card shadow-lg bg-base-100">
        <div class="card-body p-0">
          <div class="overflow-x-auto">
            <table class="table">
              <thead class="bg-base-200">
                <tr class="font-instrument-sans text-lg">
                  <th>User</th>
                  <th>Schedule</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- User 1 -->
                @foreach ($markers as $marker)
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div>
                        <div class="font-bold">{{ $marker->user->username ?? 'Eco User' }}</div>
                        <div class="text-sm text-base-content/50">{{ $marker->user->email ?? 'user@ecocity.com' }}</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">{{ $marker->created_at->format('Y-m-d') }}</div>
                    <div class="text-sm text-base-content/50">{{ $marker->created_at->format('H:i') }}</div>
                  </td>
                  <td class="max-w-xs truncate">{{ $marker->description ?? 'Tidak ada deskripsi' }}</td>
                  <td>
                    <span class="badge badge-lg 
      @if($marker->status == 'pending') badge-warning 
      @elseif($marker->status == 'approved') badge-success 
      @else badge-error @endif">
                      {{ ucfirst($marker->status) }}
                    </span>
                  </td>
                  <td>
                    <div class="dropdown dropdown-end">
                      <div tabindex="0" role="button" class="btn btn-sm btn-secondary">
                        <i class="fas fa-ellipsis-v"></i>
                      </div>
                      <ul tabindex="0" class="dropdown-content menu p-2 shadow bg-base-100 rounded-box w-52 border border-base-200">
                        <li>
                          <a href="#" onclick="openActionModal('{{ $marker->marker_id }}', 'approved', 'Confirm this request?')" class="text-success hover:bg-success/10">
                            <i class="fas fa-check-circle mr-2"></i>Approve
                          </a>
                        </li>
                        <li>
                          <a href="#" onclick="openActionModal('{{ $marker->marker_id }}', 'rejected', 'Cancel this request?')" class="text-error hover:bg-error/10">
                            <i class="fas fa-times-circle mr-2"></i>Decline
                          </a>
                        </li>
                      </ul>
                    </div>
                  </td>
                </tr>
                @endforeach



              </tbody>
            </table>
          </div>
          <!-- Pagination -->
          <div class="flex justify-center p-4 bg-base-200/50">
            <div class="join">
              <button class="join-item btn">«</button>
              <button class="join-item btn btn-active">1</button>
              <button class="join-item btn">2</button>
              <button class="join-item btn">3</button>
              <button class="join-item btn">»</button>
            </div>
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
        <i class="fas fa-edit mr-2"></i>Edit Request
      </h3>
      <form class="space-y-4">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
          <div class="form-control">
            <label class="label">
              <span class="label-text">Pickup Date</span>
            </label>
            <input type="date" class="input input-bordered">
          </div>
          <div class="form-control">
            <label class="label">
              <span class="label-text">Status</span>
            </label>
            <select class="select select-bordered">
              <option>Pending</option>
              <option>Confirmed</option>
              <option>Completed</option>
              <option>Cancelled</option>
            </select>
          </div>
        </div>
        <div class="modal-action">
          <button type="button" onclick="editModal.close()" class="btn">Cancel</button>
          <button class="btn btn-primary">Save Changes</button>
        </div>
      </form>
    </div>
  </dialog>

  <!-- Action Confirmation Modal -->
  <dialog id="actionModal" class="modal">
    <div class="modal-box">
      <h3 class="font-bold text-lg text-center" id="modalMessage">Are you sure?</h3>
      <div class="modal-action justify-center">
        <button class="btn" onclick="actionModal.close()">No</button>
        <button class="btn btn-primary" onclick="handleConfirm()">Yes</button>
      </div>
    </div>
  </dialog>

  <script>
    // Ambil CSRF token dari meta tag, agar dinamis dan tidak hardcoded Blade tag di JS
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    let currentMarkerId = null;
    let currentStatus = null;

    function openActionModal(markerId, status, message) {
      currentMarkerId = markerId;
      currentStatus = status;
      document.getElementById('modalMessage').innerText = message;
      document.getElementById('actionModal').showModal();
    }

    async function handleConfirm() {
      if (!currentMarkerId || !currentStatus) {
        alert('Invalid action');
        return;
      }

      try {
        const response = await fetch(`/markers/${currentMarkerId}/status`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({
            status: currentStatus
          })
        });

        if (!response.ok) {
          const data = await response.json();
          alert('Gagal update status: ' + (data.message || 'Error'));
        } else {
          alert('Status berhasil diupdate');
          location.reload(); // reload halaman agar data terbaru tampil
        }
      } catch (error) {
        alert('Terjadi kesalahan: ' + error.message);
      } finally {
        document.getElementById('actionModal').close();
        currentMarkerId = null;
        currentStatus = null;
      }
    }

    function handleAction(markerId, status) {
      if (!confirm(`Are you sure to ${status} this request?`)) return;

      fetch(`/markers/${markerId}/status`, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
          },
          body: JSON.stringify({
            status: status
          })
        })
        .then(res => res.json())
        .then(data => {
          alert(data.message);
          location.reload(); // reload page supaya update status terlihat
        })
        .catch(err => {
          alert('Failed to update status');
          console.error(err);
        });
    }
  </script>



</body>

</html>