<?php

namespace Database\Seeders;

use App\Models\Backend\ModelTestManagement\ModelTest;
use Illuminate\Database\Seeder;

class ModelTestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelTest::factory()
            ->count(5)
            ->create();
    }
}
