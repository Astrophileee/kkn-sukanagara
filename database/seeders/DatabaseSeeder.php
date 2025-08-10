<?php

namespace Database\Seeders;

use App\Models\Apbn;
use App\Models\Penduduk;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        $sekretaris = User::query()
            ->where('email', 'sekretaris@example.com')
            ->first();
        if ($sekretaris === null) {
            $sekretaris = User::factory()->create([
                'email' => 'sekretaris@example.com',
            ]);
        }

        $anggota = User::query()
            ->where('email', 'anggota@example.com')
            ->first();
        if ($anggota === null) {
            $anggota = User::factory()->create([
                'email' => 'anggota@example.com',
            ]);
        }

        $penduduk = Penduduk::query()->where('label', 'Penduduk')->first();
        if ($penduduk === null) {
            $penduduk = Penduduk::factory()->create([
                'label' => 'Penduduk',
            ]);
        }
        $kk = Penduduk::query()->where('label', 'Kartu Keluarga')->first();
        if ($kk === null) {
            $kk = Penduduk::factory()->create([
                'label' => 'Kartu Keluarga',
            ]);
        }
        $rt = Penduduk::query()->where('label', 'RT/RW')->first();
        if ($rt === null) {
            $rt = Penduduk::factory()->create([
                'label' => 'RT/RW',
            ]);
        }



        $dana = Apbn::query()->where('label', 'Dana Desa')->first();
        if ($dana === null) {
            $dana = Apbn::factory()->create([
                'label' => 'Dana Desa',
            ]);
        }
        $bumdes = Apbn::query()->where('label', 'Hasil Bumdes')->first();
        if ($bumdes === null) {
            $bumdes = Apbn::factory()->create([
                'label' => 'Hasil Bumdes',
            ]);
        }
        $kas = Apbn::query()->where('label', 'Kas Desa')->first();
        if ($kas === null) {
            $kas = Apbn::factory()->create([
                'label' => 'Kas Desa',
            ]);
        }
        $pendapatan = Apbn::query()->where('label', 'Pendapatan')->first();
        if ($pendapatan === null) {
            $pendapatan = Apbn::factory()->create([
                'label' => 'Pendapatan',
            ]);
        }
    }
}
