@extends('layouts.appProfile')

@section('content')
    <div class="mt-10">
        <!-- Gambar dan Teks -->
        <div class="flex flex-col">
            <div class="px-4 md:px-12 lg:px-32">
                <a href="{{ url()->previous() }}"><i class="fa-solid fa-arrow-left"></i> kembali</a>
                <h3 class="font-semibold text-base my-2">{{ $informasi->judul }}</h3>
                <p class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($informasi->created_at)->translatedFormat('l, d F Y') }}</p>
                <!-- Gambar -->
                <div class="mb-6">
                    <img src="{{ asset($informasi->photo_url ?? 'images/default-image-square.png') }}"
                    alt="gambar"
                    class="w-full max-w-3xl max-h-[300px] object-cover mx-auto rounded">
                </div>
            </div>
            <!-- Text content -->
            <div class="text-justify text-gray-800 px-6 md:px-20 lg:px-32">
                <p>
                    {!! nl2br(e($informasi->isi)) !!}
                </p>
            </div>
        </div>
    </div>
@endsection

