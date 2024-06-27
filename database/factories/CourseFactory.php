<?php

namespace Database\Factories;

use App\Models\Backend\Course\Course;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Course::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'sub_title' => $this->faker->text(191),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'banner' => $this->faker->text(191),
            'description' => $this->faker->sentence(15),
            'duration_in_month' => $this->faker->text(191),
            'starting_date_time' => $this->faker->text(191),
            'starting_date_time_timestamp' => $this->faker->text(191),
            'ending_date_time' => $this->faker->text(191),
            'ending_date_time_timestamp' => $this->faker->text(191),
            'discount_type' => $this->faker->numberBetween(0, 127),
            'discount_amount' => $this->faker->randomNumber(0),
            'partial_payment' => $this->faker->randomNumber(2),
            'fack_student_count' => $this->faker->numberBetween(0, 8388607),
            'enroll_student_count' => $this->faker->numberBetween(0, 8388607),
            'featured_video_vendor' => $this->faker->text(191),
            'featured_video_url' => $this->faker->text,
            'total_video' => $this->faker->numberBetween(0, 127),
            'total_audio' => $this->faker->numberBetween(0, 127),
            'total_exam' => $this->faker->numberBetween(0, 127),
            'total_pdf' => $this->faker->numberBetween(0, 127),
            'total_note' => $this->faker->numberBetween(0, 127),
            'total_link' => $this->faker->numberBetween(0, 127),
            'total_live' => $this->faker->numberBetween(0, 127),
            'total_zip' => $this->faker->numberBetween(0, 127),
            'total_file' => $this->faker->numberBetween(0, 127),
            'total_written_exam' => $this->faker->numberBetween(0, 127),
            'is_featured' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'is_approved' => $this->faker->numberBetween(0, 127),
        ];
    }
}
