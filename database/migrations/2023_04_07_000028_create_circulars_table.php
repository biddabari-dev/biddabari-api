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
        Schema::create('circulars', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('circular_category_id');
            $table->string('post_title')->nullable();
            $table->string('job_title')->nullable();
            $table->mediumInteger('vacancy')->nullable();
            $table->string('image')->nullable();
            $table->text('about')->nullable();
            $table->longText('description')->nullable();
            $table->string('publish_date')->nullable();
            $table->string('publish_date_timestamp')->nullable();
            $table->string('expire_date')->nullable();
            $table->string('expire_date_timestamp')->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->string('slug')->nullable();
            $table
                ->tinyInteger('is_featured')
                ->default(0)
                ->nullable();
            $table
                ->integer('order')
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
        Schema::dropIfExists('circulars');
    }
};
