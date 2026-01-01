<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('kurirs', function (Blueprint $table) {
            $table->id();
            $table->string('kode_kurir')->unique();
            $table->string('nama_kurir');
            $table->integer('jumlah_pengiriman');
            $table->decimal('otd', 5, 2); // On-Time Delivery
            $table->decimal('absensi', 5, 2);
            $table->decimal('etika', 3, 2);
            $table->enum('status', ['aktif', 'nonaktif'])->default('aktif');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('kurirs');
    }
};