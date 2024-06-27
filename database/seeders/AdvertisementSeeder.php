<?php

namespace Database\Seeders;

use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use Illuminate\Database\Seeder;

class AdvertisementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Advertisement::factory()
            ->count(5)
            ->create();
    }
}
