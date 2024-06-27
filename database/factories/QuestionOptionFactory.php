<?php

namespace Database\Factories;

use App\Models\Backend\QuestionManagement\QuestionStore;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Backend\QuestionManagement\QuestionOption;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionOptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionOption::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'option_title' => $this->faker->text,
            'is_correct' => $this->faker->numberBetween(0, 127),
            'option_description' => $this->faker->text,
            'option_image' => $this->faker->text,
            'option_video_url' => $this->faker->text,
            'question_store_id' => QuestionStore::factory(),
            'created_by' => User::factory(),
        ];
    }
}
