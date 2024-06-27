<?php

namespace Database\Seeders;

use App\Models\Backend\Course\CourseCoupon;
use Illuminate\Database\Seeder;

class CourseCouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        CourseCoupon::factory()
            ->count(5)
            ->create();
    }
}
