<?php

namespace Database\Seeders;

use App\Models\Backend\ExamManagement\ExamOrder;
use Illuminate\Database\Seeder;

class ExamOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamOrder::factory()
            ->count(5)
            ->create();
    }
}
