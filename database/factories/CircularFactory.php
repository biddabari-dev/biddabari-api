<?php

namespace Database\Factories;

use App\Models\Backend\CircularManagement\Circular;
use App\Models\Backend\CircularManagement\CircularCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CircularFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Circular::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'post_title' => $this->faker->text(191),
            'job_title' => $this->faker->text(191),
            'vacancy' => $this->faker->numberBetween(0, 8388607),
            'about' => $this->faker->text,
            'description' => $this->faker->text,
            'publish_date' => $this->faker->text(191),
            'publish_date_timestamp' => $this->faker->text(191),
            'expire_date' => $this->faker->text(191),
            'expire_date_timestamp' => $this->faker->text(191),
            'status' => $this->faker->numberBetween(0, 127),
            'slug' => $this->faker->slug,
            'is_featured' => $this->faker->numberBetween(0, 127),
            'order' => $this->faker->randomNumber(0),
            'circular_category_id' => CircularCategory::factory(),
        ];
    }
}
