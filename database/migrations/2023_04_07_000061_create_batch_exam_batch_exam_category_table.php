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
        Schema::create('batch_exam_batch_exam_category', function (
            Blueprint $table
        ) {
            $table->unsignedBigInteger('batch_exam_category_id');
            $table->unsignedBigInteger('batch_exam_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_exam_batch_exam_category');
    }
};
