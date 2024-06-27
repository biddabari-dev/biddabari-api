<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('course_class_exam_results', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_section_content_id');
            $table->unsignedBigInteger('user_id');
            $table->text('provided_ans')->nullable();
            $table
                ->tinyInteger('result_mark')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('is_reviewed')
                ->default(0)
                ->nullable();
            $table
                ->mediumInteger('required_time')
                ->default(0)
                ->nullable();
            $table->enum('status', ['pass', 'fail'])->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_class_exam_results');
    }
};
