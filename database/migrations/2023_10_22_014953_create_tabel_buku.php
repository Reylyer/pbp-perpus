<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('buku', function (Blueprint $table) {
            $table->id('idbuku');
            $table->string('isbn');
            $table->string('judul');
            $table->string('pengarang');
            $table->string('penerbit');
            $table->string('kota_terbit');
            $table->string('editor');
            $table->string('file_gambar');
            $table->foreignId('idkategori');
            $table->foreign('idkategori')
                  ->references('idkategori')
                  ->on('kategori')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('buku');
    }
};
