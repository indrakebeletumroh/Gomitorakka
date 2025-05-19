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
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maxHeightCollapsed = 72; // 4.5em kira-kira pixel, sesuaikan kalau font beda

            document.querySelectorAll('.post-content-wrapper').forEach(wrapper => {
                const content = wrapper.querySelector('.post-content');
                const btn = wrapper.querySelector('.read-more-btn');

                // Sembunyikan tombol kalau konten pendek
                if (content.scrollHeight <= maxHeightCollapsed) {
                    btn.style.display = 'none';
                    return;
                }

                // Mulai dalam keadaan collapsed
                content.style.maxHeight = maxHeightCollapsed + 'px';
                content.style.overflow = 'hidden';

                btn.textContent = 'Read more';

                btn.addEventListener('click', () => {
                    if (content.style.maxHeight === 'none') {
                        // Collapse
                        content.style.maxHeight = maxHeightCollapsed + 'px';
                        btn.textContent = 'Read more';
                        content.style.overflow = 'hidden';
                    } else {
                        // Expand
                        content.style.maxHeight = 'none';
                        btn.textContent = 'Show less';
                        content.style.overflow = 'visible';
                    }
                });
            });
        });
    </script>

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
        <div class="modal-box w-full max-w-lg">
            <h3 class="font-bold text-lg mb-4">Add a Comment</h3>

            <div id="commentList" class="space-y-4 max-h-60 overflow-y-auto mb-4"></div>

            <form id="commentForm" method="POST" action="">
                @csrf
                <div class="flex items-start gap-3">
                    <div class="avatar">
                        <div class="w-10 rounded-full">
                            <img src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}" />
                        </div>
                    </div>
                    <textarea name="comment" class="textarea textarea-bordered w-full bg-gray-100 text-gray-800" rows="3" placeholder="Write your comment here..." required></textarea>
                </div>
                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">Submit</button>
                    <button type="button" class="btn" onclick="commentModal.close()">Cancel</button>
                </div>
            </form>

        </div>
    </dialog>

    <div class="container mx-auto px-4 py-8 max-w-4xl">
        <div class="bg-white rounded-lg shadow-md border border-gray-100 mb-8 p-4">
            <div class="flex items-start gap-4">
                <div class="avatar">
                    <div class="w-12 rounded-full">
                        <img src="{{ Session::has('profile_picture') ? asset('storage/' . Session::get('profile_picture')) : asset('/images/download.png') }}" alt="User avatar" />
                    </div>
                </div>

                <div class="flex-1">
                    <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <textarea name="content" rows="3" class="textarea textarea-bordered w-full mb-4" placeholder="What's on your mind?" required>{{ old('content') }}</textarea>

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
        </div>

        <div class="space-y-8">
            @foreach ($posts as $post)
            <div class="bg-white rounded-lg shadow-md border border-gray-100 px-5 py-2 ">
                <div class="flex items-center p-4 border-b border-gray-100">
                    <div class="avatar">
                        <div class="w-10 rounded-full ring-1 ring-gray-200">
                            <img src="{{ $post->user->profile_picture ? asset('storage/' . $post->user->profile_picture) : asset('/images/download.png') }}" />
                        </div>
                    </div>
                    <div class="ml-3">
                        <p class="font-semibold text-sm">{{ $post->user->username }}</p>
                        <p class="text-xs text-gray-500">{{ $post->user->location ?? 'Unknown Location' }}</p>
                    </div>
                </div>

                @if ($post->image)
                <div class="aspect-square bg-gray-100">
                    <img src="{{ asset('storage/' . $post->image) }}" class="w-full h-full object-cover" alt="Post image" />
                </div>
                @endif

                <div class="flex items-center space-x-4 p-3">
                    <button class="like-btn" data-post-id="{{ $post->post_id }}">
                        <i class="{{ $post->isLikedBy(session('uid')) ? 'fas text-red-500' : 'far' }} fa-heart"></i>
                    </button>
                    <span class="likes-count" data-post-id="{{ $post->post_id }}">{{ $post->likes_count }} likes</span>

                    <button class="text-2xl hover:text-green-600 comment-btn" data-post-id="{{ $post->post_id }}">
                        <i class="far fa-comment"></i>
                    </button>

                    <span class="comments-count" data-post-id="{{ $post->post_id }}">{{ $post->comments_count }} comments</span>

                    <button class="text-2xl hover:text-green-600 share-btn" data-post-id="{{ $post->post_id }}">
                        <i class="far fa-paper-plane"></i>
                    </button>

                </div>
                <div class="post-content-wrapper">
                    <div class="username font-semibold -mb-12">{{ $post->user->username }}</div>
                    <div class="post-content whitespace-pre-wrap break-words max-h-[4.5em] overflow-hidden transition-[max-height] duration-300 ease-in-out">
                        {!! nl2br(e($post->content)) !!}
                    </div>
                    <button class="read-more-btn text-blue-500 mt-1 text-sm cursor-pointer">Read more</button>
                </div>

                <p class="text-gray-500 text-xs mt-2 px-4 pb-2">{{ $post->created_at->diffForHumans() }}</p>
            </div>
            @endforeach
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.6.1/cropper.min.js"></script>
    <script>
        let cropper = null;
        let originalImageFile = null;

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
                aspectRatio: 1,
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

        document.getElementById('removeImageBtn').classList.add('hidden');

        document.querySelectorAll('.like-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                const icon = btn.querySelector('i.fa-heart');
                icon.classList.toggle('far');
                icon.classList.toggle('fas');
                icon.classList.toggle('liked');
            });
        });

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
            if (interval > 1) return interval + " tahun yang lalu";

            interval = Math.floor(seconds / 2592000);
            if (interval > 1) return interval + " bulan yang lalu";

            interval = Math.floor(seconds / 86400);
            if (interval > 1) return interval + " hari yang lalu";

            interval = Math.floor(seconds / 3600);
            if (interval > 1) return interval + " jam yang lalu";

            interval = Math.floor(seconds / 60);
            if (interval > 1) return interval + " menit yang lalu";

            return "baru saja";
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
                    <div class="flex items-start gap-3">
                        <div class="avatar">
                            <div class="w-10 rounded-full">
                                <img src="${profilePic}" />
                            </div>
                        </div>
                        <div>
                            <p class="font-semibold text-sm">${user.username} <span class="text-xs text-gray-400">· ${timeAgoText}</span></p>
                            <p class="text-sm text-gray-700">${comment.comment}</p>
                        </div>
                    </div>
                `;
                        commentList.innerHTML += html;
                    });
                });
        }

        const commentModal = document.getElementById('commentModal');

        document.getElementById('commentForm').addEventListener('submit', function(e) {
            e.preventDefault();

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
                        commentModal.close();
                    }
                });
        });

        document.querySelectorAll('.share-btn').forEach(button => {
            button.addEventListener('click', async function() {
                const postId = this.dataset.postId;
                const postUrl = `${window.location.origin}/posts/${postId}`;
                const shareData = {
                    title: 'Lihat Postingan Ini',
                    text: 'Cek postingan keren di GomiTorakka!',
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
                    // fallback
                    navigator.clipboard.writeText(postUrl).then(() => {
                        alert("Link disalin ke clipboard!");
                    });
                }
            });
        });
    </script>

    @include('layouts.footer')
</body>

</html>