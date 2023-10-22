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
        Schema::create('rating_buku', function (Blueprint $table) {
            $table->foreignId('idbuku');
            $table->foreignId('noktp');
            $table->smallInteger('skor_rating');
            $table->timestamp('tgl_rating')->useCurrent();

            $table->foreign('idbuku')->references('idbuku')->on('buku');
            $table->foreign('noktp')->references('noktp')->on('anggota');
            $table->primary(['idbuku', 'noktp']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rating_buku');

    }
};
