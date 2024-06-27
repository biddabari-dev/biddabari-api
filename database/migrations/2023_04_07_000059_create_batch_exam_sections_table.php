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
        Schema::create('batch_exam_sections', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_exam_id');
            $table->string('title')->nullable();
            $table->string('available_at')->nullable();
            $table->text('note')->nullable();
            $table
                ->tinyInteger('is_paid')
                ->default(1)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->mediumInteger('order')->nullable();

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
        Schema::dropIfExists('batch_exam_sections');
    }
};
