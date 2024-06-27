<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamSubscriptionPackageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamSubscriptionPackage::class;

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
            'valid_form' => $this->faker->text(191),
            'valid_to' => $this->faker->text(191),
            'status' => $this->faker->numberBetween(0, 127),
            'price' => $this->faker->randomNumber(2),
            'sell_qtn' => $this->faker->randomNumber(0),
        ];
    }
}
