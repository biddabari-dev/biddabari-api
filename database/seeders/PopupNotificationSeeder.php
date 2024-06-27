<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;

class PopupNotificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PopupNotification::factory()
            ->count(5)
            ->create();
    }
}
