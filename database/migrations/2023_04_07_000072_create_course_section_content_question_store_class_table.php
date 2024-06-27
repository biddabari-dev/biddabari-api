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
        Schema::create('course_section_content_question_store_class', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('question_store_id');
            $table->unsignedBigInteger('course_section_content_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_section_content_question_store_class');
    }
};
