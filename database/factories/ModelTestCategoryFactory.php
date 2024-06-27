<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\ModelTestManagement\ModelTestCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ModelTestCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ModelTestCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
            'model_test_category_id' => function () {
                return ModelTestCategory::factory()->create([
                    'model_test_category_id' => null,
                ])->id;
            },
        ];
    }
}
