<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMataPelajaransTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mata_pelajarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapor_header_id');
            $table->string('nama_mata_pelajaran',50);
            $table->float('nilai_uts',0,4);
            $table->float('nilai_uas',0,4);
            $table->string('catatan');

            $table->foreign('rapor_header_id')->references('id')->on('rapor_headers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mata_pelajarans');
    }
}
