@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Forum Diskusi</h1>
        <button onclick="document.getElementById('modal-tambah-forum').classList.remove('hidden')" class="bg-black text-white px-4 py-2 rounded-md shadow hover:bg-gray-800">
            Tambah
        </button>
    </div>
    <div class="bg-white min-h-[500px] shadow-md rounded-lg overflow-x-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 m-5">
            @foreach ($forums as $forum)
                <a href="{{ route('forums.show', $forum) }}" class="block bg-white border border-gray-200 rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow duration-300">

                    <div class="p-4">
                        <div class="text-sm text-gray-500 mb-1">
                            <span class="font-semibold text-gray-800">{{ $forum->user->name ?? 'Akun telah dihapus' }}</span> •
                            <span>dibuat {{ $forum->created_at->diffForHumans() }}</span>
                        </div>
                        <h2 class="text-lg font-bold text-gray-900 mb-2">
                            {{ Str::limit(strip_tags($forum->judul), 100) }}
                        </h2>
                        @if ($forum->photo)
                            <img class="w-full max-h-48 object-cover" src="{{ asset('storage/' . $forum->photo) }}" alt="Forum Image">
                        @else
                            <div class="w-full h-48 text-sm text-gray-600 overflow-hidden">
                                {{ Str::limit(strip_tags($forum->isi), 200) }}
                            </div>
                        @endif
                    </div>
                </a>
            @endforeach
        </div>
    </div>

    <!-- Modal Tambah -->
<div id="modal-tambah-forum" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <!-- Close button -->
            <button onclick="document.getElementById('modal-tambah-forum').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>

            <h2 class="text-lg font-semibold mb-4">Tambah Diskusi</h2>

                <form action="{{ route('forums.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto (optional)</label>
                        <div class="border-2 border-dashed rounded-lg p-4 text-center">
                            <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="hidden" id="photoInput" onchange="previewPhoto(event)">
                            <label for="photoInput" class="cursor-pointer inline-block px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700">
                                Upload file
                            </label>
                            <p class="text-xs text-gray-500 mt-2">Hanya mendukung format file: .jpg, .jpeg, .png</p>
                            <div id="photoPreviewContainer" class="mt-4 hidden">
                                <img id="photoPreview" class="mx-auto w-full max-w-md h-auto object-cover border rounded-md" alt="Preview Foto">
                            </div>
                        </div>
                        @error('photo')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Judul</label>
                        <input type="text" name="judul" value="{{ old('judul') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('judul')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- isi -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Isi</label>
                        <textarea name="isi" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">{{ old('isi') }}</textarea>
                        @error('isi')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action -->
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="resetForm(); document.getElementById('modal-tambah-forum').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                    </div>
                </form>

        </div>
    </div>
</div>

<script>
    function previewPhoto(event) {
        const input = event.target;
        const preview = document.getElementById('photoPreview');
        const container = document.getElementById('photoPreviewContainer');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            container.classList.add('hidden');
            preview.src = '';
        }
    }

document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
        document.getElementById('modal-tambah-forum').classList.remove('hidden');
    @endif
});

// Fungsi untuk mereset form
function resetForm() {
    // Reset semua input dalam form modal
    const form = document.querySelector('#modal-tambah-forum form');
    form.reset(); // Reset form (input, textarea, select)

    // Reset preview foto
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewContainer = document.getElementById('photoPreviewContainer');
    photoPreviewContainer.classList.add('hidden');
    photoPreview.src = ''; // Set preview ke default kosong

    // Reset file input
    const photoInput = document.getElementById('photoInput');
    photoInput.value = '';
}

// Menambahkan reset form ketika modal ditutup melalui tombol close (X)
document.querySelector('#modal-tambah-forum .absolute').addEventListener('click', function() {
    resetForm();
    document.getElementById('modal-tambah-forum').classList.add('hidden');
});


</script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif




@endsection
