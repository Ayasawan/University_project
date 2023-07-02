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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('FirstName', 25);
            $table->string('LastName', 25);
            $table->string('FatherName', 25);
            $table->string('MotherName', 25);
            $table->string('Specialization');
            $table->string('Year');
            $table->date('Birthday');
            $table->string('BirthPlace');
            $table->string('Gender');
            $table->text('Location');
            $table->string('Phone');
            $table->string('ExamNumber');
            $table->string('Average');
            $table->string('NationalNumber')->unique()->nullable();

            $table->string('email')->unique()->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
