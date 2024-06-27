<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'featured_pdf' => $this->faker->text,
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'discount' => $this->faker->randomFloat(2, 0, 9999),
            'discount_duration' => $this->faker->text(255),
            'discount_duration_timestamp' => $this->faker->text(255),
            'about' => $this->faker->text,
            'description' => $this->faker->text,
            'specification' => $this->faker->text,
            'other_details' => $this->faker->text,
            'in_stock' => $this->faker->numberBetween(0, 127),
            'stock_amount' => $this->faker->randomNumber(0),
            'total_sell' => $this->faker->randomNumber(0),
            'hit_count' => $this->faker->randomNumber(0),
            'slug' => $this->faker->slug,
            'is_featured' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'product_category_id' => \App\Models\ProductCategory::factory(),
            'product_author_id' => \App\Models\ProductAuthor::factory(),
        ];
    }
}
