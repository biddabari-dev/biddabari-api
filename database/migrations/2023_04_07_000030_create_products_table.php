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
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
//            $table->unsignedBigInteger('product_category_id');
            $table->unsignedBigInteger('product_author_id');
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->text('featured_pdf')->nullable();
            $table->decimal('price')->nullable();
            $table->decimal('discount_amount')->nullable();
            $table->string('discount_duration')->nullable();
            $table->string('discount_duration_timestamp')->nullable();
            $table->text('about')->nullable();
            $table->longText('description')->nullable();
            $table->longText('specification')->nullable();
            $table->longText('other_details')->nullable();
            $table
                ->tinyInteger('in_stock')
                ->default(0)
                ->nullable();
            $table
                ->integer('stock_amount')
                ->default(0)
                ->nullable();
            $table
                ->integer('total_sell')
                ->default(0)
                ->nullable();
            $table
                ->integer('hit_count')
                ->default(0)
                ->nullable();
            $table->string('slug')->nullable();
            $table
                ->tinyInteger('is_featured')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();

            $table
                ->tinyInteger('discount_type')
                ->default(1)->comment('1 => Fixed; 2 => Percentage')
                ->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_start_date_timestamp')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('discount_end_date_timestamp')->nullable();

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
        Schema::dropIfExists('products');
    }
};
