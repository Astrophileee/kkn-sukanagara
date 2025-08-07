@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Pengguna</h1>
        <button onclick="document.getElementById('modal-tambah-user').classList.remove('hidden')" class="bg-black text-white px-4 py-2 rounded-md shadow hover:bg-gray-800">
            Tambah
        </button>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table id="usersTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nama</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Jabatan</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Media</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Riwayat</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Role</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($users as $user)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 flex items-center space-x-3">
                            <img class="w-10 h-10 rounded-full object-cover" src="{{ $user->photo_url }}" alt="Avatar">
                            <div class="font-medium text-gray-900">{{ $user->name }}</div>
                        </td>
                        <td class="px-6 py-4 text-gray-700">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->jabatan }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->status }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->media ?? 'Tidak Ada Media' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-gray-700">{{ $user->riwayat_berita ?? 'Tidak Ada Riwayat' }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @foreach ($user->roles as $role)
                                <span class="text-xs bg-gray-200 text-gray-800 py-1 px-3 rounded-full">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                            <!-- Tombol Edit -->
                            <button type="button" class="inline-flex items-center px-4 py-2.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600"
                            onclick='openEditModal(@json($user))'>
                            Edit
                        </button>

                            <!-- Tombol Hapus -->
                            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" class="hidden">
                                @csrf
                                @method('DELETE')
                            </form>
                            <button type="button" class="inline-flex items-center px-4 py-2.5 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600"
                            onclick="confirmDelete({{ $user->id }})">Hapus</button>
                        </td>

                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>

    <!-- Modal Tambah -->
<div id="modal-tambah-user" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <!-- Close button -->
            <button onclick="document.getElementById('modal-tambah-user').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>

            <h2 class="text-lg font-semibold mb-4">Tambah Pengguna</h2>

                <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
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
                                <img id="photoPreview" class="mx-auto w-24 h-24 rounded-full object-cover border" alt="Preview Foto">
                            </div>
                        </div>
                        @error('photo')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                            <option value="" disabled selected>Pilih Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('name')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('email')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="OKK">OKK</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!-- Jabatan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" value="{{ old('jabatan') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('jabatan')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Media -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Media(optional)</label>
                        <input type="text" name="media" value="{{ old('media') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('media')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Riwayat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Riwayat (optional)</label>
                        <input type="number" name="riwayat" value="{{ old('riwayat') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('riwayat')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Action -->
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" onclick="resetForm(); document.getElementById('modal-tambah-user').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                        <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                    </div>
                </form>

        </div>
    </div>
</div>


<!-- Modal Edit -->
<div id="modal-edit-user" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <button onclick="document.getElementById('modal-edit-user').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit Pengguna</h2>

            <form id="editUserForm" method="POST" enctype="multipart/form-data">
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
                                <img id="photoPreview" class="mx-auto w-24 h-24 rounded-full object-cover border" alt="Preview Foto">
                            </div>
                            <div id="previewEditPhotoContainer" class="mt-4">
                                <img id="previewEditPhoto" class="mx-auto w-24 h-24 rounded-full object-cover border" alt="Foto Sebelumnya" style="display: none;">
                            </div>
                        </div>
                        @error('photo')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Role</label>
                        <select name="role" id="editRole" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $user->roles[0]->name ?? '') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Nama -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nama</label>
                        <input type="text" name="name" id="editName" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('name')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <input type="email" name="email" id="editEmail" value="{{ old('email') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('email')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Status</label>
                        <select name="status" id="editStatus" class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                            <option value="" disabled selected>Pilih Status</option>
                            <option value="Aktif">Aktif</option>
                            <option value="OKK">OKK</option>
                            <option value="Tidak Aktif">Tidak Aktif</option>
                        </select>
                    </div>
                    <!-- Jabatan -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Jabatan</label>
                        <input type="text" name="jabatan" id="editJabatan" value="{{ old('jabatan') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('jabatan')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Media -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Media(optional)</label>
                        <input type="text" name="media" id="editMedia" value="{{ old('media') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('media')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                    <!-- Riwayat -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Riwayat (optional)</label>
                        <input type="number" name="riwayat" id="editRiwayat" value="{{ old('riwayat') }}" required class="w-full border border-gray-300 rounded-md px-3 py-2 mt-1 text-sm">
                        @error('riwayat')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="resetForm(); document.getElementById('modal-edit-user').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
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

    function openEditModal(user) {
        console.log('User for modal:', user);

    document.getElementById('modal-edit-user').classList.remove('hidden');
    document.getElementById('editUserForm').action = `/users/${user.id}`;
    document.getElementById('editName').value = user.name;
    document.getElementById('editEmail').value = user.email;
    document.getElementById('editJabatan').value = user.jabatan;
    document.getElementById('editMedia').value = user.media;
    document.getElementById('editRiwayat').value = user.riwayat_berita;
    document.getElementById('editRole').value = user.roles[0]?.name ?? '';
    document.getElementById('editStatus').value = user.status ?? '';
    document.getElementById('editPhotoInput').value = "";
    document.getElementById('previewEditPhoto').src = user.photo_url ?? '#';
    document.getElementById('previewEditPhoto').style.display = user.photo_url ? 'block' : 'none';

    const preview = document.getElementById('previewEditPhoto');
    preview.src = user.photo ? `/storage/${user.photo}` : '#';
    preview.style.display = user.photo ? 'block' : 'none';
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

function confirmDelete(userId) {
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
            document.getElementById(`delete-form-${userId}`).submit();
        }
    });
}

document.addEventListener('DOMContentLoaded', function () {
    @if($errors->any())
        document.getElementById('modal-tambah-user').classList.remove('hidden');
    @endif
});

// Fungsi untuk mereset form
function resetForm() {
    // Reset semua input dalam form modal
    const form = document.querySelector('#modal-tambah-user form');
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
document.querySelector('#modal-tambah-user .absolute').addEventListener('click', function() {
    resetForm();
    document.getElementById('modal-tambah-user').classList.add('hidden');
});


</script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif

@if(session('editUser'))
    <script>
        window.onload = function() {
            openEditModal(@json(session('editUser')));
        }
    </script>
@endif



@endsection
