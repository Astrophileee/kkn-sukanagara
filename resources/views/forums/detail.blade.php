@extends('layouts.app')

<style>
    #modal-image {
        transition: transform 0.3s ease, transform-origin 0.3s ease;
        cursor: zoom-in;
    }

    #modal-image.zoomed {
        cursor: zoom-out;
    }

</style>


@section('content')
    <div class="max-w bg-white p-6 rounded-lg shadow">
        <a href="{{ route('forums.index') }}"><i class="fa-solid fa-arrow-left"></i> back</a>
        @if (auth()->id() === $forum->id_user)
            <div class="relative inline-block text-left float-right">
                <button id="dropdownToggleOption" onclick="toggleDropdownOption()" class="text-gray-500 hover:text-gray-700 focus:outline-none">
                    <i class="fa-solid fa-ellipsis-vertical text-xl"></i>
                </button>
                <div id="dropdownMenuOption" class="hidden absolute right-0 mt-2 w-40 bg-white border border-gray-200 rounded shadow-md z-10">
                    <a href="javascript:void(0)" onclick="openEditModal({{ $forum->toJson() }})"
                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                        <i class="fa-solid fa-pen mr-2"></i>Edit Forum
                    </a>
                    <form id="delete-form-{{ $forum->id }}" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" onclick="confirmDelete({{ $forum->id }})"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                            <i class="fa-solid fa-trash mr-2"></i>Hapus Forum
                        </button>
                    </form>
                </div>
            </div>
        @endif
            {{-- Header: Judul --}}
    <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $forum->judul }}</h1>

    {{-- Info User + Waktu --}}
    <div class="flex mb-4">
            <img src="{{ asset($forum->user ? $forum->user->photo_url : '/images/default-image-square.png') }}" alt="User Photo"
                class="w-10 h-10 rounded-full mr-3">
        <div class="text-sm text-gray-700 ">
            <div class="font-semibold">
                {{ $forum->user->name ?? 'Akun telah dihapus' }}
                @if($forum->created_at->diffInDays(now()) >= 1)
                    {{ $forum->created_at->format('d/m/y H:i') }}
                @else
                    {{ $forum->created_at->diffForHumans() }}
                @endif
            </div>
            <div class="text-gray-500 text-xs">
                {!! nl2br(e($forum->isi)) !!}
            </div>
        </div>
    </div>
    {{-- Foto --}}
    @if ($forum->photo)
        <div class="mb-4">
            <img src="{{ asset('storage/' . $forum->photo) }}"
                onclick="openImageModal(this.src)"
                class="max-w-full max-h-[400px] object-cover rounded cursor-pointer" alt="Forum Photo">
        </div>
    @endif
    @if ($forum->id_submission)
        @php
                $status = strtolower($submission->status);
                $badge = match($status) {
                    'pending' => ['label' => 'Pending', 'bg' => 'bg-orange-100', 'text' => 'text-orange-700'],
                    'reject'  => ['label' => 'Rejected', 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                    'accept', 'approved' => ['label' => 'Accepted', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                    default   => ['label' => ucfirst($submission->status), 'bg' => 'bg-red-100', 'text' => 'text-red-700'],
                };
            @endphp
                <a href="{{ route('submissions.show', $submission) }}" class="block max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">
                    <div class="p-4">
                        <div class="text-sm text-gray-500 mb-1">
                            <span class="font-semibold text-gray-800">{{ $submission->nama_pengaju }}</span> •
                            <span>dibuat {{ $submission->created_at->diffForHumans() }} • </span>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $badge['bg'] }} {{ $badge['text'] }}">
                                {{ $badge['label'] }}
                            </span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            {{ $submission->judul }}
                        </h2>
                        <div class="w-full h-24 text-sm text-gray-600 overflow-hidden">
                                {{ Str::limit(strip_tags($submission->isi), 200) }}
                        </div>
                    </div>
                </a>
    @endif

    {{-- Garis Pembatas --}}
    <hr class="my-6 border-t border-gray-300">

    {{-- Komentar Section --}}
    <div class="mb-28">
        <h2 class="text-lg font-semibold mb-4 text-gray-800">Komentar</h2>
        <div class="" id="comment-list">
            @forelse ($forum->comments as $comment)
                @include('layouts.partials.comments')
            @empty
                <p class="text-sm text-gray-500">Belum ada komentar.</p>
            @endforelse
        </div>
    </div>
    <!-- Modal Gambar -->
    <div id="image-modal" class="fixed inset-0 bg-black bg-opacity-70 flex items-center justify-center z-50 hidden overflow-hidden">
        <span onclick="closeImageModal()" class="absolute top-4 right-6 text-white text-3xl cursor-pointer z-50">&times;</span>
        <div class="relative">
            <img id="modal-image" src="" class="max-w-full max-h-[90vh] rounded shadow-lg" alt="Zoomable Image">
        </div>
    </div>


        {{-- Sticky Input Komentar --}}
        <form action="" id="comment-form" method="POST" enctype="multipart/form-data"
            class="sticky bottom-0 bg-white border-t border-gray-300 px-4 py-3 z-10 space-y-2">
            @csrf
            <input type="hidden" name="forum_id" value="{{ $forum->id }}">
            {{-- Preview Gambar --}}
            <div id="image-preview-container" class="relative inline-block mb-2 hidden">
                <img id="image-preview" src=""
                onclick="openImageModal(this.src)"
                class="max-h-40 rounded shadow object-cover cursor-pointer">
                <button type="button" onclick="removeImage()" class="absolute top-1 right-1">
                    <i class="fa-solid fa-trash-can text-sm text-red-500"></i>
                </button>
            </div>
            <div class="flex items-start gap-2">
                {{-- Tombol Upload Foto --}}
                <label for="comment-photo" class="cursor-pointer text-gray-500 hover:text-gray-700 pt-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M12 4v16m8-8H4" />
                    </svg>
                </label>
                <input type="file" name="photo" id="comment-photo" class="hidden" accept="image/*">

                {{-- Textarea Komentar --}}
                <div class="flex-1">
                    <textarea name="isi" id="comment-text" rows="1"
                        placeholder="Tulis komentar..." required maxlength="1000"
                        class="resize-none border border-gray-300 rounded-md px-3 py-2 w-full text-sm focus:outline-none focus:ring focus:border-black max-h-[160px] overflow-auto"
                        oninput="autoResize(this); updateCharCount(this)"></textarea>
                </div>

                {{-- Tombol Kirim --}}
                <button type="button" onclick="handleSubmitComment()"
                    class="bg-black text-white px-4 py-2 rounded-md text-sm hover:bg-gray-800 h-fit">Kirim</button>
            </div>

            {{-- Karakter Counter --}}
            <div class="text-xs text-gray-500 text-right pr-2">
                <span id="char-remaining" class="text-gray-500">500</span> karakter tersisa
            </div>
        </form>

    </div>



    <!-- Modal Edit -->
<div id="modal-edit-forum" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <button onclick="document.getElementById('modal-edit-forum').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit Forum</h2>

            <form id="editForumForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1" id="label-foto">Foto (optional)</label>
                        <div class="border-2 border-dashed rounded-lg p-4 text-center">
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="hidden" id="editPhotoInput" onchange="previewPhoto(event)">
                            <label for="editPhotoInput" class="cursor-pointer inline-block px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700">
                                Upload file
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Hanya mendukung format file: .jpg, .jpeg, .png</p>
                            <div id="photoPreviewContainer" class="mt-4 hidden">
                                <img id="photoPreview" class="mx-auto w-full max-w-md h-auto object-cover border rounded-md" alt="Preview Foto">
                            </div>
                            <div id="previewEditPhotoContainer" class="mt-4">
                                <img id="previewEditPhoto" class="mx-auto w-full max-w-md h-auto object-cover border rounded-md" alt="Foto Sebelumnya" style="display: none;">
                            </div>

                        </div>
                        @error('photo')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" id="editJudul" value="{{ old('judul') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('judul')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- isi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Isi</label>
                        <textarea name="isi" id="editIsi" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="resetForm(); document.getElementById('modal-edit-forum').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@vite('resources/js/forums.js')
<script>
    function toggleDropdownOption() {
        const menu = document.getElementById('dropdownMenuOption');
        menu.classList.toggle('hidden');
        document.addEventListener('click', function outsideClick(event) {
            if (!event.target.closest('#dropdownToggleOption')) {
                menu.classList.add('hidden');
                document.removeEventListener('click', outsideClick);
            }
        });
    }



        function openEditModal(forum) {
            console.log('User for modal:', forum);

            document.getElementById('modal-edit-forum').classList.remove('hidden');
            document.getElementById('editForumForm').action = `/forums/${forum.id}`;
            document.getElementById('editJudul').value = forum.judul;
            document.getElementById('editIsi').value = forum.isi;
            document.getElementById('editPhotoInput').value = "";
            document.getElementById('previewEditPhoto').src = forum.photo_url ?? '#';
            document.getElementById('previewEditPhoto').style.display = forum.photo_url ? 'block' : 'none';

            const preview = document.getElementById('previewEditPhoto');
            preview.src = forum.photo ? `/storage/${forum.photo}` : '#';
            preview.style.display = forum.photo ? 'block' : 'none';
            if (forum.id_submission) {
                document.querySelector('#editPhotoInput').closest('div').style.display = 'none';
                document.getElementById('label-foto').closest('div').style.display = 'none';
            } else {
                document.getElementById('label-foto').closest('div').style.display = 'block';
                document.querySelector('#editPhotoInput').closest('div').style.display = 'block';
            }
        }

        document.getElementById('editPhotoInput').addEventListener('change', function (event) {
        const input = event.target;
        const preview = document.getElementById('previewEditPhoto');

        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                preview.style.display = 'block';
            }
            reader.readAsDataURL(input.files[0]);
        } else {
            preview.src = '#';
            preview.style.display = 'none';
        }
    });

    function confirmDelete(forumId) {
        Swal.fire({
            title: 'Apakah kamu yakin?',
            text: "Data ini akan dihapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#aaa',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById(`delete-form-${forumId}`).submit();
            }
        });
    }

    document.addEventListener('DOMContentLoaded', function () {
        @if($errors->any())
            document.getElementById('modal-edit-forum').classList.remove('hidden');
        @endif
    });


    function autoResize(textarea) {
        textarea.style.height = 'auto';
        textarea.style.height = (textarea.scrollHeight) + 'px';
    }

    function updateCharCount(textarea) {
        const max = 500;
        const length = textarea.value.length;
        const remaining = max - length;

        const counter = document.getElementById('char-remaining');
        counter.textContent = remaining;

        if (remaining < 0) {
            counter.classList.add('text-red-500');
        } else {
            counter.classList.remove('text-red-500');
        }
    }

    function handleSubmitComment() {
        const textarea = document.getElementById('comment-text');
        const form = textarea.closest('form');
        const max = 500;
        const contentLength = textarea.value.length;

        if (contentLength > max) {
            Swal.fire({
                icon: 'error',
                title: 'Komentar terlalu panjang!',
                text: 'Komentar kamu melebihi batas maksimal (500 karakter).',
                confirmButtonText: 'Back',
                confirmButtonColor: '#000',
            });
        } else {
            form.submit();
        }
    }

    document.getElementById('comment-photo').addEventListener('change', function (e) {
        const file = e.target.files[0];
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function (e) {
                preview.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
            reader.readAsDataURL(file);
        } else {
            removeImage(); // Reset jika bukan gambar
        }
    });

    function openImageModal(src) {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');

        modalImg.src = src;
        modal.classList.remove('hidden');
    }

    function closeImageModal() {
        const modal = document.getElementById('image-modal');
        modal.classList.add('hidden');
        document.getElementById('modal-image').src = '';
    }

    // Close modal saat klik di luar gambar
    document.getElementById('image-modal').addEventListener('click', function (e) {
        if (e.target.id === 'image-modal') {
            closeImageModal();
        }
    });


    function removeImage() {
        const input = document.getElementById('comment-photo');
        const previewContainer = document.getElementById('image-preview-container');
        const preview = document.getElementById('image-preview');

        input.value = ''; // Reset input file
        preview.src = '';
        previewContainer.classList.add('hidden');
    }

    window.addEventListener('DOMContentLoaded', () => {
        const textarea = document.getElementById('comment-text');
        autoResize(textarea);
        updateCharCount(textarea);
    });

    let isZoomed = false;

    function openImageModal(src) {
        const modal = document.getElementById('image-modal');
        const modalImg = document.getElementById('modal-image');

        modalImg.src = src;
        modal.classList.remove('hidden');
        isZoomed = false;
        modalImg.classList.remove('zoomed');
        modalImg.addEventListener('click', function (e) {
            const rect = modalImg.getBoundingClientRect();

            // Posisi klik relatif terhadap gambar
            const offsetX = e.clientX - rect.left;
            const offsetY = e.clientY - rect.top;

            // Hitung persentase posisi klik terhadap dimensi gambar
            const percentX = (offsetX / rect.width) * 100;
            const percentY = (offsetY / rect.height) * 100;

            isZoomed = !isZoomed;

            if (isZoomed) {
                modalImg.classList.add('zoomed');

                // Set titik fokus zoom
                modalImg.style.transformOrigin = `${percentX}% ${percentY}%`;
                modalImg.style.transform = 'scale(2)';
            } else {
                modalImg.classList.remove('zoomed');

                // Reset
                modalImg.style.transformOrigin = 'center center';
                modalImg.style.transform = 'scale(1)';
            }
        });
    }


</script>
@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif
@endsection
