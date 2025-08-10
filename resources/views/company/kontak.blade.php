    @extends('layouts.appProfile')

    @section('content')

        <div class="max-w-4xl mx-auto p-6">
            <h1 class="text-2xl font-bold text-center mb-6">Form Pengaduan</h1>
            <form action="{{ route('submissions.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <!-- Identitas Pelapor -->
                <h2 class="font-semibold">Identitas Pelapor</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <input type="text" name="nama" placeholder="Nama Lengkap" class="border p-2 rounded w-full" required>
                    <input type="text" name="nik" placeholder="NIK" class="border p-2 rounded w-full" required>
                    <input type="text" name="alamat" placeholder="Alamat" class="border p-2 rounded w-full" required>
                    <input type="text" name="rt_rw" placeholder="RT / RW" class="border p-2 rounded w-full" required>
                    <input type="text" name="pekerjaan" placeholder="Pekerjaan" class="border p-2 rounded w-full" required>
                    <input type="text" name="status_desa" placeholder="Status di Desa" class="border p-2 rounded w-full" required>
                </div>

                <!-- Jenis Pengaduan -->
                <select name="jenis_pengaduan" class="border p-2 rounded w-full" required>
                    <option value="">Pilih Jenis Pengaduan</option>
                    <option value="infrastruktur">Infrastruktur</option>
                    <option value="pelayanan">Pelayanan Publik</option>
                    <option value="keamanan">Keamanan</option>
                    <option value="lainnya">Lainnya</option>
                </select>

                <!-- Uraian Masalah -->
                <h2 class="font-semibold">Uraian Masalah</h2>
                <input type="text" name="lokasi" placeholder="Lokasi Kejadian" class="border p-2 rounded w-full" required>
                <input type="text" name="waktu" placeholder="Waktu Kejadian" class="border p-2 rounded w-full" required>
                <textarea name="kronologi" placeholder="Kronologi Kejadian" rows="3" class="border p-2 rounded w-full" required></textarea>

                <input type="text" name="pihak_terlibat" placeholder="Pihak yang terlibat" class="border p-2 rounded w-full" required>
                <input type="text" name="dampak" placeholder="Dampak yang dirasakan warga" class="border p-2 rounded w-full" required>
                <input type="text" name="harapan" placeholder="Harapan / Usulan dari pelapor" class="border p-2 rounded w-full" required>

                <!-- Bukti Pendukung -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bukti Pendukung (optional)</label>
                    <div class="border-2 border-dashed rounded-lg p-4 text-center">
                        <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="hidden" id="photoInput" onchange="previewPhoto(event)">
                        <label for="photoInput" class="cursor-pointer inline-block px-4 py-2 bg-gray-100 rounded-md text-sm font-medium text-gray-700">
                            Upload file
                        </label>
                        <p class="text-xs text-gray-500 mt-2">Hanya mendukung format file: .jpg, .jpeg, .png</p>
                        <div id="photoPreviewContainer" class="mt-4 hidden">
                            <img id="photoPreview" class="mx-auto w-40 h-40 rounded-md object-cover border" alt="Preview Foto">
                        </div>
                    </div>
                    @error('photo')
                        <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Tombol Submit -->
                <div class="text-center">
                    <button type="submit" class="bg-purple-600 text-white px-6 py-2 rounded">SUBMIT</button>
                </div>
            </form>
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
    </script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif


    @endsection
