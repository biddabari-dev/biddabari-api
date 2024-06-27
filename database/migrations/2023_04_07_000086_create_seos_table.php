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
        Schema::create('seos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->enum('seo_for', [
                    'course',
                    'batch_exam',
                    'product',
                    'blog',
                    'course_category',
                    'batch_exam_category',
                    'product_category',
                    'blog_category',
                    'custom_page',
                    'product_category',
                ])
                ->default('course');
            $table->unsignedBigInteger('parent_model_id')->nullable();
            $table->text('custom_page_link')->nullable();
            $table->string('slug')->nullable();
            $table->text('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->text('meta_tags')->nullable();
            $table->text('meta_image_description')->nullable();
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
        Schema::dropIfExists('seos');
    }
};
