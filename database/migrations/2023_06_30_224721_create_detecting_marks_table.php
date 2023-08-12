<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('detecting_marks', function (Blueprint $table) {
            $table->id();
            $table->string('FatherName');
            $table->string('MatherName');
            $table->string('FirstName');
            $table->string('LastName');
            $table->string('BirthPlace');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detecting_marks');
    }
};
