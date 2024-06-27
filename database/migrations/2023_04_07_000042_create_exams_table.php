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
        Schema::create('exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_category_id');
            $table->string('title')->nullable();
            $table->text('slug')->nullable();
            $table->enum('xm_type', ['MCQ', 'Written'])->nullable();
            $table->string('xm_date')->nullable();
            $table->string('xm_date_timestamp')->nullable();
            $table->string('xm_start_time')->nullable();
            $table->string('xm_start_time_timestamp')->nullable();
            $table->string('xm_end_time')->nullable();
            $table->string('xm_end_time_timestamp')->nullable();
            $table->string('xm_duration')->nullable();
            $table->tinyInteger('xm_pass_mark')->default(0)->nullable();
            $table
                ->string('total_mark')
                ->default('0')
                ->nullable();
            $table->string('image')->nullable();
            $table
                ->tinyInteger('is_paid')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('is_featured')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table
                ->float('price', 10, 2)
                ->default(0)
                ->nullable();

            $table
                ->tinyInteger('xm_subscription_duration')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('per_question_mark')
                ->default(1)
                ->nullable();
            $table->float('negative_mark', 3, 2)->nullable();
            $table
                ->tinyInteger('mark_base_result')
                ->default(0)->comment('0=>No;1=>Yes')
                ->nullable();
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
        Schema::dropIfExists('exams');
    }
};
