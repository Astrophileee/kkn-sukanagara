<?php

namespace Database\Seeders;

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
        $sekretarisRole = Role::firstOrCreate(['name' => 'sekretaris']);
        $anggotaRole = Role::firstOrCreate(['name' => 'anggota']);

        $sekretaris = User::query()
            ->where('email', 'sekretaris@example.com')
            ->first();
        if ($sekretaris === null) {
            $sekretaris = User::factory()->create([
                'email' => 'sekretaris@example.com',
            ]);
            $sekretaris->assignRole($sekretarisRole);
        }

        $anggota = User::query()
            ->where('email', 'anggota@example.com')
            ->first();
        if ($anggota === null) {
            $anggota = User::factory()->create([
                'email' => 'anggota@example.com',
            ]);
            $anggota->assignRole($anggotaRole);
        }
    }
}
