<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;

class ExamSubscriptionPackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ExamSubscriptionPackage::factory()
            ->count(5)
            ->create();
    }
}
