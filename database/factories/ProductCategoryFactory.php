<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\ProductManagement\ProductCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'icon_code' => $this->faker->text(255),
            'is_featured' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug,
            'order' => $this->faker->numberBetween(0, 8388607),
            'status' => $this->faker->numberBetween(0, 127),
            'parent_id' => function () {
                return ProductCategory::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
