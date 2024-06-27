<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\CircularManagement\CircularCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircularCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CircularCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'order' => $this->faker->numberBetween(0, 8388607),
            'slug' => $this->faker->slug,
            'status' => $this->faker->word,
            'parent_id' => function () {
                return CircularCategory::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
