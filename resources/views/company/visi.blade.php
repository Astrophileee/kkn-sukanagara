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
                    Visi & Misi
                </h1>
            </div>

            <!-- Gambar dan Teks -->
            <div class="flex flex-col items-center">

                <!-- Text content -->
                <div class="space-y-4 text-justify text-gray-800 px-6 md:px-20 lg:px-32">
                    <p class="text-3xl font-semibold">
                        Visi
                    </p>
                    <p>
                        Terwujudnya Desa Sukanagara yang Koordinatif, Agamis, Solutif, Edukatif dan Produktif
                    </p>
                    <p class="text-3xl font-semibold">
                        Visi
                    </p>
                    <ol type="1" class="list-decimal list-inside">
                        <li>
                            Melakukan perbaikan birokrasi dijajaran pemerintah desa gunameningkatkan kwalitas pelayanan kepada masyarakat;
                        </li>
                        <li>
                            Menyelenggarakan pemerintahan yang bersih terbebas dari korupsiserta bentuk-bentuk penyelewengan lainnya;
                        </li>
                        <li>
                            Meningkatkan perekonomian masyarakat dengan berbasiskan padapotensi desa;
                        </li>
                        <li>
                            Meningkatkan mutu kesejahteraan masyarakat untuk mencapai tarapkehidupan yang lebih baik dan layak;
                        </li>
                        <li>
                            Mewujudkan propesionalisme yang transparan dalammenyelenggarakan pemerintahan;
                        </li>
                        <li>
                            Meningkatkan sarana prasarana tempat ibadah guna meningkatkankeimanan dan ketaqwaan serta dalam membentuk akhlaqulkarimah;
                        </li>
                        <li>
                            Meningkatkan sarana dan prasarana umum guna meningkatkankelancaran perekonomian masyarakat;
                        </li>
                        <li>
                            Mengembangkan pemberdayaan masyarakat dan kemitraan dalampembangunan desa yang bersangkutan.
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
