<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\RoleManagement\PermissionCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PermissionCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PermissionCategory::class;

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
            'note' => $this->faker->text,
            'status' => $this->faker->numberBetween(0, 127),
        ];
    }
}
