<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('floor_id')->constrained('floors')->onDelete('cascade');
            $table->string('nama_ruangan'); // Misal: "Ruang Operasi 1"
            $table->string('posisi_x'); // Posisi X dalam persen (misal: "30%")
            $table->string('posisi_y'); // Posisi Y dalam persen (misal: "50%")
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rooms');
    }
};
