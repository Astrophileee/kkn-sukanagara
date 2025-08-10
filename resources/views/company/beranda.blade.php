@extends('layouts.appProfile')

@section('content')

<div class="relative w-full h-[711px]">
    <!-- Gambar -->
    <img src="{{ asset('images/test.jpg') }}" alt="Pemandangan Desa" class="w-full h-full object-cover">

    <!-- Teks di atas gambar -->
    <div class="absolute bottom-12 left-12">
        <p class="text-xl font-medium" style="color: #FFEAEA;">Website</p>
        <h1 class="text-7xl font-extrabold leading-tight text-white"
            style="-webkit-text-stroke: 3px #88129F;">
            DESA<br>SUKANAGARA
        </h1>
    </div>
</div>




<div data-aos="zoom-in-up" class="w-full flex justify-center mt-8">
    <div class="flex justify-between items-center border-2 bg-purple-300 rounded-full px-6 py-3 w-full max-w-6xl">
        <p class="text-sm sm:text-base font-medium text-center sm:text-left text-black">
            <b>
                Silahkan ajukan pengaduan, keluhan, aspirasi, atau masukan anda yang membangun bagi DESA SUKANAGARA
            </b>
        </p>
        <a href="{{ route('anggota') }}" class="border-2 border-black bg-white rounded-full px-4 py-1 text-sm sm:text-base
                            hover:bg-purple-300">
            <b>
                Hubungi Kami
            </b>
        </a>
    </div>
</div>

<div class="py-10">
    <h2 class="text-center text-xl font-bold mb-8">DATA PENDUDUK</h2>
    <div class="flex justify-center gap-6">

        <!-- Card 1 -->
        <div data-aos="fade-right" class="bg-purple-300 w-40 h-40 rounded-2xl flex flex-col justify-center items-center border border-black shadow-xl">
            <i class="fa-solid fa-person text-black text-3xl mb-2"></i>
            <p class="text-black text-xl font-bold">
                {{ number_format($penduduks['Penduduk']->total ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-black text-sm">Penduduk</p>
        </div>

        <!-- Card 2 -->
        <div data-aos="fade-up" class="bg-purple-300 w-40 h-40 rounded-2xl flex flex-col justify-center items-center border border-black shadow-xl">
            <i class="fa-solid fa-person text-black text-3xl mb-2"></i>
            <p class="text-black text-xl font-bold">
                {{ number_format($penduduks['Kartu Keluarga']->total ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-black text-sm">Kartu Keluarga</p>
        </div>

        <!-- Card 3 -->
        <div data-aos="fade-left" class="bg-purple-300 w-40 h-40 rounded-2xl flex flex-col justify-center items-center border border-black shadow-xl">
            <i class="fa-solid fa-person text-black text-3xl mb-2"></i>
            <p class="text-black text-xl font-bold">
                {{ number_format($penduduks['RT/RW']->total ?? 0, 0, ',', '.') }}
            </p>
            <p class="text-black text-sm">RT/RW</p>
        </div>

    </div>
</div>


<div class="py-10">
    <h2 class="text-center text-xl font-bold mb-8">REALISASI DANA</h2>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 max-w-4xl mx-auto">

        <!-- Card 1 -->
        <div data-aos="flip-left" class="bg-green-300 rounded-xl p-5 flex justify-between items-center border border-black shadow-xl">
            <div>
                <p class="text-black font-medium">Dana Desa</p>
                <p class="text-black text-lg font-bold">{{ number_format($apbns['Dana Desa']->total ?? 0, 0, ',', '.') }}</p>
            </div>
            <i class="fa-solid fa-cart-shopping text-black text-3xl"></i>
        </div>

        <!-- Card 2 -->
        <div data-aos="flip-right" class="bg-purple-300 rounded-xl p-5 flex justify-between items-center border border-black shadow-xl">
            <div>
                <p class="text-black font-medium">Hasil Bumdes</p>
                <p class="text-black text-lg font-bold">{{ number_format($apbns['Hasil Bumdes']->total ?? 0, 0, ',', '.') }}</p>
            </div>
            <i class="fa-solid fa-truck text-black text-3xl"></i>
        </div>

        <!-- Card 3 -->
        <div data-aos="flip-left" class="bg-purple-300 rounded-xl p-5 flex justify-between items-center border border-black shadow-xl">
            <div>
                <p class="text-black font-medium">Pengelolaan Kas Desa</p>
                <p class="text-black text-lg font-bold">{{ number_format($apbns['Kas Desa']->total ?? 0, 0, ',', '.') }}</p>
            </div>
            <i class="fa-solid fa-wrench text-black text-3xl"></i>
        </div>

        <!-- Card 4 -->
        <div data-aos="flip-right" class="bg-green-300 rounded-xl p-5 flex justify-between items-center border border-black shadow-xl">
            <div>
                <p class="text-black font-medium">Pendapatan</p>
                <p class="text-black text-lg font-bold">{{ number_format($apbns['Pendapatan']->total ?? 0, 0, ',', '.') }}</p>
            </div>
            <i class="fa-solid fa-thumbs-up text-black text-3xl"></i>
        </div>

    </div>
</div>

<div class="py-10">
    <h2 class="text-center text-xl font-bold mb-8">LETAK GEOGRAFIS</h2>
    <div class="flex justify-center">
        <div class="block max-w-[800px] max-h-[400px] w-full">
            <iframe
                src="https://www.google.com/maps?q=Sukanagara%2C%20Cianjur&output=embed"
                width="100%"
                height="400"
                style="border:0; border-radius: 10px;"
                allowfullscreen=""
                loading="lazy">
            </iframe>
        </div>
    </div>
</div>



<div class="py-10">
    <h2 class="text-center text-2xl font-bold mb-8">INFORMASI TERKINI</h2>

    <!-- Grid Card -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 max-w-6xl mx-auto">
        @foreach($informations as $info)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm hover:shadow-lg transition p-4 flex flex-col">
                @if($info->photo)
                    <div class="h-40 overflow-hidden rounded">
                        <img src="{{ asset('storage/' . $info->photo) }}"
                            alt="{{ $info->judul }}"
                            class="w-full h-full object-cover">
                    </div>
                @else
                    <div class="bg-gray-200 h-40 flex items-center justify-center rounded">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4-4-4-4m0 0l8 8 8-8M4 16V4a2 2 0 012-2h12a2 2 0 012 2v12"/>
                        </svg>
                    </div>
                @endif

                <h3 class="mt-4 font-semibold text-gray-800">{{ $info->judul }}</h3>
                <p class="text-gray-600 text-sm mt-2 flex-grow">
                    {{ Str::limit($info->isi, 100) }}
                </p>
                <a href="{{ route('informasi.show', $info->id) }}" class="mt-auto text-sm text-purple-600 font-semibold hover:underline flex items-center gap-1">
                        Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                <p class="text-sm text-gray-500 mt-2">{{ $info->created_at->translatedFormat('F d Y') }}</p>
            </div>
        @endforeach
    </div>

    <!-- Tombol Lainnya -->
    <div class="text-center mt-8">
        <a href="{{ route('informasi') }}"
            class="bg-purple-600 text-black px-8 py-3 rounded-full font-semibold hover:bg-purple-700 transition">
            Lainnya
        </a>
    </div>
</div>










@endsection
