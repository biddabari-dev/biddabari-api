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
        Schema::create('student_opinions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table
                ->enum('show_type', ['all_students', 'running_student'])
                ->default('all_students');
            $table->string('name')->nullable();
            $table->text('image')->nullable();
            $table->text('comment')->nullable();
            $table->tinyInteger('status')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_opinions');
    }
};
