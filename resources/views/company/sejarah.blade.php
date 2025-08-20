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
                    <img src="{{ asset('images/sejarah-sukanagara.jpg') }}" alt="gambar" class="max-w-[500px] max-h-[300px] object-cover">
                </div>

                <!-- Text content -->
                <div class="space-y-4 text-justify text-gray-800 px-6 md:px-20 lg:px-32">
                    <p>
                        Desa Sukanagara merupakan salah satu desa yang berada di wilayah Kecamatan Sukanagara, Kabupaten Cianjur, yang memiliki sejarah panjang dalam perkembangannya. Nama “Sukanagara” sendiri diyakini berasal dari gabungan kata “Suka” yang berarti senang atau damai, dan “Nagara” yang berarti negeri atau wilayah, sehingga dapat dimaknai sebagai “wilayah yang menyenangkan dan damai untuk dihuni.” Sejak awal berdirinya, desa ini telah menjadi pusat aktivitas masyarakat di sekitarnya berkat kondisi alamnya yang subur dan strategis.
                    </p>
                    <p>
                        Pada masa-masa awal, penduduk Desa Sukanagara mayoritas bermata pencaharian sebagai petani dan peternak. Kehidupan masyarakat sangat kental dengan nilai-nilai gotong royong, di mana setiap kegiatan, mulai dari pembangunan rumah, pengelolaan lahan, hingga perayaan adat, dilakukan bersama-sama. Seiring berjalannya waktu, perkembangan infrastruktur dan akses transportasi mulai menghubungkan desa ini dengan wilayah lain di Cianjur, sehingga mendorong pertumbuhan ekonomi dan sosial masyarakat.
                    </p>
                    <p>
                        Perubahan demi perubahan terus terjadi, baik dari sisi tata kelola pemerintahan desa, peningkatan fasilitas umum, maupun pengembangan sektor ekonomi. Namun demikian, masyarakat Desa Sukanagara tetap menjaga tradisi dan kearifan lokal yang diwariskan dari generasi ke generasi. Kini, desa ini tidak hanya menjadi tempat tinggal yang nyaman, tetapi juga memiliki potensi besar di bidang pertanian, perkebunan, dan pariwisata, yang menjadikannya sebagai salah satu desa yang berperan penting dalam perkembangan wilayah Kecamatan Sukanagara.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
