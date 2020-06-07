<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTblStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('tbl_students');
        Schema::create('tbl_students', function (Blueprint $table) {
            $table->id();
            $table->string('nama',60);
            $table->string('nis',15);
            $table->string('email',100);
            $table->string('password',255);
            $table->string('phone',15);
            // $table->string('profile_picture',255);
            $table->foreignId('class_id');
            $table->dateTime('created_at');
            $table->dateTime('updated_at');
            // $table->timestamps();

            $table->foreign('class_id')->references('id')->on('kelas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_students');
    }
}
