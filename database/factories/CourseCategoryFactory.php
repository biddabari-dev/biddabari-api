<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->sentence(10),
            'note' => $this->faker->text,
            'icon' => $this->faker->text(191),
            'meta_title' => $this->faker->text(191),
            'meta_description' => $this->faker->text,
            'slug' => $this->faker->slug,
            'order' => $this->faker->randomNumber(0),
            'is_featured' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->word,
            'parent_id' => function () {
                return CourseCategory::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
