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
        Schema::create('informasis', function (Blueprint $table) {
            $table->id();
            $table->string('nama_informasi', 50);
            $table->string('kepala_informasi', 50);
            $table->string('nip', 50);
            $table->string('foto_profile', 50)->nullable();
            $table->string('alamat',255);
            $table->string('logo', 100)->nullable();
            $table->longText('visi');
            $table->longText('misi');
            $table->longText('deskripsi');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('informasis');
    }
};
