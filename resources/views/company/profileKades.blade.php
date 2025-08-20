@extends('layouts.appProfile')

@section('content')
<div class="flex">
    <!-- Sidebar -->
    <div class="w-64 border-r border-purple-600 p-4 flex-shrink-0">
        <ul class="space-y-4">
            <li><a href="{{ route('profileDesa') }}" class="font-bold text-purple-600">Profile Desa Sukanagara</a></li>
            <li><a href="{{ route('sejarah') }}" class="font-bold text-purple-600">Sejarah Desa Sukanagara</a></li>
            <li><a href="{{ route('visi') }}" class="font-bold text-purple-600">Visi Misi</a></li>
            <li><a href="{{ route('profileKades') }}" class="font-bold text-purple-600">Profile Kades</a></li>
            <li><a href="{{ route('struktur') }}" class="font-bold text-purple-600">Struktur Organisasi</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="flex-1">
        <div class="mt-10">
            <div class="ml-10">
                <!-- Judul -->
                <h1 class="text-xl font-bold border border-purple-600 text-purple-600 inline-block px-4 py-1 rounded-full mb-6">
                    Profile Kepala Desa Suka Nagara
                </h1>
            </div>

            <!-- Gambar dan Teks -->
            <div class="flex flex-col items-center">
                <div class="flex justify-center mb-4">
                    <img src="{{ asset('images/kades-sukanagara.jpg') }}"
                        alt="Foto Kades"
                        class="w-60 h-56 object-cover rounded-lg border border-gray-300 shadow-md">
                </div>

                <!-- Nama & Biografi -->
                <div class="text-center">
                    <h3 class="text-xl font-bold">Kepala Desa Sukanagara</h3>
                    <p class="text-gray-600 italic">Biografi</p>
                </div>

                <!-- Detail Info -->
                <div class="text-sm text-gray-800 space-y-2">
                    <hr class="border-2 border-black my-3 mx-auto">
                    <p><span class="font-semibold">Nama Lengkap:</span> Wawan Ridwansyah</p>
                    <p><span class="font-semibold">Tanggal Lahir:</span> 15 Desember 1959</p>
                    <p><span class="font-semibold">Tempat Lahir:</span> Cianjur</p>
                    <p><span class="font-semibold">Pendidikan:</span> S1</p>
                    <p><span class="font-semibold">Masa Jabatan:</span> 2024 - Sekarang</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
