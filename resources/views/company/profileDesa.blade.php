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
                    Profile Desa Sukanagara
                </h1>
            </div>

            <!-- Gambar dan Teks -->
            <div class="flex flex-col items-center">
                <!-- Gambar -->
                <div class="border border-black mb-6">
                    <img src="{{ asset('images/profile-sukanagara.jpg') }}" alt="gambar" class="max-w-[500px] max-h-[300px] object-cover">
                </div>

                <!-- Text content -->
                <div class="space-y-4 text-justify text-gray-800 px-6 md:px-20 lg:px-32">
                    <p>
                        Desa Sukanagara di Kecamatan Sukanagara, Kabupaten Cianjur, memiliki potensi ekonomi yang cukup menjanjikan berkat kekayaan sumber daya alamnya. Sebagian besar masyarakat menggantungkan mata pencaharian pada sektor pertanian dan perkebunan. Lahan yang subur dan iklim yang sejuk memungkinkan berbagai komoditas tumbuh dengan baik, seperti padi, jagung, dan aneka sayuran. Di beberapa wilayah, warga juga mengelola perkebunan teh dan kopi yang menjadi salah satu sumber pendapatan penting. Selain itu, kegiatan peternakan seperti ayam kampung, kambing, dan sapi menjadi penopang ekonomi rumah tangga, sementara sebagian warga memanfaatkan kolam atau sumber air untuk budidaya ikan air tawar seperti nila dan lele.
                    </p>
                    <p>
                        Seiring perkembangan zaman, Desa Sukanagara mulai memanfaatkan potensi ekonomi kreatif yang ada. Hasil panen tidak hanya dijual mentah, tetapi juga diolah menjadi berbagai produk bernilai tambah seperti keripik sayuran, sambal khas, atau aneka olahan pangan lainnya. Beberapa warga mengembangkan kerajinan tangan berbahan bambu dan kayu yang memiliki daya tarik tersendiri di pasar lokal. Peran Badan Usaha Milik Desa (BUMDes) dan kelompok tani turut membantu pemasaran produk-produk ini, baik secara langsung di pasar tradisional maupun melalui jalur distribusi yang lebih luas.
                    </p>
                    <p>
                        Tidak hanya mengandalkan sektor produksi, desa ini juga memiliki potensi agrowisata yang dapat dikembangkan lebih lanjut. Lanskap alam yang indah dengan hamparan sawah, udara sejuk pegunungan, dan suasana pedesaan yang asri menjadi daya tarik bagi wisatawan yang ingin menikmati pengalaman wisata berbasis alam dan budaya. Konsep wisata edukasi seperti tur pertanian, panen bersama, atau homestay pedesaan menjadi peluang yang dapat memberikan tambahan penghasilan bagi warga sekaligus memperkenalkan potensi desa ke masyarakat luas. Dengan pengelolaan yang tepat, potensi ekonomi dan sumber daya ini diharapkan mampu mendorong Desa Sukanagara menuju kemandirian dan kesejahteraan masyarakatnya.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
