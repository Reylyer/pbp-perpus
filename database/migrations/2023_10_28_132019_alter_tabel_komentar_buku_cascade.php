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
        Schema::table('komentar_buku', function (Blueprint $table) {
            $table->dropForeign('komentar_buku_idbuku_foreign');
            $table->foreign('idbuku')
                    ->references('idbuku')
                    ->on('buku')
                    ->onDelete('cascade');
            $table->dropForeign('komentar_buku_noktp_foreign');
            $table->foreign('noktp')
                    ->references('noktp')
                    ->on('anggota')
                    ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
};
