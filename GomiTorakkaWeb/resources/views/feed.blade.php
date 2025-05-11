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
    <div class="container mx-auto px-4 py-8 max-w-4xl">

        <!-- Tambahkan di bagian head -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Content Feed -->
        <div class="container mx-auto px-4 py-8 max-w-4xl">
            <!-- Post Container -->
            <div class="space-y-8">
                <!-- Post 1 -->
                <div class="bg-white rounded-lg shadow-md border border-gray-100 px-5 py-2">
                    <!-- Post Header -->
                    <div class="flex items-center p-4 border-b border-gray-100">
                        <div class="avatar">
                            <div class="w-10 rounded-full ring-1 ring-gray-200">
                                <img src="https://i.pravatar.cc/100?u=user1" />
                            </div>
                        </div>
                        <div class="ml-3">
                            <p class="font-semibold text-sm">johndoe</p>
                            <p class="text-xs text-gray-500">Tokyo, Japan</p>
                        </div>
                    </div>

                    <!-- Post Image -->
                    <div class="aspect-square bg-gray-100">
                        <img src="https://source.unsplash.com/random/800x800?nature"
                            class="w-full h-full object-cover"
                            alt="Post image">
                    </div>

                    <!-- Ganti bagian tombol comment dan share di post card -->
                    <div class="flex items-center space-x-4">
                        <button class="text-2xl hover:text-green-600 post-like">
                            <i class="far fa-heart"></i>
                        </button>
                        <button onclick="toggleCommentModal()" class="text-2xl hover:text-green-600">
                            <i class="far fa-comment"></i>
                        </button>
                        <button onclick="toggleShareModal()" class="text-2xl hover:text-green-600">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>

                    <!-- Likes -->
                    <p class="font-semibold text-sm">1,234 likes</p>

                    <!-- Caption -->
                    <div class="text-sm">
                        <span class="font-semibold">johndoe</span>
                        Enjoying the beautiful scenery in the mountains! 🏔️✨
                        <p class="text-gray-500 text-xs mt-1">#nature #adventure</p>
                    </div>

                    <!-- Comments -->
                    <div class="text-sm text-gray-500">
                        <button class="hover:text-green-600">View all 45 comments</button>
                        <p class="mt-1"><span class="font-semibold">janedoe</span> Wow amazing view! 😍</p>
                        <p class="mt-1"><span class="font-semibold">hiking_lover</span> Which trail is this?</p>
                    </div>

                    <!-- Time Posted -->
                    <p class="text-gray-500 text-xs mt-2">3 HOURS AGO</p>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <!-- Comment Modal -->
    <div id="commentModal" class="modal">
        <div class="modal-box max-w-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-bold text-lg">Comments</h3>
                <button onclick="toggleCommentModal()" class="btn btn-sm btn-circle btn-ghost">✕</button>
            </div>

            <div class="h-96 overflow-y-auto space-y-4">
                <!-- Existing Comments -->
                <div class="flex items-start gap-3">
                    <div class="avatar">
                        <div class="w-8 rounded-full">
                            <img src="https://i.pravatar.cc/100?u=user2" />
                        </div>
                    </div>
                    <div class="flex-1">
                        <div class="bg-gray-100 rounded-lg p-3">
                            <p class="font-semibold text-sm">janedoe</p>
                            <p class="text-sm">Wow amazing view! 😍</p>
                        </div>
                        <div class="text-xs text-gray-500 mt-1">2 hours ago</div>
                    </div>
                </div>
            </div>

            <!-- Comment Input -->
            <div class="modal-action pt-4 border-t border-gray-100">
                <div class="flex items-center gap-2 w-full">
                    <input type="text" placeholder="Add a comment..."
                        class="input input-bordered flex-1 input-sm" />
                    <button class="btn btn-sm btn-ghost text-green-600">Post</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Share Modal -->
    <div id="shareModal" class="modal">
        <div class="modal-box max-w-md">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg">Share Post</h3>
                <button onclick="toggleShareModal()" class="btn btn-sm btn-circle btn-ghost">✕</button>
            </div>

            <div class="space-y-4">
                <button class="btn btn-block justify-start gap-3 hover:bg-gray-50">
                    <i class="fab fa-facebook text-blue-600"></i>
                    Share to Facebook
                </button>

                <button class="btn btn-block justify-start gap-3 hover:bg-gray-50">
                    <i class="fab fa-twitter text-blue-400"></i>
                    Share to Twitter
                </button>

                <button class="btn btn-block justify-start gap-3 hover:bg-gray-50">
                    <i class="fab fa-whatsapp text-green-500"></i>
                    Share via WhatsApp
                </button>

                <div class="divider">OR</div>

                <div class="flex items-center gap-2 bg-gray-50 p-3 rounded-lg">
                    <input type="text" value="https://gomitorakka/post/123"
                        class="input input-ghost flex-1 input-sm" readonly />
                    <button class="btn btn-sm" onclick="copyLink()">Copy</button>
                </div>
            </div>
        </div>
    </div>
    <script>
        // Like button functionality
        document.querySelectorAll('.post-like').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.classList.toggle('text-red-500');
            });
        });
        // Toggle Comment Modal
        function toggleCommentModal(postId) {
            const modal = document.getElementById('commentModal');
            modal.classList.toggle('modal-open');
        }

        // Toggle Share Modal
        function toggleShareModal(postId) {
            const modal = document.getElementById('shareModal');
            modal.classList.toggle('modal-open');
        }

        // Copy Link Function
        function copyLink() {
            const copyText = document.querySelector('#shareModal input');
            copyText.select();
            document.execCommand('copy');
            alert('Link copied to clipboard!');
        }

        // Close modals when clicking outside
        window.onclick = function(event) {
            const modals = document.querySelectorAll('.modal');
            modals.forEach(modal => {
                if (event.target == modal) {
                    modal.classList.remove('modal-open');
                }
            });
        }
    </script>

    <style>
        .aspect-square {
            aspect-ratio: 1 / 1;
        }

        .post-like:active {
            transform: scale(1.1);
        }

        
    </style>

    @include('layouts.footer')

</body>

</html>