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
        Schema::create('question_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('created_by');
            $table
                ->enum('question_type', ['MCQ', 'Written'])
                ->default('MCQ')
                ->nullable();
            $table->text('question')->nullable();
            $table->text('question_description')->nullable();
            $table->text('question_image')->nullable();
            $table->text('question_video_link')->nullable();
            $table
                ->tinyInteger('question_mark')
                ->default(1)
                ->nullable();
            $table
                ->float('negative_mark')
                ->default(0)
                ->nullable();
            $table
                ->enum('question_hardness', ['easy', 'hard', 'both'])
                ->default('both')
                ->nullable();
            $table->longText('written_que_ans')->nullable();
            $table->longText('written_que_ans_description')->nullable();
            $table->text('written_que_file')->nullable();
            $table
                ->tinyInteger('has_all_wrong_ans')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->string('slug')->nullable();
            $table->string('subject_name')->nullable();

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
        Schema::dropIfExists('question_stores');
    }
};
