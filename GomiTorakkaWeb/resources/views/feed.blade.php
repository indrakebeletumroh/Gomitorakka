<!DOCTYPE html>
<html lang="en" data-theme="emerald">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Feed - GomiTorakka - Smart Waste Management</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" href="{{ asset('images/restuIcon.ico') }}" type="image/x-icon">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />

    <link href="https://cdn.jsdelivr.net/npm/daisyui@5" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/daisyui@5/themes.css" rel="stylesheet" type="text/css" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.css" />
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

        .animate-fade-in {
            animation: fadeIn 0.5s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        #removeImageBtn {
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        #removeImageBtn:hover {
            transform: scale(1.1);
            transition: transform 0.2s ease;
        }

        .like-btn {
            transition: transform 0.2s ease;
            cursor: pointer;
            background: none;
            border: none;
            padding: 0;
        }

        .like-btn:active {
            transform: scale(1.2);
        }

        .fa-heart {
            transition: color 0.3s ease;
        }

        .liked {
            color: #dc2626;
        }

        /* Improved post styling */
        .post-container {
            position: relative;
        }

        .post-actions {
            display: flex;
            align-items: center;
            gap: 16px;
            padding: 8px 16px;
        }

        .post-actions span {
            font-size: 0.875rem;
        }

        /* Comment modal styling */
        .comment-modal-content {
            max-height: 90vh;
            display: flex;
            flex-direction: column;
        }

        .comment-list {
            flex: 1;
            overflow-y: auto;
            padding-right: 8px;
        }

        /* Fixed size for profile pictures */
        .fixed-avatar {
            width: 40px;
            height: 40px;
            flex-shrink: 0;
        }

        .fixed-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        /* Improved comment styling */
        .comment-item {
            display: flex;
            gap: 12px;
            margin-bottom: 12px;
        }

        .comment-content-wrapper {
            flex: 1;
        }

        .comment-text {
            white-space: pre-wrap;
            word-break: break-word;
            line-height: 1.4;
            margin: 0;
        }

        .comment-meta {
            display: flex;
            align-items: center;
            margin-bottom: 4px;
        }

        .comment-username {
            font-weight: 600;
            font-size: 0.875rem;
            margin-right: 6px;
        }

        .comment-time {
            color: #6b7280;
            font-size: 0.75rem;
        }

        /* Post content styling */
        .post-content-wrapper {
            padding: 0 16px 8px;
            margin-bottom: 0;
        }

        .post-content {
            white-space: pre-wrap;
            word-break: break-word;
            line-height: 1.5;
            margin: 0;
            font-size: 0.875rem;
            text-align: left;
        }

        .post-content.collapsed {
            overflow: hidden;
            display: -webkit-box;
            -webkit-box-orient: vertical;
        }
        
        .post-content.has-image.collapsed {
            -webkit-line-clamp: 1; /* 1 line for posts with images */
        }
        
        .post-content.no-image.collapsed {
            -webkit-line-clamp: 5; /* 5 lines for posts without images */
        }

        .comment-content.collapsed {
            max-height: 3em; /* 2 lines */
            overflow: hidden;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }

        .read-more-btn {
            color: #3b82f6;
            background: none;
            border: none;
            padding: 0;
            font-size: 0.875rem;
            cursor: pointer;
            margin-top: 4px;
            display: inline-block;
        }

        .read-more-btn:hover {
            text-decoration: underline;
        }

        /* Dropdown menu styling */
        .post-dropdown {
            position: absolute;
            top: 8px;
            right: 8px;
        }

        .dropdown-menu {
            position: absolute;
            right: 0;
            top: 100%;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            z-index: 10;
            min-width: 120px;
        }

        .dropdown-item {
            padding: 8px 12px;
            font-size: 0.875rem;
            color: #dc2626;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background-color: #f3f4f6;
        }

        /* Post header styling */
        .post-header {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
        }

        .post-username {
            font-weight: 600;
            font-size: 0.875rem;
        }

        .post-time {
            color: #6b7280;
            font-size: 0.75rem;
            margin-top: 2px;
        }

        /* Comment input styling */
        .comment-input-container {
            padding: 12px 16px;
            border-top: 1px solid #e5e7eb;
        }

        /* Post image styling */
        .post-image-container {
            padding: 0 16px;
            margin-bottom: 8px;
        }

        .post-image {
            max-width: 100%;
            max-height: 500px;
            border-radius: 8px;
            object-fit: contain;
            margin: 0 auto;
            display: block;
        }
        
        /* Custom scrollbar */
        .comment-list::-webkit-scrollbar {
            width: 6px;
        }
        
        .comment-list::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }
        
        .comment-list::-webkit-scrollbar-thumb {
            background: #c5c5c5;
            border-radius: 10px;
        }
        
        .comment-list::-webkit-scrollbar-thumb:hover {
            background: #a8a8a8;
        }
        
        /* Empty state styling */
        .empty-content {
            text-align: center;
            padding: 20px;
            color: #6b7280;
            font-size: 0.9rem;
        }
        
        .empty-content i {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #9ca3af;
        }
    </style>
</head>

<body class="animate-fade-in">
    @include('layouts.navbar')

    <dialog id="cropModal" class="modal">
        <div class="modal-box max-w-2xl">
            <h3 class="font-bold text-lg mb-4">Crop Your Image</h3>
            <div class="img-container w-full h-96 bg-gray-100">
                <img id="imageToCrop" class="max-w-full h-full object-contain" />
            </div>
            <div class="modal-action">
                <button type="button" class="btn btn-primary" id="confirmCrop">Crop & Save</button>
                <button type="button" class="btn" onclick="closeCropModal()">Cancel</button>
            </div>
        </div>
    </dialog>

    <dialog id="commentModal" class="modal">
        <div class="modal-box w-full max-w-lg comment-modal-content">
            <h3 class="font-bold text-lg mb-4">Comments</h3>

            <div id="commentList" class="comment-list mb-4"></div>

            <form id="commentForm" method="POST" action="" class="comment-input-container">
                @csrf
                <div class="flex items-start gap-3">
                    <div class="fixed-avatar">
                        <img src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}" />
                    </div>
                    <div class="flex-1">
                        <textarea name="comment"
                            class="textarea textarea-bordered w-full bg-gray-100 text-gray-800"
                            rows="3"
                            placeholder="Write your comment here..."
                            maxlength="2000"
                            required></textarea>
                        <div class="text-right text-xs text-gray-500 mt-1">
                            <span id="commentCharCount">0</span>/2000 characters
                        </div>
                    </div>
                </div>
                <div class="modal-action mt-4">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn" onclick="commentModal.close()">Cancel</button>
                </div>
            </form>
        </div>
    </dialog>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md border border-gray-100 mb-8 p-4">
            @if (Session::has('username'))
            <div class="flex items-start gap-4">
                <div class="fixed-avatar">
                    <img src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}" alt="User avatar" />
                </div>

                <div class="flex-1">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data" id="postForm">
                        @csrf
                        <textarea name="content" id="postContent" rows="3" class="textarea textarea-bordered w-full mb-4" placeholder="What's on your mind?" maxlength="4000" required>{{ old('content') }}</textarea>
                        <div class="text-right text-xs text-gray-500 mb-4">
                            <span id="postCharCount">0</span>/4000 characters
                        </div>

                        <div class="mb-4">
                            <input type="file" name="image" id="imageInput" class="hidden" accept="image/*" />
                            <div id="imagePreview" class="hidden aspect-square bg-gray-100 rounded-lg mb-4 relative">
                                <img src="" class="w-full h-full object-cover rounded-lg" alt="Preview" />
                                <button type="button" id="removeImageBtn" class="absolute top-2 right-2 btn btn-circle btn-xs btn-error" onclick="removeImage()">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <label for="imageInput" class="btn btn-outline btn-sm gap-2">
                                <i class="fas fa-image"></i> Upload Photo
                            </label>
                        </div>

                        <div class="text-right">
                            <button class="btn btn-primary btn-sm" type="submit">Post</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif
        </div>

        <div class="space-y-8" id="postsContainer">
            @if($posts->count() > 0)
                @foreach ($posts as $post)
                <div class="post-container bg-white rounded-lg shadow-md border border-gray-100">
                    @if ($currentUserId == $post->user_id || $currentUserRole === 'admin')
                    <div class="post-dropdown">
                        <button onclick="toggleDropdown('{{ $post->post_id }}')" class="text-gray-500 hover:text-gray-700 focus:outline-none text-xl">
                            ⋮
                        </button>
                        <div id="dropdown-{{ $post->post_id }}" class="hidden dropdown-menu">
                            <form action="{{ route('posts.destroy', $post->post_id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this post?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="dropdown-item">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                    @endif

                    <div class="post-header">
                        <div class="fixed-avatar">
                            <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('/images/download.png') }}" alt="{{ $post->user->username }}" />
                        </div>
                        <div>
                            <div class="post-username">{{ $post->user->username }}</div>
                            <div class="post-time">{{ $post->created_at->diffForHumans() }}</div>
                        </div>
                    </div>

                    @if ($post->image)
                    <div class="post-image-container">
                        <img src="{{ asset('storage/' . $post->image) }}" class="post-image" alt="Post image" />
                    </div>
                    @endif

                    <div class="post-content-wrapper">
                        <div class="post-content collapsed @if($post->image) has-image @else no-image @endif" id="postContent-{{ $post->post_id }}">
                            {!! nl2br(e($post->content)) !!}
                        </div>
                        <button class="read-more-btn" data-post-id="{{ $post->post_id }}">Read more</button>
                    </div>

                    <div class="post-actions">
                        <button class="like-btn" data-post-id="{{ $post->post_id }}">
                            <i class="{{ $post->isLikedBy(session('uid')) ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                        </button>
                        <span class="likes-count" data-post-id="{{ $post->post_id }}">{{ $post->likes_count }} likes</span>

                        <button class="text-xl hover:text-green-600 comment-btn" data-post-id="{{ $post->post_id }}">
                            <i class="far fa-comment"></i>
                        </button>

                        <span class="comments-count" data-post-id="{{ $post->post_id }}">{{ $post->comments_count }} comments</span>

                        <button class="text-xl hover:text-green-600 share-btn" data-post-id="{{ $post->post_id }}">
                            <i class="far fa-paper-plane"></i>
                        </button>
                    </div>
                </div>
                @endforeach
            @else
                <div class="empty-content bg-white rounded-lg shadow-md border border-gray-100 p-8 text-center">
                    <i class="fas fa-comment-slash text-4xl mb-4"></i>
                    <h3 class="text-lg font-medium mb-2">No posts yet</h3>
                    <p class="text-gray-600">Be the first to share something with the community!</p>
                </div>
            @endif
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        let cropper = null;
        let originalImageFile = null;

        document.addEventListener('DOMContentLoaded', () => {
            // Initialize post content read more functionality
            initializeReadMoreButtons();
            
            // Initialize overflow detection for posts
            checkTextOverflow();
            
            // Character counter for post content
            const postTextarea = document.getElementById('postContent');
            if (postTextarea) {
                postTextarea.addEventListener('input', function() {
                    const charCount = this.value.length;
                    document.getElementById('postCharCount').textContent = charCount;
                });
                
                // Initialize character count
                document.getElementById('postCharCount').textContent = postTextarea.value.length;
            }
            
            // Add validation for empty posts
            const postForm = document.getElementById('postForm');
            if (postForm) {
                postForm.addEventListener('submit', function(e) {
                    const content = document.getElementById('postContent').value.trim();
                    const hasImage = document.getElementById('imageInput').files.length > 0;
                    
                    if (!content && !hasImage) {
                        e.preventDefault();
                        alert('Post cannot be empty. Please write something or upload an image.');
                    }
                });
            }
        });
        
        function initializeReadMoreButtons() {
            document.querySelectorAll('.read-more-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const content = document.getElementById(`postContent-${postId}`);
                    content.classList.toggle('collapsed');
                    this.textContent = content.classList.contains('collapsed') ? 'Read more' : 'Show less';
                });
            });
        }
        
        function checkTextOverflow() {
            document.querySelectorAll('.post-content').forEach(content => {
                const btn = content.nextElementSibling;
                if (!btn || !btn.classList.contains('read-more-btn')) return;
                
                // Check if content is overflowing
                const isOverflowing = content.scrollHeight > content.clientHeight;
                
                // Hide button if not overflowing
                if (!isOverflowing) {
                    btn.style.display = 'none';
                }
            });
        }

        document.getElementById('imageInput').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                originalImageFile = file;
                showCropModal(file);
                document.getElementById('removeImageBtn').classList.remove('hidden');
            }
        });

        function showCropModal(file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('imageToCrop').src = e.target.result;
                document.getElementById('cropModal').showModal();
                initCropper();
            };
            reader.readAsDataURL(file);
        }

        function initCropper() {
            const image = document.getElementById('imageToCrop');
            if (cropper) {
                cropper.destroy();
            }
            cropper = new Cropper(image, {
                aspectRatio: NaN, // Free aspect ratio (rectangular)
                viewMode: 2,
                autoCropArea: 1,
                responsive: true,
                guides: false,
                background: false,
            });
        }

        document.getElementById('confirmCrop').addEventListener('click', function() {
            const canvas = cropper.getCroppedCanvas({
                width: 1080,
                height: 1080,
                fillColor: '#fff',
                imageSmoothingQuality: 'high',
            });

            canvas.toBlob((blob) => {
                const croppedFile = new File([blob], 'cropped-image.jpg', {
                    type: 'image/jpeg',
                    lastModified: Date.now(),
                });

                const dataTransfer = new DataTransfer();
                dataTransfer.items.add(croppedFile);
                document.getElementById('imageInput').files = dataTransfer.files;

                const previewUrl = URL.createObjectURL(blob);
                const previewImage = document.getElementById('imagePreview').querySelector('img');
                previewImage.src = previewUrl;
                document.getElementById('imagePreview').classList.remove('hidden');

                if (previewImage.dataset.originalUrl) {
                    URL.revokeObjectURL(previewImage.dataset.originalUrl);
                }
                previewImage.dataset.originalUrl = previewUrl;

                closeCropModal();
            }, 'image/jpeg', 0.9);
        });

        function closeCropModal() {
            document.getElementById('cropModal').close();
            if (cropper) {
                cropper.destroy();
                cropper = null;
            }
        }

        function removeImage() {
            const fileInput = document.getElementById('imageInput');
            const previewContainer = document.getElementById('imagePreview');
            const previewImage = previewContainer.querySelector('img');

            fileInput.value = '';
            previewImage.src = '';
            previewContainer.classList.add('hidden');

            if (previewImage.dataset.originalUrl) {
                URL.revokeObjectURL(previewImage.dataset.originalUrl);
                delete previewImage.dataset.originalUrl;
            }

            document.getElementById('removeImageBtn').classList.add('hidden');
        }

        document.querySelectorAll('.like-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.dataset.postId;
                fetch(`/posts/${postId}/like`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json',
                        },
                    })
                    .then(res => res.json())
                    .then(data => {
                        const icon = this.querySelector('i');
                        if (data.status === 'liked') {
                            icon.classList.remove('far');
                            icon.classList.add('fas', 'text-red-500');
                        } else if (data.status === 'unliked') {
                            icon.classList.remove('fas', 'text-red-500');
                            icon.classList.add('far');
                        }
                        const likesCountElem = document.querySelector(`.likes-count[data-post-id="${postId}"]`);
                        if (likesCountElem) likesCountElem.textContent = `${data.likesCount} likes`;
                    });
            });
        });

        document.querySelectorAll('.comment-btn').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.dataset.postId;
                const form = document.getElementById('commentForm');
                form.action = `/posts/${postId}/comments`;
                loadComments(postId);
                commentModal.showModal();
            });
        });

        function timeAgo(dateString) {
            const now = new Date();
            const commentDate = new Date(dateString);
            const seconds = Math.floor((now - commentDate) / 1000);

            let interval = Math.floor(seconds / 31536000);
            if (interval > 1) return interval + " years ago";

            interval = Math.floor(seconds / 2592000);
            if (interval > 1) return interval + " months ago";

            interval = Math.floor(seconds / 86400);
            if (interval > 1) return interval + " days ago";

            interval = Math.floor(seconds / 3600);
            if (interval > 1) return interval + " hours ago";

            interval = Math.floor(seconds / 60);
            if (interval > 1) return interval + " minutes ago";

            return "just now";
        }

        function loadComments(postId) {
            const commentList = document.getElementById('commentList');
            commentList.innerHTML = '<p class="text-sm text-gray-500">Loading comments...</p>';

            fetch(`/posts/${postId}/comments`)
                .then(res => res.json())
                .then(comments => {
                    commentList.innerHTML = '';
                    if (comments.length === 0) {
                        commentList.innerHTML = '<p class="text-sm text-gray-500">No comments yet.</p>';
                        return;
                    }

                    comments.forEach(comment => {
                        const user = comment.user;
                        const profilePic = user.profile_picture ? `/storage/${user.profile_picture}` : '/images/download.png';
                        const timeAgoText = timeAgo(comment.created_at);

                        const html = `
                            <div class="comment-item">
                                <div class="fixed-avatar">
                                    <img src="${profilePic}" />
                                </div>
                                <div class="comment-content-wrapper">
                                    <div class="comment-meta">
                                        <span class="comment-username">${user.username}</span>
                                        <span class="comment-time">${timeAgoText}</span>
                                    </div>
                                    <div class="comment-text ${comment.comment.length > 100 ? 'comment-content collapsed' : ''}">${comment.comment}</div>
                                    ${comment.comment.length > 100 ? '<button class="read-more-btn">Read more</button>' : ''}
                                </div>
                            </div>
                        `;
                        commentList.insertAdjacentHTML('beforeend', html);
                    });

                    // Add event listeners to comment read more buttons
                    document.querySelectorAll('#commentList .read-more-btn').forEach(btn => {
                        btn.addEventListener('click', function() {
                            const content = this.previousElementSibling;
                            content.classList.toggle('collapsed');
                            this.textContent = content.classList.contains('collapsed') ? 'Read more' : 'Show less';
                        });
                    });
                });
        }

        const commentModal = document.getElementById('commentModal');

        // Add character counter for comments
        const commentTextarea = document.querySelector('#commentForm textarea');
        if (commentTextarea) {
            commentTextarea.addEventListener('input', function() {
                const charCount = this.value.length;
                document.getElementById('commentCharCount').textContent = charCount;
            });
        }

        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

            const commentText = this.querySelector('textarea').value;
            if (commentText.trim().length === 0) {
                alert('Comment cannot be empty');
                return;
            }
            
            if (commentText.length > 2000) {
                alert('Comment cannot exceed 2000 characters');
                return;
            }

            const form = this;
            const url = form.action;
            const formData = new FormData(form);

            fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        form.reset();
                        document.getElementById('commentCharCount').textContent = '0';
                        loadComments(data.post_id || document.querySelector('.comment-btn').dataset.postId);
                    }
                });
        });

        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const postId = this.dataset.postId;
                const postUrl = `${window.location.origin}/posts/${postId}`;
                const shareData = {
                    title: 'Check out this post',
                    text: 'See this interesting post on GomiTorakka!',
                    url: postUrl
                };

                if (navigator.share) {
                    try {
                        await navigator.share(shareData);
                        console.log('Shared successfully');
                    } catch (err) {
                        console.error('Share failed:', err.message);
                    }
                } else {
                    navigator.clipboard.writeText(postUrl).then(() => {
                        alert("Link copied to clipboard!");
                    });
                }
            });
        });

        function toggleDropdown(postId) {
            // Hide all other dropdowns
            document.querySelectorAll('[id^="dropdown-"]').forEach(drop => {
                if (!drop.id.endsWith(postId)) {
                    drop.classList.add('hidden');
                }
            });

            // Toggle clicked dropdown
            const dropdown = document.getElementById('dropdown-' + postId);
            if (dropdown) {
                dropdown.classList.toggle('hidden');
            }
        }

        // Click outside dropdown will close all
        document.addEventListener('click', function(event) {
            const isDropdownButton = event.target.matches('button[onclick^="toggleDropdown"]');
            if (!isDropdownButton) {
                document.querySelectorAll('[id^="dropdown-"]').forEach(drop => drop.classList.add('hidden'));
            }
        });
    </script>

    @include('layouts.footer')
</body>

</html>