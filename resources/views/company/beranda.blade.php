@extends('layouts.appProfile')

@section('content')
<!-- Slider main container -->
<div class="w-full h-[400px] overflow-hidden">
    <div class="swiper mySwiper w-full h-full relative">
        <div class="swiper-wrapper">
            <div class="swiper-slide relative w-full h-full flex justify-center items-center">
                <img src="{{ asset('images/test.jpg') }}" class="w-full h-full object-cover" alt="...">
            </div>
            <div class="swiper-slide relative w-full h-full flex justify-center items-center">
                <img src="{{ asset('images/default-image-square.png') }}" class="w-full h-full object-cover" alt="...">
            </div>
        </div>
        <div class="swiper-button-next !text-black"></div>
        <div class="swiper-button-prev !text-black"></div>
    </div>
</div>

<div class="w-full flex justify-center mt-8">
    <div class="flex justify-between items-center border-2 bg-black border-black rounded-full px-6 py-3 w-full max-w-6xl">
        <p class="text-sm sm:text-base font-medium text-center sm:text-left text-white">
            <b>
                Silahkan ajukan pengajuan berita, pengaduan, keluhan, aspirasi, atau masukan anda yang membangun bagi PWI CIANJUR
            </b>
        </p>
        <a href="{{ route('anggota') }}" class="border-2 border-black bg-white rounded-full px-4 py-1 text-sm sm:text-base
                            hover:bg-black hover:border-white hover:text-white">
            <b>
                Hubungi Kami
            </b>
        </a>
    </div>
</div>

<div class="py-10 flex justify-center items-center">
    <div class="grid grid-cols-3 gap-12 text-center">
        <!-- Item 1 -->
        <div>
            <i class="fas fa-newspaper text-5xl mb-2"></i>
            <div class="text-2xl font-bold count-up" data-count="{{ $totalNews }}">0</div>
            <div class="text-sm mt-1">Media Berita PWI Cianjur</div>
        </div>

        <!-- Item 2 -->
        <div>
            <i class="fas fa-id-badge text-5xl mb-2"></i>
            <div class="text-2xl font-bold count-up" data-count="{{ $totalUsers }}">0</div>
            <div class="text-sm mt-1">Anggota PWI Cianjur</div>
        </div>

        <!-- Item 3 -->
        <div>
            <i class="fa-solid fa-share-from-square text-5xl mb-2"></i>
            <div class="text-2xl font-bold count-up" data-count="{{ $totalSubmissions }}">0</div>
            <div class="text-sm mt-1">Pengajuan Oleh Masyarakat</div>
        </div>
    </div>
</div>


<section class="py-12">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold mb-8 border-l-4 border-black pl-4">Informasi</h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach ($informations as $information)
                <div class="rounded-lg shadow-sm border hover:shadow-md transition p-4 flex flex-col">
                    <img src="{{ asset($information->photo_url ?? 'images/default-image-square.png') }}" alt="Information Image"
                        class="rounded-lg w-full h-40 object-cover mb-3">
                    <p class="text-sm text-gray-500 mb-1">{{ \Carbon\Carbon::parse($information->created_at)->translatedFormat('l, d F Y') }}</p>
                    <h3 class="font-semibold text-base mb-2 line-clamp-2">{{ $information->judul }}</h3>
                    <a href="{{ route('informasi.show', $information) }}" class="mt-auto text-sm text-yellow-700 font-semibold hover:underline flex items-center gap-1">
                        Baca Selengkapnya <i class="fas fa-arrow-right text-xs"></i>
                    </a>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center mt-10">
            <a href="{{ route('informasi', $information) }}"
            class="bg-black hover:bg-white text-white font-semibold px-6 py-3 rounded-full transitio hover:text-black">
                Lihat Lebih Banyak
            </a>
        </div>
    </div>
</section>








<script>
    document.addEventListener("DOMContentLoaded", () => {
        const counters = document.querySelectorAll('.count-up');
        const duration = 2000; // total durasi animasi dalam ms (semakin besar semakin lambat)

        const countUp = (el) => {
            const target = +el.getAttribute('data-count');
            let start = 0;
            const startTime = performance.now();

            const animate = (currentTime) => {
                const elapsed = currentTime - startTime;
                const progress = Math.min(elapsed / duration, 1); // 0 - 1
                const current = Math.floor(progress * target);
                el.textContent = current;

                if (progress < 1) {
                    requestAnimationFrame(animate);
                } else {
                    el.textContent = target; // pastikan berhenti tepat
                }
            };

            requestAnimationFrame(animate);
        };

        // Jalankan animasi hanya saat elemen terlihat
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    countUp(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, {
            threshold: 0.5
        });

        counters.forEach(counter => observer.observe(counter));
    });
</script>


@endsection
