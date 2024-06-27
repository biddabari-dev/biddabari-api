<?php

namespace Database\Factories;

use App\Models\Backend\Course\Course;
use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseSection;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseSectionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseSection::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'available_at' => $this->faker->text(191),
            'note' => $this->faker->text,
            'is_paid' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'order' => $this->faker->numberBetween(0, 8388607),
            'course_id' => Course::factory(),
        ];
    }
}
