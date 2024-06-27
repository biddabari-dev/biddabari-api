<?php

namespace Database\Factories;

use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Exam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'xm_type' => '',
            'xm_date' => $this->faker->text(191),
            'xm_date_timestamp' => $this->faker->text(191),
            'xm_start_time' => $this->faker->text(191),
            'xm_start_time_timestamp' => $this->faker->text(191),
            'xm_end_time' => $this->faker->text(191),
            'xm_end_time_timestamp' => $this->faker->text(191),
            'xm_duration' => $this->faker->text(191),
            'is_paid' => $this->faker->numberBetween(0, 127),
            'is_featured' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'exam_category_id' => ExamCategory::factory(),
        ];
    }
}
