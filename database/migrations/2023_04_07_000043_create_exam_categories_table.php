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
        Schema::create('exam_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_category_id')->nullable();
            $table->string('name')->nullable();
            $table->string('icon_class_code')->nullable();
            $table->string('icon')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table
                ->tinyInteger('has_free_xm')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();
            $table->integer('order')->default(1)->nullable();
            $table
                ->float('price', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('open_for_sale')
                ->default(0)
                ->comment('1=>open, 0=>close')
                ->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('exam_categories');
    }
};
