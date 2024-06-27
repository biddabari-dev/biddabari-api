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
        Schema::create('parent_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('parent_model_id');
            $table->unsignedBigInteger('checked_by')->nullable();
            $table->unsignedBigInteger('batch_exam_subscription_id')->nullable();
            $table->unsignedBigInteger('referrer_id')->nullable();
            $table
                ->enum('ordered_for', [
                    'course',
                    'product',
                    'course_exam',
                    'batch_exam',
                ])
                ->default('course')
                ->nullable();
            $table->string('order_invoice_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('vendor', ['bkash', 'nagad', 'rocket'])->nullable();
            $table->string('paid_to')->nullable();
            $table->string('paid_from')->nullable();
            $table->string('txt_id')->nullable();
            $table
                ->mediumInteger('paid_amount')
                ->default(0)
                ->nullable();
            $table
                ->mediumInteger('total_amount')
                ->default(0)
                ->nullable();
            $table->string('coupon_code')->nullable();
            $table
                ->mediumInteger('coupon_amount')
                ->default(0)
                ->nullable();
            $table
                ->enum('status', ['pending','approved','canceled'])
                ->default('pending')
                ->nullable();
            $table
                ->enum('contact_status', [
                    'pending',
                    'not_answered',
                    'confirmed',
                ])
                ->default('pending')
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
        Schema::dropIfExists('parent_orders');
    }
};
