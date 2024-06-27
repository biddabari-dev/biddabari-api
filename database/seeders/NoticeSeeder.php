<?php

namespace Database\Seeders;

use App\Models\Backend\NoticeManagement\Notice;
use Illuminate\Database\Seeder;

class NoticeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Notice::factory()
            ->count(5)
            ->create();
    }
}
