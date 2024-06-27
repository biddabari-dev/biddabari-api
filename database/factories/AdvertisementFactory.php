<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\AdditionalFeatureManagement\Advertisement;
use Illuminate\Database\Eloquent\Factories\Factory;

class AdvertisementFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Advertisement::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'content_type' => 'course',
            'link' => $this->faker->text,
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
