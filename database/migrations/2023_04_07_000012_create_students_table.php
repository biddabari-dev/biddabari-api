<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('first_name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanent_address')->nullable();
            $table->text('last_education')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();
            $table->string('dob')->nullable();
            $table->string('school')->nullable();
            $table->string('college')->nullable();
            $table->string('university')->nullable();
            $table->text('github')->nullable();
            $table->text('twitter')->nullable();
            $table->text('linkedin')->nullable();
            $table->text('whatsapp')->nullable();
            $table->text('facebook')->nullable();
            $table->text('website')->nullable();
            $table->string('institute_name')->nullable();
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
        Schema::dropIfExists('students');
    }
};
