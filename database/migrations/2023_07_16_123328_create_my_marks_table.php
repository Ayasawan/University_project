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
        Schema::create('my_marks', function (Blueprint $table) {
            $table->id();
            $table->string('nameMark');
            $table->string('markNum');
            $table->enum('year', ['first', 'second', 'third','fourth','fifth','null']);
            $table->enum('semester', ['first', 'second', 'third','null']);
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
        Schema::dropIfExists('my_marks');
    }
};
