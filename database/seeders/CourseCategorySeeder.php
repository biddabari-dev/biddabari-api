<?php

namespace Database\Seeders;

use App\Models\Backend\Course\CourseCategory;
use Illuminate\Database\Seeder;

class CourseCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseCategory::factory()
            ->count(5)
            ->create();
    }
}
