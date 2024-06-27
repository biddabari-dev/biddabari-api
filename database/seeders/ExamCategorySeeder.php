<?php

namespace Database\Seeders;

use App\Models\Backend\ExamManagement\ExamCategory;
use Illuminate\Database\Seeder;

class ExamCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamCategory::factory()
            ->count(5)
            ->create();
    }
}
