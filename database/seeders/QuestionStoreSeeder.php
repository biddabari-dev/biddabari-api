<?php

namespace Database\Seeders;

use App\Models\Backend\QuestionManagement\QuestionStore;
use Illuminate\Database\Seeder;

class QuestionStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionStore::factory()
            ->count(5)
            ->create();
    }
}
