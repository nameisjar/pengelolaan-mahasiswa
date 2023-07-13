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
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->string('nilai');
            $table->unsignedBigInteger('id__mahasiswa');
            $table->foreign('id__mahasiswa')->references('id')->on('mahasiswas');
            $table->unsignedBigInteger('id__matkul');
            $table->foreign('id__matkul')->references('id')->on('matkuls');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};
