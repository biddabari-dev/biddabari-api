<?php

namespace Database\Factories;

use App\Models\Backend\UserManagement\Teacher;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class TeacherFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Teacher::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->email,
            'mobile' => $this->faker->phoneNumber,
            'description' => $this->faker->sentence(15),
            'present_address' => $this->faker->text,
            'permanent_address' => $this->faker->text,
            'subject' => $this->faker->text(255),
            'last_education' => $this->faker->text(191),
            'status' => $this->faker->numberBetween(0, 127),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
