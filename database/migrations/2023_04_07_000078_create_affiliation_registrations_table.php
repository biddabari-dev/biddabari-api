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
        Schema::create('affiliation_registrations', function (
            Blueprint $table
        ) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('user_id');
            $table->string('affiliate_code');
            $table
                ->float('total_earning', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->float('total_withdraw', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->float('balance', 10, 2)
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('status')
                ->default(0)
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('affiliation_registrations');
    }
};
