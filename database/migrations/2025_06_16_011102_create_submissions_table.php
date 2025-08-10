<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('submissions', function (Blueprint $table) {
            $table->id();
            $table->string('status');
            $table->string('nama');
            $table->string('nik');
            $table->string('alamat');
            $table->string('pekerjaan');
            $table->string('rt');
            $table->string('status_desa');
            $table->string('jenis');
            $table->string('lokasi');
            $table->string('waktu');
            $table->text('kronologi');
            $table->string('pihak');
            $table->string('dampak');
            $table->string('harapan');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submissions');
    }
};
