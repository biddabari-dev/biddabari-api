<?php

namespace Database\Factories;

use App\Models\Backend\ExamManagement\Exam;
use App\Models\Backend\ExamManagement\ExamResult;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamResultFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamResult::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'xm_type' => $this->faker->text(255),
            'written_xm_file' => $this->faker->text,
            'provided_ans' => $this->faker->text,
            'result_mark' => $this->faker->numberBetween(0, 127),
            'status' => 'pass',
            'exam_id' => Exam::factory(),
            'user_id' => User::factory(),
        ];
    }
}
