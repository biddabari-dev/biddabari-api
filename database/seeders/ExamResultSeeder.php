<?php

namespace Database\Seeders;

use App\Models\Backend\ExamManagement\ExamResult;
use Illuminate\Database\Seeder;

class ExamResultSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamResult::factory()
            ->count(5)
            ->create();
    }
}
