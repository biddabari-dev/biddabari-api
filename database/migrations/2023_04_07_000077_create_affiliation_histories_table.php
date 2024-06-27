<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('affiliation_histories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->enum('model_type', ['course', 'batch_exam', 'product'])
                ->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->unsignedBigInteger('affiliation_registration_id');
            $table->unsignedBigInteger('user_id');
            $table
                ->float('amount', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->enum('affiliate_type', ['insert', 'withdraw'])
                ->default('insert')
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(1)
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliation_histories');
    }
};
