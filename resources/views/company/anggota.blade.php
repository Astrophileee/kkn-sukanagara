@extends('layouts.appProfile')

@section('content')




<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-8 border-l-4 border-black pl-4">Anggota PWI Cianjur</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($users as $user)
                <div class="flex flex-col h-full rounded-lg shadow-sm border hover:shadow-md transition p-4">
                    <img src="{{ asset($user->photo_url ?? 'images/default-image-square.png') }}" alt="Anggota Image"
                        class="rounded-lg w-full h-40 object-cover mb-3">

                    <div class="flex-grow space-y-2 text-sm">
                        <div class="flex">
                            <span class="w-24 font-semibold">Nama</span>
                            <span class="mr-1">:</span>
                            <span class="flex-1 capitalize">{{ $user->name }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold">Jabatan</span>
                            <span class="mr-1">:</span>
                            <span class="flex-1 capitalize">{{ $user->jabatan }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold">Status</span>
                            <span class="mr-1">:</span>
                            <span class="flex-1 capitalize">{{ $user->status }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold">Media</span>
                            <span class="mr-1">:</span>
                            <span class="flex-1 uppercase">{{ $user->media }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold">Riwayat</span>
                            <span class="mr-1">:</span>
                            <span class="flex-1">{{ $user->riwayat_berita }}</span>
                        </div>
                    </div>
                    <div class="mt-4 text-right">
                        <button
                            type="button"
                            onclick="openModal({{ $user->id }}, '{{ addslashes($user->name) }}')"
                            class= "border border-black text-black text-sm px-4 py-2 rounded-xl hover:bg-black hover:text-white"
                        >
                            Ingin Mengajukan Berita?
                        </button>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>


<div id="modal-tambah-submission" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <!-- Close button -->
            <button onclick="document.getElementById('modal-tambah-submission').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>

            <h2 class="text-lg font-semibold mb-4">Tambah Pengajuan</h2>
            <h1 class="text-lg font-semibold mb-4">Kepada: <span id="selected-user-name" class="font-normal"></span></h1>
                <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <input type="hidden" name="user_id" id="user_id">

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('name')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- NO HP -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nomor HP</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('no_hp')
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
                    <div class="g-recaptcha" data-sitekey="6Lce1ZIrAAAAAAlTw_kD1-ymobGSmK7fIot8HMU5"></div>
                    @error('g-recaptcha-response')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="resetForm(); document.getElementById('modal-tambah-submission').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                    </div>
                </form>

        </div>
    </div>
</div>

<script>
    function openModal(userId, userName) {
        document.getElementById('modal-tambah-submission').classList.remove('hidden');
        const userInput = document.querySelector('input[name="user_id"]');
        if (userInput) userInput.value = userId;
        const nameDisplay = document.getElementById('selected-user-name');
        if (nameDisplay) nameDisplay.textContent = userName;
    }

    function resetForm() {
        const form = document.querySelector('#modal-tambah-submission form');
        if (form) form.reset();
        const nameDisplay = document.getElementById('selected-user-name');
        if (nameDisplay) nameDisplay.textContent = '';
    }
</script>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif



@endsection
