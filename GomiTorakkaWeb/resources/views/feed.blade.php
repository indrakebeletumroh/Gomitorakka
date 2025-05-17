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

    <style>
        .aspect-square {
            aspect-ratio: 1 / 1;
        }
        
        .textarea {
            border: none;
            resize: none;
            padding: 0.5rem;
            font-size: 0.875rem;
        }
        
        .textarea:focus {
            outline: none;
            box-shadow: none;
        }
        
        .post-like:active {
            transform: scale(1.1);
        }
        
        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
    </style>
</head>

<body class="animate-fade-in">
    @include('layouts.navbar')
    
    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <!-- Create Post Card -->
        <div class="bg-white rounded-lg shadow-md border border-gray-100 mb-8 p-4">
            <div class="flex items-start gap-4">
                <div class="avatar">
                    <div class="w-12 rounded-full">
                        <img src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}" alt="User avatar">
                    </div>
                </div>
                
                <div class="flex-1">
                    <!-- Caption Input -->
                    <textarea 
                        rows="3"
                        class="textarea textarea-bordered w-full mb-4" 
                        placeholder="What's on your mind?"
                    ></textarea>
                    
                    <!-- Image Preview & Upload -->
                    <div class="mb-4">
                        <input 
                            type="file" 
                            id="imageInput"
                            class="hidden"
                            accept="image/*"
                            onchange="previewImage()"
                        >
                        
                        <!-- Image Preview -->
                        <div id="imagePreview" class="hidden aspect-square bg-gray-100 rounded-lg mb-4">
                            <img src="" class="w-full h-full object-cover rounded-lg" alt="Preview">
                        </div>
                        
                        <!-- Upload Button -->
                        <label for="imageInput" class="btn btn-outline btn-sm gap-2">
                            <i class="fas fa-image"></i>
                            Upload Photo
                        </label>
                    </div>
                    
                    <!-- Submit Button -->
                    <div class="text-right">
                        <button class="btn btn-primary btn-sm">
                            Post
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Posts Feed -->
        <div class="space-y-8">
            <!-- Sample Post 1 -->
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

                <!-- Post Actions -->
                <div class="flex items-center space-x-4 p-3">
                    <button class="text-2xl hover:text-green-600 post-like">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="text-2xl hover:text-green-600">
                        <i class="far fa-comment"></i>
                    </button>
                    <button class="text-2xl hover:text-green-600">
                        <i class="far fa-paper-plane"></i>
                    </button>
                </div>

                <!-- Likes -->
                <p class="font-semibold text-sm px-4">1,234 likes</p>

                <!-- Caption -->
                <div class="text-sm px-4 py-2">
                    <span class="font-semibold">johndoe</span>
                    Enjoying the beautiful scenery in the mountains! 🏔️✨
                    <p class="text-gray-500 text-xs mt-1">#nature #adventure</p>
                </div>

                <!-- Comments -->
                <div class="text-sm text-gray-500 px-4 pb-2">
                    <button class="hover:text-green-600">View all 45 comments</button>
                    <p class="mt-1"><span class="font-semibold">janedoe</span> Wow amazing view! 😍</p>
                    <p class="mt-1"><span class="font-semibold">hiking_lover</span> Which trail is this?</p>
                </div>

                <!-- Time Posted -->
                <p class="text-gray-500 text-xs mt-2 px-4 pb-2">3 HOURS AGO</p>
            </div>
            
            <!-- Sample Post 2 -->
            <div class="bg-white rounded-lg shadow-md border border-gray-100 px-5 py-2">
                <!-- Post Header -->
                <div class="flex items-center p-4 border-b border-gray-100">
                    <div class="avatar">
                        <div class="w-10 rounded-full ring-1 ring-gray-200">
                            <img src="https://i.pravatar.cc/100?u=user2" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-sm">janedoe</p>
                        <p class="text-xs text-gray-500">Osaka, Japan</p>
                    </div>
                </div>

                <!-- Post Image -->
                <div class="aspect-square bg-gray-100">
                    <img src="https://source.unsplash.com/random/800x800?city"
                        class="w-full h-full object-cover"
                        alt="Post image">
                </div>

                <!-- Post Actions -->
                <div class="flex items-center space-x-4 p-3">
                    <button class="text-2xl hover:text-green-600 post-like">
                        <i class="far fa-heart"></i>
                    </button>
                    <button class="text-2xl hover:text-green-600">
                        <i class="far fa-comment"></i>
                    </button>
                    <button class="text-2xl hover:text-green-600">
                        <i class="far fa-paper-plane"></i>
                    </button>
                </div>

                <!-- Likes -->
                <p class="font-semibold text-sm px-4">892 likes</p>

                <!-- Caption -->
                <div class="text-sm px-4 py-2">
                    <span class="font-semibold">janedoe</span>
                    Exploring the vibrant streets of Osaka today! The food here is amazing! 🍣🍜
                    <p class="text-gray-500 text-xs mt-1">#osaka #japan #travel</p>
                </div>

                <!-- Comments -->
                <div class="text-sm text-gray-500 px-4 pb-2">
                    <button class="hover:text-green-600">View all 23 comments</button>
                    <p class="mt-1"><span class="font-semibold">traveler123</span> What's your favorite dish so far?</p>
                </div>

                <!-- Time Posted -->
                <p class="text-gray-500 text-xs mt-2 px-4 pb-2">5 HOURS AGO</p>
            </div>
        </div>
    </div>

    <script>
        // Image preview functionality
        function previewImage() {
            const input = document.getElementById('imageInput');
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = previewContainer.querySelector('img');
            
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewImage.src = e.target.result;
                    previewContainer.classList.remove('hidden');
                }
                
                reader.readAsDataURL(input.files[0]);
            }
        }
        
        // Like button functionality
        document.querySelectorAll('.post-like').forEach(button => {
            button.addEventListener('click', function() {
                const icon = this.querySelector('i');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.classList.toggle('text-red-500');
            });
        });
    </script>

    @include('layouts.footer')
</body>
</html>