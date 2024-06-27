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
        Schema::create('batch_exam_routines', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_exam_id');
            $table->string('day')->nullable();
            $table->string('date_time')->nullable();
            $table->string('date_time_timestamp')->nullable();
            $table->string('room')->nullable();
            $table->text('note')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table
                ->tinyInteger('is_fack')
                ->default(0)
                ->nullable();

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
        Schema::dropIfExists('batch_exam_routines');
    }
};
