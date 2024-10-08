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
        Schema::create('kelas', function (Blueprint $table) {
            $table->id();
            $table->string('kode', 20);
            $table->string('keterangan', 100);
            $table->string('tahun_ajaran', 100);
            $table->foreign('tahun_ajaran')->references('tahun')->on('tahun_ajarans')->onUpdate('cascade');
            $table->foreignId('guru_id')->constrained('gurus');
            $table->string('guru');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kelas');
    }
};
