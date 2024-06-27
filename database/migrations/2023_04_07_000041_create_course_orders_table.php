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
        Schema::create('course_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('course_id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->string('order_invoice_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('vendor', ['bkash', 'nagad', 'rocket'])->nullable();
            $table->string('paid_to')->nullable();
            $table->string('paid_from')->nullable();
            $table->string('txt_id')->nullable();
            $table->string('payment_status')->nullable();
            $table->mediumInteger('paid_amount')->default(0)->nullable();
            $table->mediumInteger('total_amount')->default(0)->nullable();
            $table->string('coupon_code')->nullable();
            $table->mediumInteger('coupon_amount')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0 => pending, 1 => Approved, 2 => canceled')->nullable();
            $table->enum('contact_status', [
                    'pending',
                    'not_answered',
                    'confirmed',
                ])->default('pending')->nullable();
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
        Schema::dropIfExists('course_orders');
    }
};
