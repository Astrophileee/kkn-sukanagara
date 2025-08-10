@extends('layouts.appProfile')

@section('content')


<div class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-8 border-l-4 border-purple-600 text-purple-600 pl-4">Informasi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($informations as $information)
                <div class="rounded-lg shadow-sm border hover:shadow-md transition p-4 flex flex-col">
                    <img src="{{ asset($information->photo_url ?? 'images/default-image-square.png') }}" alt="Information Image"
                        class="rounded-lg w-full h-40 object-cover mb-3">
                    <p class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($information->created_at)->translatedFormat('l, d F Y') }}</p>
                    <h3 class="font-semibold text-base mb-2 line-clamp-2">{{ $information->judul }}</h3>
                    <a href="{{ route('informasi.show', $information) }}" class="mt-auto text-sm text-purple-600 font-semibold hover:underline flex items-center gap-1">
                        Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</div>


@endsection
