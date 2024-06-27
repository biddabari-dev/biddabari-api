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
        Schema::create('site_seos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->enum('model_type', [
                    'course',
                    'course_category',
                    'batch_exam',
                    'batch_exam_category',
                    'product',
                    'product_category',
                    'blog',
                    'blog_category',
                ])
                ->nullable();
            $table->unsignedBigInteger('parent_model_id')->nullable();
            $table->longText('header_code')->nullable();
            $table->longText('footer_code')->nullable();
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
        Schema::dropIfExists('site_seos');
    }
};
