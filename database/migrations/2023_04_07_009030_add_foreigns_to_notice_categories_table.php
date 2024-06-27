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
//        Schema::table('notice_categories', function (Blueprint $table) {
//            $table
//                ->foreign('notice_category_id')
//                ->references('id')
//                ->on('notice_categories')
//                ->onUpdate('CASCADE')
//                ->onDelete('CASCADE');
//        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notice_categories', function (Blueprint $table) {
            $table->dropForeign(['notice_category_id']);
        });
    }
};
