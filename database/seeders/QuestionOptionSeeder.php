<?php

namespace Database\Seeders;

use App\Models\Backend\QuestionManagement\QuestionOption;
use Illuminate\Database\Seeder;

class QuestionOptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionOption::factory()
            ->count(5)
            ->create();
    }
}
