<?php

namespace Database\Seeders;

use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Database\Seeder;

class QuestionTopicSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        QuestionTopic::factory()
            ->count(5)
            ->create();
    }
}
