<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('ranking', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kurir_id')->constrained()->onDelete('cascade');
            $table->decimal('total_nilai', 10, 4);
            $table->integer('ranking');
            $table->enum('status', ['⭐ Kurir Terbaik', 'Baik', 'Perlu Evaluasi']);
            $table->date('periode');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ranking');
    }
};