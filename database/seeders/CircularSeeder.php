<?php

namespace Database\Seeders;

use App\Models\Backend\CircularManagement\Circular;
use Illuminate\Database\Seeder;

class CircularSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Circular::factory()
            ->count(5)
            ->create();
    }
}
