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
        Schema::table('course_section_contents', function (Blueprint $table) {
            $table
                ->foreign('course_section_id')
                ->references('id')
                ->on('course_sections')
                ->onUpdate('CASCADE')
                ->onDelete('CASCADE');

            $table
                ->foreign('parent_id')
                ->references('id')
                ->on('course_section_contents')
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
        Schema::table('course_section_contents', function (Blueprint $table) {
            $table->dropForeign(['course_section_id']);
            $table->dropForeign(['parent_id']);
        });
    }
};
