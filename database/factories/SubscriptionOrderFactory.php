<?php

namespace Database\Factories;

use App\Models\Backend\ExamManagement\ExamSubscriptionPackage;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\Backend\ExamManagement\SubscriptionOrder;
use Illuminate\Database\Eloquent\Factories\Factory;

class SubscriptionOrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = SubscriptionOrder::class;

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
            'vendor' => 'bkash',
            'paid_to' => $this->faker->text(191),
            'paid_form' => $this->faker->text(191),
            'txt_id' => $this->faker->text(191),
            'paid_amount' => $this->faker->randomNumber(2),
            'total_amount' => $this->faker->randomNumber(2),
            'status' => $this->faker->numberBetween(0, 127),
            'exam_subscription_package_id' => ExamSubscriptionPackage::factory(),
            'user_id' => User::factory(),
        ];
    }
}
