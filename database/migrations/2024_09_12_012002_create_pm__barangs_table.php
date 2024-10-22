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
        Schema::create('pm__barangs', function (Blueprint $table) {
            $table->id();
            $table->string('nama_peminjam');
            $table->string('email');
            $table->string('instansi');
            $table->bigInteger('id_barang')->unsigned();
            $table->foreign('id_barang')->references('id')->on('barangs')->ondelete('cascade');
            $table->bigInteger('id_ruangan')->unsigned();
            $table->foreign('id_ruangan')->references('id')->on('ruangans')->ondelete('cascade');
            $table->string('tanggal_peminjaman');
            $table->string('tanggal_pengembalian');
            $table->string('keterangan');
            $table->bigInteger('id_kondisi')->unsigned();
            $table->foreign('id_kondisi')->references('id')->on('kondisis')->ondelete('cascade');
            $table->string('cover');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pm__barangs');
    }
};
