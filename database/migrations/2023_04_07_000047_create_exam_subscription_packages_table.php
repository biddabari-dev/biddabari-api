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
        Schema::create('exam_subscription_packages', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable();
            $table->string('valid_form')->nullable();
            $table->string('valid_to')->nullable();
            $table->string('banner')->nullable();
            $table->tinyInteger('status')->default(1)->nullable();
            $table->float('price', 10, 2)->nullable();
            $table->integer('sell_qtn')->default(0)->nullable();

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
        Schema::dropIfExists('exam_subscription_packages');
    }
};
