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
        Schema::create('pdf_stores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('pdf_store_category_id');
            $table->string('title')->nullable();
            $table->string('preview_image')->nullable();
            $table->text('file_external_link')->nullable();
            $table->string('file_url')->nullable();
            $table
                ->integer('file_size')
                ->default(0)
                ->nullable();
            $table->string('file_type')->nullable();
            $table->string('file_extension')->nullable();
            $table->string('total_page')->nullable();
            $table->text('slug')->nullable();
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
        Schema::dropIfExists('pdf_stores');
    }
};
