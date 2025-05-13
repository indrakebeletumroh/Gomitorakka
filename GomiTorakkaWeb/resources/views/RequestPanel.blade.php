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

      <!-- Filter -->
      <div class="card bg-base-200 shadow-sm mb-8">
        <div class="card-body py-4">
          <div class="flex flex-col sm:flex-row gap-4 items-end">
            <div class="flex-1 w-full grid grid-cols-1 md:grid-cols-2 gap-4">
              <div class="form-control">
                <label class="label">
                  <span class="label-text font-instrument-sans">Status Filter</span>
                </label>
                <select class="select select-bordered">
                  <option>All Requests</option>
                  <option>Pending</option>
                  <option>Confirmed</option>
                  <option>Completed</option>
                  <option>Cancelled</option>
                </select>
              </div>
              <div class="form-control">
                <label class="label">
                  <span class="label-text font-instrument-sans">Date Range</span>
                </label>
                <input type="date" class="input input-bordered">
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
                  <th>Schedule</th>
                  <th>Location</th>
                  <th>Status</th>
                  <th>Actions</th>
                </tr>
              </thead>
              <tbody>
                <!-- User 1 -->
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="/placeholder-user.jpg" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">Eco User</div>
                        <div class="text-sm text-base-content/50">user@ecocity.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">2024-03-20</div>
                    <div class="text-sm text-base-content/50">14:00 - 16:00</div>
                  </td>
                  <td class="max-w-xs truncate">123 Green Street, Eco District</td>
                  <td>
                    <span class="badge badge-lg badge-warning">
                      <i class="fas fa-clock mr-1"></i>Pending
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
                            <a onclick="openActionModal('Confirm this request?')" class="text-success hover:bg-success/10">
                              <i class="fas fa-check-circle mr-2"></i>Confirm
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Cancel this request?')" class="text-error hover:bg-error/10">
                              <i class="fas fa-times-circle mr-2"></i>Cancel
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Mark as completed?')" class="text-info hover:bg-info/10">
                              <i class="fas fa-clipboard-check mr-2"></i>Complete
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- User 2 -->
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="/placeholder-user.jpg" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">John Doe</div>
                        <div class="text-sm text-base-content/50">john.doe@example.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">2024-03-21</div>
                    <div class="text-sm text-base-content/50">10:00 - 12:00</div>
                  </td>
                  <td class="max-w-xs truncate">456 Elm Street, Tech Park</td>
                  <td>
                    <span class="badge badge-lg badge-confirmed">
                      <i class="fas fa-check-circle mr-1"></i>Confirmed
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
                            <a onclick="openActionModal('Cancel this request?')" class="text-error hover:bg-error/10">
                              <i class="fas fa-times-circle mr-2"></i>Cancel
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Mark as completed?')" class="text-info hover:bg-info/10">
                              <i class="fas fa-clipboard-check mr-2"></i>Complete
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- User 3 -->
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="/placeholder-user.jpg" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">Mary Jane</div>
                        <div class="text-sm text-base-content/50">mary.jane@example.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">2024-03-22</div>
                    <div class="text-sm text-base-content/50">12:00 - 14:00</div>
                  </td>
                  <td class="max-w-xs truncate">789 Oak Avenue, Green City</td>
                  <td>
                    <span class="badge badge-lg badge-completed">
                      <i class="fas fa-clipboard-check mr-1"></i>Completed
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
                            <a onclick="openActionModal('Cancel this request?')" class="text-error hover:bg-error/10">
                              <i class="fas fa-times-circle mr-2"></i>Cancel
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- User 4 -->
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="/placeholder-user.jpg" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">Alice Cooper</div>
                        <div class="text-sm text-base-content/50">alice.cooper@example.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">2024-03-23</div>
                    <div class="text-sm text-base-content/50">08:00 - 10:00</div>
                  </td>
                  <td class="max-w-xs truncate">101 Pine Road, Suburban</td>
                  <td>
                    <span class="badge badge-lg badge-cancelled">
                      <i class="fas fa-times-circle mr-1"></i>Cancelled
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
                            <a onclick="openActionModal('Confirm this request?')" class="text-success hover:bg-success/10">
                              <i class="fas fa-check-circle mr-2"></i>Confirm
                            </a>
                          </li>
                        </ul>
                      </div>
                    </div>
                  </td>
                </tr>

                <!-- User 5 -->
                <tr>
                  <td>
                    <div class="flex items-center gap-3">
                      <div class="avatar">
                        <div class="mask mask-circle w-12 h-12">
                          <img src="/placeholder-user.jpg" alt="Avatar">
                        </div>
                      </div>
                      <div>
                        <div class="font-bold">Bob Marley</div>
                        <div class="text-sm text-base-content/50">bob.marley@example.com</div>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="font-medium">2024-03-24</div>
                    <div class="text-sm text-base-content/50">16:00 - 18:00</div>
                  </td>
                  <td class="max-w-xs truncate">345 Maple Street, City Center</td>
                  <td>
                    <span class="badge badge-lg badge-pending">
                      <i class="fas fa-clock mr-1"></i>Pending
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
                            <a onclick="openActionModal('Confirm this request?')" class="text-success hover:bg-success/10">
                              <i class="fas fa-check-circle mr-2"></i>Confirm
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Cancel this request?')" class="text-error hover:bg-error/10">
                              <i class="fas fa-times-circle mr-2"></i>Cancel
                            </a>
                          </li>
                          <li>
                            <a onclick="openActionModal('Mark as completed?')" class="text-info hover:bg-info/10">
                              <i class="fas fa-clipboard-check mr-2"></i>Complete
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
    function openActionModal(message) {
      document.getElementById('modalMessage').innerText = message;
      actionModal.showModal();
    }

    function handleConfirm() {
      // Kirim request ke Laravel atau lakukan aksi
      actionModal.close();
      alert('Action confirmed!');
    }
  </script>

</body>
</html>