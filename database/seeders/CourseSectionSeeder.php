<?php

namespace Database\Seeders;

use App\Models\Backend\Course\CourseSection;
use Illuminate\Database\Seeder;

class CourseSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseSection::factory()
            ->count(5)
            ->create();
    }
}
