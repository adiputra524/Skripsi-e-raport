<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRaportsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::dropIfExists('raports');
       Schema::create('raports', function (Blueprint $table) {
        $table->id();
        $table->foreignId('student_id');
        $table->dateTime('created_at');
        $table->dateTime('updated_at');
        $table->foreign('student_id')->references('id')->on('tbl_students');

        // $table->timestamps();

    });
   }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('raports');
    }
}
