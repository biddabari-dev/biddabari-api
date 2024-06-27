<?php

namespace Database\Factories;

use App\Models\Backend\Course\Course;
use App\Models\Frontend\CourseOrder\CourseOrder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'payment_method' => $this->faker->text(191),
            'vendor' => 'bkash',
            'paid_to' => $this->faker->text(191),
            'paid_from' => $this->faker->text(191),
            'txt_id' => $this->faker->text(191),
            'payment_status' => $this->faker->text(191),
            'paid_amount' => $this->faker->numberBetween(0, 8388607),
            'total_amount' => $this->faker->numberBetween(0, 8388607),
            'coupon_code' => $this->faker->text(191),
            'coupon_amount' => $this->faker->numberBetween(0, 8388607),
            'status' => $this->faker->numberBetween(0, 127),
            'contact_status' => 'pending',
            'course_id' => Course::factory(),
            'user_id' => User::factory(),
            'checked_by' => User::factory(),
        ];
    }
}
