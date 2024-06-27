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
        Schema::create('subscription_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_subscription_package_id');
            $table->unsignedBigInteger('user_id');
            $table->string('order_invoice_number')->nullable();
            $table->string('payment_method')->nullable();
            $table->enum('vendor', ['bkash', 'rocket', 'nagad'])->nullable();
            $table->string('paid_to')->nullable();
            $table->string('paid_form')->nullable();
            $table->string('txt_id')->nullable();
            $table
                ->float('paid_amount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->float('total_amount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(0)->comment('0=>pending,1=>approved,2=>canceled')
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
        Schema::dropIfExists('subscription_orders');
    }
};
