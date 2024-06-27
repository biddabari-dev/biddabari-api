<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\Course\CourseSectionContent;

class CourseSectionContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseSectionContent::factory()
            ->count(5)
            ->create();
    }
}
