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
        Schema::create('question_options', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_store_id');
            $table->unsignedBigInteger('created_by');
            $table->mediumText('option_title')->nullable();
            $table->tinyInteger('is_correct')->nullable();
            $table->text('option_description')->nullable();
            $table->text('option_image')->nullable();
            $table->text('option_video_url')->nullable();

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
        Schema::dropIfExists('question_options');
    }
};
