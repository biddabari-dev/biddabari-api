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
        Schema::create('courses', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->text('slug')->nullable();
            $table->text('sub_title')->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->string('banner')->nullable();
            $table->text('description')->nullable();
            $table
                ->string('duration_in_month')
                ->default('1')
                ->nullable();
            $table->string('starting_date_time')->nullable();
            $table->string('starting_date_time_timestamp')->nullable();
            $table->string('ending_date_time')->nullable();
            $table->string('ending_date_time_timestamp')->nullable();
            $table->tinyInteger('discount_type')->comment('1 => Fixed; 2 => Percentage')->default(1)->nullable();
            $table->integer('discount_amount')->nullable();
            $table->float('partial_payment')->default(0)->nullable();
            $table->mediumInteger('fack_student_count')->nullable();
            $table->mediumInteger('enroll_student_count')->nullable();
            $table->string('featured_video_vendor')->nullable();
            $table->text('featured_video_url')->nullable();
            $table->tinyInteger('total_video')->nullable();
            $table->tinyInteger('total_audio')->nullable();
            $table->tinyInteger('total_exam')->nullable();
            $table->tinyInteger('total_pdf')->nullable();
            $table->tinyInteger('total_note')->nullable();
            $table->tinyInteger('total_link')->nullable();
            $table->tinyInteger('total_live')->nullable();
            $table->tinyInteger('total_zip')->nullable();
            $table->tinyInteger('total_file')->nullable();
            $table->tinyInteger('total_written_exam')->nullable();
            $table->string('total_class')->nullable();
            $table->string('total_hours')->nullable();
            $table
                ->tinyInteger('is_featured')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table
                ->tinyInteger('is_approved')
                ->default(0)
                ->nullable();

            $table
                ->tinyInteger('is_paid')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('show_home_slider')
                ->default(0)
                ->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_start_date_timestamp')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('discount_end_date_timestamp')->nullable();

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
        Schema::dropIfExists('courses');
    }
};
