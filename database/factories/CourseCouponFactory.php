<?php

namespace Database\Factories;

use App\Models\Backend\Course\Course;
use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseCoupon;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCouponFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseCoupon::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->name(),
            'type' => 'Flat',
            'percentage_value' => $this->faker->numberBetween(0, 8388607),
            'discount_amount' => $this->faker->randomNumber(0),
            'flat_discount' => $this->faker->numberBetween(0, 8388607),
            'note' => $this->faker->text,
            'expire_date_time' => $this->faker->text(255),
            'expire_date_time_timestamp' => $this->faker->text(255),
            'available_from' => $this->faker->text(255),
            'avaliable_from_timestamp' => $this->faker->text(255),
            'avaliable_to' => $this->faker->text(255),
            'avaliable_to_timestamp' => $this->faker->text(255),
            'status' => $this->faker->numberBetween(0, 127),
            'course_id' => Course::factory(),
        ];
    }
}
