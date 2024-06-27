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
        Schema::create('blogs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('blog_category_id');
            $table->unsignedBigInteger('author_id')->nullable();
            $table->string('title')->nullable();
            $table->string('sub_title')->nullable();
            $table->text('video_url')->nullable();
            $table->text('image')->nullable();
            $table->integer('hit_count')->nullable();
            $table->longText('body')->nullable();
            $table->longText('slug')->nullable();
            $table
                ->tinyInteger('is_featured')
                ->default(0)
                ->nullable();
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
        Schema::dropIfExists('blogs');
    }
};
