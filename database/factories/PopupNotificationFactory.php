<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\AdditionalFeatureManagement\PopupNotification;
use Illuminate\Database\Eloquent\Factories\Factory;

class PopupNotificationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PopupNotification::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'popup_type' => 'course',
            'action_btn_text' => $this->faker->text(191),
            'active_btn_link' => $this->faker->text,
            'description' => $this->faker->sentence(15),
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
