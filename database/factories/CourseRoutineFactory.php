<?php

namespace Database\Factories;

use App\Models\Backend\Course\Course;
use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseRoutine;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseRoutineFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseRoutine::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'day' => $this->faker->text(255),
            'date_time' => $this->faker->text(255),
            'room' => $this->faker->text(255),
            'note' => $this->faker->text,
            'status' => $this->faker->numberBetween(0, 127),
            'course_id' => Course::factory(),
        ];
    }
}
