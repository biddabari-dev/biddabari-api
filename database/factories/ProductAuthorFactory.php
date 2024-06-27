<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\ProductManagement\ProductAuthor;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductAuthorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductAuthor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'description' => $this->faker->sentence(15),
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
