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
        Schema::table('model_test_categories', function (Blueprint $table) {
            $table
                ->foreign('model_test_category_id')
                ->references('id')
                ->on('model_test_categories')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('model_test_categories', function (Blueprint $table) {
            $table->dropForeign(['model_test_category_id']);
        });
    }
};
