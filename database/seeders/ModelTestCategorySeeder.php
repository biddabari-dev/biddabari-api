<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;

class ModelTestCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ModelTestCategory::factory()
            ->count(5)
            ->create();
    }
}
