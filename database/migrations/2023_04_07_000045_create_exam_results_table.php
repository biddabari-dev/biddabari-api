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
        Schema::create('exam_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('exam_id');
            $table->unsignedBigInteger('user_id');
            $table->string('xm_type')->nullable();
            $table->text('written_xm_file')->nullable();
            $table->text('provided_ans')->nullable();
            $table
                ->tinyInteger('result_mark')
                ->default(0)
                ->nullable();
            $table
                ->tinyInteger('is_reviewed')
                ->default(0)
                ->nullable();
            $table->enum('status', ['pass', 'fail'])->nullable();
            $table
                ->mediumInteger('required_time')
                ->default(0)
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
        Schema::dropIfExists('exam_results');
    }
};
