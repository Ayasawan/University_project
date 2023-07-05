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
            $table->string('semester');
            $table->integer('year');
            $table->string('subject_name');
//            $table->integer('employee_id');
//            $table->integer('student_id');
            $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('re_practical');
    }
};
