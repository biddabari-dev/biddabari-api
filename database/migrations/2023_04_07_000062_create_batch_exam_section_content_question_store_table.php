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
        Schema::create('batch_exam_section_content_question_store', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('question_store_id');
            $table->unsignedBigInteger('batch_exam_section_content_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_exam_section_content_question_store');
    }
};
