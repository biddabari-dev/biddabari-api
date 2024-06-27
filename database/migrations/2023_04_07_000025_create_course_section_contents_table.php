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
        Schema::create('course_section_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_section_id');
            $table
                ->unsignedBigInteger('parent_id')
                ->default(0)
                ->nullable();
            $table
                ->enum('content_type', [
                    'pdf',
                    'video',
                    'note',
                    'live',
                    'link',
                    'assignment',
                    'testmoj',
                    'exam',
                    'written_exam',
                ])
                ->nullable();
            $table->string('title')->nullable();
            $table->text('pdf_link')->nullable();
            $table->text('pdf_file')->nullable();
            $table->longText('note_content')->nullable();
            $table->text('video_link')->nullable();
            $table
                ->enum('video_vendor', ['youtube', 'vimeo', 'private'])
                ->nullable();
            $table
                ->enum('live_source_type', [
                    'facebook',
                    'meet',
                    'youtube',
                    'zoom',
                    'others',
                ])
                ->nullable();
            $table->text('live_link')->nullable();
            $table->string('live_start_time')->nullable();
            $table->string('live_start_time_timestamp')->nullable();
            $table->string('live_end_time')->nullable();
            $table->string('live_end_time_timestamp')->nullable();
            $table->text('regular_link')->nullable();
            $table->text('assignment_question')->nullable();
            $table->text('assignment_instruction')->nullable();
            $table->mediumInteger('assignment_total_mark')->nullable();
            $table->mediumInteger('assignment_pass_mark')->nullable();
            $table->string('assignment_start_time')->nullable();
            $table->string('assignment_start_time_timestamp')->nullable();
            $table->string('assignment_end_time')->nullable();
            $table->string('assignment_end_time_timestamp')->nullable();
            $table->string('assignment_result_publish_time')->nullable();
            $table
                ->string('assignment_result_publish_time_timestamp')
                ->nullable();
            $table->string('testmoj_link')->nullable();
            $table->string('testmoj_result_link')->nullable();
            $table->mediumInteger('testmoj_xm_duration_in_minutes')->nullable();
            $table->string('testmoj_total_questions')->nullable();
            $table->string('testmoj_start_time')->nullable();
            $table->string('testmoj_start_time_timestamp')->nullable();
            $table->string('testmoj_result_publish_time')->nullable();
            $table->string('testmoj_result_publish_time_timestamp')->nullable();
            $table
                ->enum('exam_mode', ['exam', 'practice', 'group'])
                ->nullable();
            $table->mediumInteger('exam_duration_in_minutes')->nullable();
            $table->string('exam_total_questions')->nullable();
            $table
                ->tinyInteger('exam_per_question_mark')
                ->default(1)
                ->nullable();
            $table->tinyInteger('exam_negative_mark')->nullable();
            $table->tinyInteger('exam_pass_mark')->nullable();
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
            $table->string('written_description')->nullable();
            $table->tinyInteger('written_is_strict')->nullable();
            $table->string('written_start_time')->nullable();
            $table->string('written_start_time_timestamp')->nullable();
            $table->string('written_end_time')->nullable();
            $table->string('written_end_time_timestamp')->nullable();
            $table->string('written_publish_time')->nullable();
            $table->string('written_publish_time_timestamp')->nullable();
            $table->string('written_total_subject')->nullable();
            $table
                ->tinyInteger('is_paid')
                ->default(0)
                ->nullable();
            $table
                ->mediumInteger('order')
                ->default(1)
                ->nullable();
            $table->tinyInteger('status')->nullable();
            $table->string('available_at')->nullable();
            $table->string('available_at_timestamp')->nullable();

            $table
                ->tinyInteger('has_class_xm')
                ->default(0)
                ->nullable();
            $table->unsignedBigInteger('course_section_content_id')->nullable();
            $table
                ->mediumInteger('class_xm_mark')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('is_class_xm_complete')
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
        Schema::dropIfExists('course_section_contents');
    }
};
