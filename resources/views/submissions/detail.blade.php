@extends('layouts.app')

@section('content')
    <div class="max-w bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> back</a>

            @if (Auth::id() === $submission->id_user)
                <div>
                    <button onclick="document.getElementById('modal-tambah-forum').classList.remove('hidden')"
                        class="bg-black text-white px-4 py-2 rounded-md shadow hover:bg-gray-800">
                        <i class="fa-solid fa-share-from-square"></i>
                    </button>

                    <select name="status" id="status-dropdown" data-id="{{ $submission->id }}" onchange="updateStatus(this)"
                        class="border border-gray-300 rounded py-1 text-sm">
                        <option value="pending" {{ $submission->status === 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="reject" {{ $submission->status === 'reject' ? 'selected' : '' }}>Reject</option>
                        <option value="accept" {{ $submission->status === 'accept' ? 'selected' : '' }}>Accept</option>
                    </select>
                </div>
            @endif
        </div>
        {{-- Header: Judul --}}
        <div class="font-semibold">
            {{ $submission->nama_pengaju }} - {{ $submission->nomor_hp_pengaju }}
            @if($submission->created_at->diffInDays(now()) >= 1)
                {{ $submission->created_at->format('d/m/y H:i') }}
            @else
                {{ $submission->created_at->diffForHumans() }}
            @endif
        </div>
        <h1 class="text-3xl font-bold mb-4 text-gray-900">{{ $submission->judul }}</h1>

        {{-- Info User + Waktu --}}
        <div class="flex mb-4">
            <div class="text-xl text-gray-700 ">
                    {!! nl2br(e($submission->isi)) !!}
            </div>
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
                    <input type="hidden" name="id_submission" id="id_submission" value="{{ $submission->id }}">
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

@vite('resources/js/submissions.js')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        @if($errors->any())
            document.getElementById('modal-tambah-forum').classList.remove('hidden');
        @endif
    });
</script>
@endsection
