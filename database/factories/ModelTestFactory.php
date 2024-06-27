<?php

namespace Database\Factories;

use App\Models\Backend\ModelTestManagement\ModelTest;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelTestFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModelTest::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
            'model_test_category_id' => ModelTestCategory::factory(),
        ];
    }
}
