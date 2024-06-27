<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\BlogManagement\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = BlogCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'order' => $this->faker->numberBetween(0, 8388607),
            'status' => $this->faker->numberBetween(0, 127),
            'parent_id' => function () {
                return BlogCategory::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
