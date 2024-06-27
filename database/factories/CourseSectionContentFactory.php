<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\Course\CourseSectionContent;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseSectionContentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = CourseSectionContent::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'content_type' => 'pdf',
            'title' => $this->faker->text(255),
            'pdf_link' => $this->faker->text,
            'pdf_file' => $this->faker->text,
            'note_content' => $this->faker->text,
            'video_link' => $this->faker->text,
            'video_vendor' => 'youtube',
            'live_source_type' => 'facebook',
            'live_link' => $this->faker->text,
            'live_start_time' => $this->faker->text(255),
            'live_start_time_timestamp' => $this->faker->text(255),
            'live_end_time' => $this->faker->text(255),
            'live_end_time_timestamp' => $this->faker->text(255),
            'regular_link' => $this->faker->text,
            'assignment_question' => $this->faker->text,
            'assignment_instruction' => $this->faker->text,
            'assignment_total_mark' => $this->faker->numberBetween(0, 8388607),
            'assignment_pass_mark' => $this->faker->numberBetween(0, 8388607),
            'assignment_start_time' => $this->faker->text(255),
            'assignment_start_time_timestamp' => $this->faker->text(255),
            'assignment_end_time' => $this->faker->text(255),
            'assignment_end_time_timestamp' => $this->faker->text(255),
            'assignment_result_publish_time' => $this->faker->text(255),
            'assignment_result_publish_time_timestamp' => $this->faker->text(
                255
            ),
            'testmoj_link' => $this->faker->text(255),
            'testmoj_result_link' => $this->faker->text(255),
            'testmoj_xm_duration_in_minutes' => $this->faker->numberBetween(
                0,
                8388607
            ),
            'testmoj_total_questions' => $this->faker->text(255),
            'testmoj_start_time' => $this->faker->text(255),
            'testmoj_start_time_timestamp' => $this->faker->text(255),
            'testmoj_result_publish_time' => $this->faker->text(255),
            'testmoj_result_publish_time_timestamp' => $this->faker->text(255),
            'exam_mode' => 'exam',
            'exam_duration_in_minutes' => $this->faker->numberBetween(
                0,
                8388607
            ),
            'exam_total_questions' => $this->faker->text(255),
            'exam_per_question_mark' => $this->faker->numberBetween(0, 127),
            'exam_negative_mark' => $this->faker->numberBetween(0, 127),
            'exam_pass_mark' => $this->faker->numberBetween(0, 127),
            'exam_is_strict' => $this->faker->numberBetween(0, 127),
            'exam_start_time' => $this->faker->text(255),
            'exam_start_time_timestamp' => $this->faker->text(255),
            'exam_end_time' => $this->faker->text(255),
            'exam_end_time_timestamp' => $this->faker->text(255),
            'exam_result_publish_time' => $this->faker->text(255),
            'exam_result_publish_time_timestamp' => $this->faker->text(255),
            'exam_total_subject' => $this->faker->text(255),
            'written_exam_duration_in_minutes' => $this->faker->text(255),
            'written_total_questions' => $this->faker->text(255),
            'written_description' => $this->faker->text(255),
            'written_is_strict' => $this->faker->numberBetween(0, 127),
            'written_start_time' => $this->faker->text(255),
            'written_start_time_timestamp' => $this->faker->text(255),
            'written_end_time' => $this->faker->text(255),
            'written_end_time_timestamp' => $this->faker->text(255),
            'written_publish_time' => $this->faker->text(255),
            'written_publish_time_timestamp' => $this->faker->text(255),
            'written_total_subject' => $this->faker->text(255),
            'is_paid' => $this->faker->numberBetween(0, 127),
            'order' => $this->faker->numberBetween(0, 8388607),
            'status' => $this->faker->numberBetween(0, 127),
            'available_at' => $this->faker->text(255),
            'available_at_timestamp' => $this->faker->text(255),
            'course_section_id' => \App\Models\CourseSection::factory(),
            'parent_id' => function () {
                return \App\Models\CourseSectionContent::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
