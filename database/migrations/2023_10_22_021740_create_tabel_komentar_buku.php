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
        Schema::create('komentar_buku', function (Blueprint $table) {
            $table->id('idkomentar');
            $table->string('komentar');
            $table->foreignId('idbuku');
            $table->foreignId('noktp');

            $table->foreign('idbuku')->references('idbuku')->on('buku');
            $table->foreign('noktp')->references('noktp')->on('anggota');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('komentar_buku');

    }
};
