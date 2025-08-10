@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Informasi</h1>
        <button onclick="document.getElementById('modal-tambah-information').classList.remove('hidden')" class="bg-black text-white px-4 py-2 rounded-md shadow hover:bg-gray-800">
            Tambah
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table id="informationsTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Judul</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Isi</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Photo</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            @php use Illuminate\Support\Str; @endphp
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($informations as $information)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $information->judul }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ Str::limit($information->isi, 500) }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700"><img class=" object-cover max-h-[250px]" src="{{ $information->photo_url }}" alt="Avatar"></td>
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                            <!-- Tombol Edit -->
                            <button type="button" class="inline-flex items-center px-4 py-2.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600"
                            onclick='openEditModal(@json($information))'>
                            Edit
                        </button>
                            <!-- Tombol Hapus -->
                            <form id="delete-form-{{ $information->id }}" action="{{ route('informations.destroy', $information->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="inline-flex items-center px-4 py-2.5 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600"
                            onclick="confirmDelete({{ $information->id }})">Hapus</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- Modal Tambah -->
<div id="modal-tambah-information" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <!-- Close button -->
            <button onclick="document.getElementById('modal-tambah-information').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>

            <h2 class="text-lg font-semibold mb-4">Tambah Informasi</h2>

                <form action="{{ route('informations.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                        <button type="button" onclick="resetForm(); document.getElementById('modal-tambah-information').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                    </div>
                </form>

        </div>
    </div>
</div>


<!-- Modal Edit -->
<div id="modal-edit-information" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <button onclick="document.getElementById('modal-edit-information').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit Information</h2>

            <form id="editInformationForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <!-- Foto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Foto (optional)</label>
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
                    <button type="button" onclick="resetForm(); document.getElementById('modal-edit-information').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
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

    function openEditModal(information) {
        console.log('User for modal:', information);

    document.getElementById('modal-edit-information').classList.remove('hidden');
    document.getElementById('editInformationForm').action = `/informations/${information.id}`;
    document.getElementById('editJudul').value = information.judul;
    document.getElementById('editIsi').value = information.isi;
    document.getElementById('editPhotoInput').value = "";
    document.getElementById('previewEditPhoto').src = information.photo_url ?? '#';
    document.getElementById('previewEditPhoto').style.display = information.photo_url ? 'block' : 'none';

    const preview = document.getElementById('previewEditPhoto');
    preview.src = information.photo ? `/storage/${information.photo}` : '#';
    preview.style.display = information.photo ? 'block' : 'none';
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

function confirmDelete(informationId) {
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
            document.getElementById(`delete-form-${informationId}`).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
        document.getElementById('modal-tambah-information').classList.remove('hidden');
    @endif
});

function resetForm() {
    const form = document.querySelector('#modal-tambah-information form');
    form.reset();
    const photoPreview = document.getElementById('photoPreview');
    const photoPreviewContainer = document.getElementById('photoPreviewContainer');
    photoPreviewContainer.classList.add('hidden');
    photoPreview.src = '';
    const photoInput = document.getElementById('photoInput');
    photoInput.value = '';
}

document.querySelector('#modal-tambah-information .absolute').addEventListener('click', function() {
    resetForm();
    document.getElementById('modal-tambah-information').classList.add('hidden');
});


</script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif

@if(session('editInformation'))
    <script>
        window.onload = function() {
            openEditModal(@json(session('editInformation')));
        }
    </script>
@endif



@endsection
