<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\CircularManagement\CircularCategory;

class CircularCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CircularCategory::factory()
            ->count(5)
            ->create();
    }
}
