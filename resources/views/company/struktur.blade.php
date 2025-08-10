@extends('layouts.appProfile')

@section('content')
<div class="flex mb-10">
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
        <div class="mt-10 ml-10">
            <!-- Judul -->
            <h1 class="text-xl font-bold border border-purple-600 text-purple-600 inline-block px-4 py-1 rounded-full mb-10">
                Struktur Organisasi
            </h1>

            <!-- Struktur Organisasi -->
            <div class="flex flex-col items-center space-y-10">
                <!-- Pimpinan Utama -->
                <div class="text-center">
                    <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[160px] max-h-[160px] object-cover border border-black mb-2">
                    <div class="font-semibold">Nama</div>
                    <div class="text-sm text-gray-600">Jabatan</div>
                </div>

                <!-- Dua Bawahnya -->
                <div class="flex flex-wrap justify-center gap-16">
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[160px] max-h-[160px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[160px] max-h-[160px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                </div>

                <!-- Empat Bawahnya -->
                <div class="flex flex-wrap justify-center gap-12">
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                </div>
                <!-- Empat Bawahnya -->
                <div class="flex flex-wrap justify-center gap-12">
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                    <div class="text-center">
                        <img src="{{ asset('images/default-image-square.png') }}" alt="gambar" class="max-w-[144px] max-h-[144px] object-cover border border-black mb-2">
                        <div class="font-semibold">Nama</div>
                        <div class="text-sm text-gray-600">Jabatan</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
