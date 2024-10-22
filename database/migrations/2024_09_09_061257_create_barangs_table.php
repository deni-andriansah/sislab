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
        Schema::create('barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_barang');
            $table->bigInteger('id_merk')->unsigned();
            $table->foreign('id_merk')->references('id')->on('merks')->ondelete('cascade');
            $table->bigInteger('id_kategori')->unsigned();
            $table->bigInteger('id_kondisi')->unsigned();
            $table->foreign('id_kondisi')->references('id')->on('kondisis')->ondelete('cascade');
            $table->string('posisi');
            $table->string('spek');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('barangs');
    }
};
