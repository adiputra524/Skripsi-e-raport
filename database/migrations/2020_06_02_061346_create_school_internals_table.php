<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolInternalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('school_internals');
        Schema::create('school_internals', function (Blueprint $table) {
            $table->id();
            $table->string('name',60);
            $table->string('email',100);
            $table->string('phone',15);
            $table->string('password',255);
            // $table->string('profile_picture',255);
            $table->foreignId('role_id');
            // $table->dateTime('created_at');
            // $table->dateTime('updated_at');

            //$table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('school_internals');
    }
}
