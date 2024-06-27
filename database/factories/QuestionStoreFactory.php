<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Backend\QuestionManagement\QuestionStore;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionStoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionStore::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'question_type' => 'MCQ',
            'question' => $this->faker->text,
            'question_description' => $this->faker->text,
            'question_image' => $this->faker->text,
            'question_video_link' => $this->faker->text,
            'question_mark' => $this->faker->numberBetween(0, 127),
            'question_hardness' => '0',
            'written_que_ans' => $this->faker->text,
            'written_que_ans_description' => $this->faker->text,
            'written_que_file' => $this->faker->text,
            'has_all_wrong_ans' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug,
            'created_by' => User::factory(),
        ];
    }
}
