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
                    Sejarah Desa Sukanagara
                </h1>
            </div>

            <!-- Gambar dan Teks -->
            <div class="flex flex-col items-center">
                <!-- Gambar -->
                <div class="border border-black mb-6">
                    <img src="{{ asset('images/test.jpg') }}" alt="gambar" class="max-w-[500px] max-h-[300px] object-cover">
                </div>

                <!-- Text content -->
                <div class="space-y-4 text-justify text-gray-800 px-6 md:px-20 lg:px-32">
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor.
                        Pulvinar vivamus fringilla lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.
                    </p>
                    <p>
                        Lorem ipsum dolor sit amet consectetur adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi pretium tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla
                        lacus nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut hendrerit semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos himenaeos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
