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
        Schema::create('model_test_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_test_category_id')->nullable();
            $table->string('name')->nullable();
            $table->string('image')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('model_test_categories');
    }
};
