<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\ExamManagement\SubscriptionOrder;

class SubscriptionOrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SubscriptionOrder::factory()
            ->count(5)
            ->create();
    }
}
