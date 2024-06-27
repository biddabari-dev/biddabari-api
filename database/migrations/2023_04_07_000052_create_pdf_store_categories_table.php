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
        Schema::create('pdf_store_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->unsignedBigInteger('parent_id')
                ->default(0)
                ->nullable();
            $table->string('title')->nullable();
            $table->mediumInteger('order')->default(1)->nullable();
            $table->string('image')->nullable();
            $table->text('slug')->nullable();
            $table->tinyInteger('status')->nullable();

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
        Schema::dropIfExists('pdf_store_categories');
    }
};
