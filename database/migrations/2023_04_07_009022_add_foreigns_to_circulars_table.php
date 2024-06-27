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
        Schema::table('circulars', function (Blueprint $table) {
            $table
                ->foreign('circular_category_id')
                ->references('id')
                ->on('circular_categories')
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
        Schema::table('circulars', function (Blueprint $table) {
            $table->dropForeign(['circular_category_id']);
        });
    }
};
