<?php

namespace Database\Factories;

use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamOrder;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamOrder::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'order_invoice_number' => $this->faker->text(191),
            'payment_method' => $this->faker->text(191),
            'vendor' => 'bikash',
            'paid_to' => $this->faker->text(191),
            'paid_form' => $this->faker->text(191),
            'txt_id' => $this->faker->text(191),
            'paid_amount' => $this->faker->randomNumber(2),
            'total_amount' => $this->faker->randomNumber(2),
            'status' => 'pending',
            'contact_status' => 'pending',
            'exam_id' => Exam::factory(),
            'user_id' => User::factory(),
            'xm_order_checked_by' => User::factory(),
        ];
    }
}
