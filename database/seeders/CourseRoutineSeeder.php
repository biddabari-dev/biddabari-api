<?php

namespace Database\Seeders;

use App\Models\Backend\Course\CourseRoutine;
use Illuminate\Database\Seeder;

class CourseRoutineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseRoutine::factory()
            ->count(5)
            ->create();
    }
}
