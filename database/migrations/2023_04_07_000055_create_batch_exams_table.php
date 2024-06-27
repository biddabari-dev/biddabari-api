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
        Schema::create('batch_exams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->text('title')->nullable();
            $table->text('sub_title')->nullable();
            $table
                ->decimal('price', 10, 2)
                ->default(0)
                ->nullable();
            $table->text('banner')->nullable();
            $table->longText('description')->nullable();
            $table->text('featured_video_url')->nullable();
            $table
                ->tinyInteger('package_duration_in_days')
                ->default(1)
                ->nullable();
            $table
                ->tinyInteger('discount_type')
                ->default(1)
                ->comment('1 => Fixed; 2 => Percentage')
                ->nullable();
            $table->mediumInteger('discount_amount')->nullable();
            $table->string('discount_start_date')->nullable();
            $table->string('discount_start_date_timestamp')->nullable();
            $table->string('discount_end_date')->nullable();
            $table->string('discount_end_date_timestamp')->nullable();
            $table
                ->tinyInteger('is_paid')
                ->default(1)
                ->nullable();
            $table->tinyInteger('is_featured')->nullable();
            $table
                ->tinyInteger('is_approved')
                ->default(1)
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
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('batch_exams');
    }
};
