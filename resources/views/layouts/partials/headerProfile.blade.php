<header class="bg-white shadow py-2 h-16 flex justify-center items-center sticky top-0 z-50">
    <div class="flex items-center gap-6">
        <!-- Logo -->
        <div class="flex items-center gap-2">
            <img src="/images/default-image-square.png" alt="Logo" class="w-8 h-8" />
            <div>
                <h1 class="font-bold text-sm leading-none">DESA SUKANAGARA</h1>
                <p class="text-xs text-gray-500 leading-none">Cianjur</p>
            </div>
        </div>

        <!-- Navigation -->
        <nav class="flex gap-6 text-sm font-medium text-gray-700">
            <a href="{{ route('beranda') }}" class="hover:text-black">Beranda</a>
            <a href="{{ route('profileDesa') }}" class="hover:text-black">Tentang Kami</a>
            <a href="{{ route('informasi') }}" class="hover:text-black">Informasi</a>
            <a href="{{ route('kontak') }}" class="hover:text-black">Kontak</a>
        </nav>
    </div>
</header>
