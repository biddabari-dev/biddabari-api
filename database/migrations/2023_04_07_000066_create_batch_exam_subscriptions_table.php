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
        Schema::create('batch_exam_subscriptions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('batch_exam_id');
            $table->string('package_title')->nullable();
            $table->float('price')->nullable();
            $table->tinyInteger('package_duration_in_days')->nullable();
            $table->tinyInteger('discount_type')->comment('1 => Fixed; 2 => Percentage')->nullable();
            $table->string('discount_amount')->default(0)->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_start_date_timestamp')->nullable();
            $table->string('discount_end_date_timestamp')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();

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
        Schema::dropIfExists('batch_exam_subscriptions');
    }
};
