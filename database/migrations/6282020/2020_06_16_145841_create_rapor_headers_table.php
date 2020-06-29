<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaporHeadersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('rapor_headers');
        Schema::create('rapor_headers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('rapor_id');
            $table->string('tahun_ajaran',30);
            $table->integer('semester');
            
            $table->foreign('rapor_id')->references('id')->on('raports');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::dropIfExists('rapor_headers');
    }
}
