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
        Schema::create('batch_exam_section_contents', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('id');
            $table->unsignedBigInteger('batch_exam_section_id');
            $table->unsignedBigInteger('parent_id')->nullable();
            $table
                ->enum('content_type', ['pdf', 'note', 'exam', 'written_exam'])
                ->nullable();
            $table->string('available_at')->nullable();
            $table->string('available_at_timestamp')->nullable();
            $table->text('title')->nullable();
            $table->text('pdf_link')->nullable();
            $table->text('pdf_file')->nullable();
            $table->longText('note_content')->nullable();
            $table
                ->enum('exam_mode', ['exam', 'practice', 'group'])
                ->nullable();
            $table
                ->mediumInteger('exam_duration_in_minutes')
                ->default(1)
                ->nullable();
            $table
                ->string('exam_total_questions')
                ->default('0')
                ->nullable();
            $table
                ->tinyInteger('exam_per_question_mark')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('exam_negative_mark')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('exam_is_strict')
                ->default(0)
                ->nullable();
            $table->string('exam_start_time')->nullable();
            $table->string('exam_start_time_timestamp')->nullable();
            $table->string('exam_end_time')->nullable();
            $table->string('exam_end_time_timestamp')->nullable();
            $table->string('exam_result_publish_time')->nullable();
            $table->string('exam_result_publish_time_timestamp')->nullable();
            $table->string('exam_total_subject')->nullable();
            $table->string('written_exam_duration_in_minutes')->nullable();
            $table->string('written_total_questions')->nullable();
            $table->text('written_description')->nullable();
            $table
                ->tinyInteger('written_is_strict')
                ->default(0)
                ->nullable();
            $table->string('written_start_time')->nullable();
            $table->string('written_start_time_timestamp')->nullable();
            $table->string('written_end_time')->nullable();
            $table->string('written_end_time_timestamp')->nullable();
            $table->string('written_publish_time')->nullable();
            $table->string('written_publish_time_timestamp')->nullable();
            $table->string('written_total_subject')->nullable();
            $table
                ->tinyInteger('is_paid')
                ->default(1)
                ->nullable();
            $table->mediumInteger('order')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
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
        Schema::dropIfExists('batch_exam_section_contents');
    }
};
