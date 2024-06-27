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
        Schema::create('question_topics', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('question_topic_id')->default(0)->nullable();
            $table->unsignedBigInteger('created_by');
            $table->string('name')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table
                ->tinyInteger('order')
                ->default(1)
                ->nullable();
            $table->string('slug')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->enum('type', ['mcq', 'written'])->nullable();
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
        Schema::dropIfExists('question_topics');
    }
};
