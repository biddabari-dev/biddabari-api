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
        Schema::create('popup_notifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('title')->nullable();
            $table
                ->enum('popup_type', ['course', 'book', 'external_link'])
                ->nullable();
            $table->string('image')->nullable();
            $table->string('action_btn_text')->nullable();
            $table->text('active_btn_link')->nullable();
            $table->text('description')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('popup_notifications');
    }
};
