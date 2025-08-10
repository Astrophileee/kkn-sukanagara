@extends('layouts.app')

@section('content')
    <div class="flex justify-between items-center mb-4">
        <h1 class="text-xl font-bold">Penduduk</h1>
    </div>

    <div class="bg-white shadow-md rounded-lg overflow-x-auto">
        <table id="penduduksTable" class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">No</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">label</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total</th>
                    <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Aksi</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach ($penduduks as $penduduk)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td class="px-6 py-4 text-gray-700">{{ $penduduk->label }}</td>
                        <td class="px-6 py-4 text-gray-700"> {{ $penduduk->total }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-right space-x-2">
                            <button type="button" class="inline-flex items-center px-4 py-2.5 bg-blue-500 text-white text-sm rounded-lg hover:bg-blue-600"
                            onclick='openEditModal(@json($penduduk))'>
                            Edit
                        </button>
                        </td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    </div>


<!-- Modal Edit -->
<div id="modal-edit-penduduk" class="fixed inset-0 z-50 overflow-y-auto bg-black bg-opacity-50 hidden">
    <div class="min-h-screen flex items-center justify-center py-6 px-4">
        <div class="bg-white w-full max-w-md mx-auto rounded-lg shadow-lg p-6 relative">
            <button onclick="document.getElementById('modal-edit-penduduk').classList.add('hidden')" class="absolute top-4 right-4 text-xl font-bold text-gray-600 hover:text-gray-800">&times;</button>
            <h2 class="text-lg font-semibold mb-4">Edit Penduduk</h2>
            <form id="editPendudukForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                    <!-- Judul -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Total</label>
                        <input type="text" name="total" id="editTotal"
                            class="form-input w-full border border-gray-300 rounded p-2" value="{{ old('total') }}">
                        @error('total')
                            <div class="text-red-500 text-xs mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="document.getElementById('modal-edit-penduduk').classList.add('hidden')" class="px-4 py-2 rounded-md border text-sm">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-black text-white rounded-md text-sm hover:bg-gray-800">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>

    function openEditModal(penduduk) {

    document.getElementById('modal-edit-penduduk').classList.remove('hidden');
    document.getElementById('editPendudukForm').action = `/penduduks/${penduduk.id}`;
    document.getElementById('editTotal').value = penduduk.total ?? '';
    }


</script>

@if (session('success') || session('error'))
    <div id="flash-message"
         data-type="{{ session('success') ? 'success' : 'error' }}"
         data-message="{{ session('success') ?? session('error') }}">
    </div>
@endif

@if(session('editPenduduk'))
    <script>
        window.onload = function() {
            openEditModal(@json(session('editPenduduk')));
        }
    </script>
@endif



@endsection
