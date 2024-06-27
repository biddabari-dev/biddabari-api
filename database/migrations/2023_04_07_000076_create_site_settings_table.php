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
        Schema::create('site_settings', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('site_title')->nullable();
            $table->text('site_meta_description')->nullable();
            $table->text('favicon')->nullable();
            $table->text('logo')->nullable();
            $table->text('banner')->nullable();
            $table->longText('default_seo_code_on_header')->nullable();
            $table->longText('default_seo_code_on_footer')->nullable();
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
        Schema::dropIfExists('site_settings');
    }
};
