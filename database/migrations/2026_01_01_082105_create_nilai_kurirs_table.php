<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('nilai_kurirs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurir_id')->constrained()->onDelete('cascade');
            $table->foreignId('kriteria_id')->constrained('kriteria')->onDelete('cascade');
            $table->integer('skor_awal');
            $table->integer('skor_konversi');
            $table->decimal('utility', 8, 4);
            $table->decimal('nilai_akhir', 8, 4);
            $table->date('periode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('nilai_kurirs');
    }
};