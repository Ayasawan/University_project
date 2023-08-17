<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up()
    {
        Schema::create('re_practical', function (Blueprint $table) {
            $table->id();
            $table->enum('semester', ['first', 'second', 'third','null']);
            $table->enum('year', ['first', 'second', 'third','fourth','fifth','null']);
            $table->string('subject_name');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('re_practical');
    }
};
