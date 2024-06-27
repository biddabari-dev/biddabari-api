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
        Schema::create('course_coupons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->string('code')->nullable();
            $table->enum('type', ['Flat', 'Percentage'])->nullable();
            $table->mediumInteger('percentage_value')->nullable();
            $table->integer('discount_amount')->nullable();
            $table->mediumInteger('flat_discount')->nullable();
            $table->text('note')->nullable();
            $table->string('expire_date_time')->nullable();
            $table->string('expire_date_time_timestamp')->nullable();
            $table->string('available_from')->nullable();
            $table->string('avaliable_from_timestamp')->nullable();
            $table->string('avaliable_to')->nullable();
            $table->string('avaliable_to_timestamp')->nullable();
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
        Schema::dropIfExists('course_coupons');
    }
};
