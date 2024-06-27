<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\QuestionManagement\QuestionTopic;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuestionTopicFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = QuestionTopic::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'icon' => $this->faker->text(191),
            'meta_title' => $this->faker->text(191),
            'meta_description' => $this->faker->text,
            'order' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
            'question_topic_id' => function () {
                return QuestionTopic::factory()->create([
                    'question_topic_id' => null,
                ])->id;
            },
            'created_by' => \App\Models\User::factory(),
        ];
    }
}
