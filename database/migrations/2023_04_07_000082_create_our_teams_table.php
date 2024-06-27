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
        Schema::create('our_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->nullable();
            $table->string('designation')->nullable();
            $table->string('image')->nullable();
            $table
                ->enum('content_show_type', ['home_page', 'about_us_page'])
                ->default('about_us_page')
                ->nullable();
            $table->text('video_link')->nullable();
            $table->text('video_file')->nullable();
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
        Schema::dropIfExists('our_teams');
    }
};
