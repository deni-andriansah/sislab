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
        Schema::create('p_barangs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_pm_barang')->unsigned();
            $table->foreign('id_pm_barang')->references('id')->on('pm__barangs')->ondelete('cascade');
            $table->string('nama_pengembali');
            $table->string('tanggal_pengembalian');
            $table->string('keterangan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('p_barangs');
    }
};
