<div id="overlay" onclick="closeSidebar()" class="fixed inset-0 bg-[rgba(0,0,0,0.75)] z-30 hidden lg:hidden"></div>



<!-- Sidebar -->
<aside id="sidebar" class="fixed z-40 top-0 left-0 w-64 min-h-screen bg-white border-r border-gray-200 transform -translate-x-full transition-transform duration-300 lg:translate-x-0 lg:static lg:z-auto">
    <div class="p-4 flex items-center gap-2">
        <img src="/images/default-image-square.png" alt="Logo" class="w-8 h-8" />
        <div>
            <h1 class="font-bold text-sm">DESA SUKANAGARA</h1>
            <p class="text-xs text-gray-500">management</p>
        </div>
    </div>
    <nav class="mt-4 space-y-2 text-sm">
    <!-- Single link -->
    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fas fa-home w-5 h-5 pt-1 text-gray-600"></i>
        Dashboard
    </a>

    <a href="{{ route('users.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fa-solid fa-user w-5 h-5 pt-1 text-gray-600"></i>
        Data Pengguna
    </a>


    <a href="{{ route('informations.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fa-solid fa-newspaper w-5 h-5 pt-1 text-gray-600"></i>
        Data Informasi
    </a>
    <a href="{{ route('submissions.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fa-solid fa-inbox w-5 h-5 pt-1 text-gray-600"></i>
        Inbox Pengajuan
    </a>
    <a href="{{ route('apbns.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fa-solid fa-wallet w-5 h-5 pt-1 text-gray-600"></i>
        APBN
    </a>
    <a href="{{ route('penduduks.index') }}" class="flex items-center gap-3 px-4 py-2 hover:bg-gray-100">
        <i class="fa-solid fa-people-group w-5 h-5 pt-1 text-gray-600"></i>
        Penduduk
    </a>
    </nav>
</aside>
