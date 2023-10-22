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
        Schema::create('detail_transaksi', function (Blueprint $table) {
            $table->foreignId('idtransaksi');
            $table->foreignId('idbuku');
            $table->integer('denda');
            $table->timestamp('tgl_kembali')->useCurrent();
            $table->foreignId('idpetugas');

            $table->foreign('idtransaksi')->references('idtransaksi')->on('peminjaman');
            $table->foreign('idbuku')->references('idbuku')->on('buku');
            $table->foreign('idpetugas')->references('idpetugas')->on('petugas');
            $table->primary(['idtransaksi', 'idbuku']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detail_transaksi');

    }
};
