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
        Schema::create('exam_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_category_id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_invoice_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('vendor', ['bkash', 'nagad', 'rocket'])->nullable();
            $table->string('paid_to')->nullable();
            $table->string('paid_form')->nullable();
            $table->string('txt_id')->nullable();
            $table
                ->float('paid_amount')
                ->default(0)
                ->nullable();
            $table->float('total_amount')->nullable();
            $table
                ->enum('status', ['pending', 'approved', 'canceled'])
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
            $table->unsignedBigInteger('xm_order_checked_by');

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
        Schema::dropIfExists('exam_orders');
    }
};
