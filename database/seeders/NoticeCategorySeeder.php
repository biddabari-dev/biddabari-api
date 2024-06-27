<?php

namespace Database\Seeders;

use App\Models\Backend\NoticeManagement\NoticeCategory;
use Illuminate\Database\Seeder;

class NoticeCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        NoticeCategory::factory()
            ->count(5)
            ->create();
    }
}
