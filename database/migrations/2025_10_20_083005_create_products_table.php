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
    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->foreignId('room_id')->constrained('rooms')->onDelete('cascade');
        $table->string('nama_produk');
        $table->string('gambar_produk'); // Path ke gambar produk
        $table->boolean('ketersediaan')->default(true); // Availability (true/false)
        $table->string('link_detail')->nullable(); // Link eksternal untuk tombol detail
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
