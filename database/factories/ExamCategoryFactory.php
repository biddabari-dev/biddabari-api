<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\ExamManagement\ExamCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExamCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ExamCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'icon_class_code' => $this->faker->text(191),
            'icon' => $this->faker->text(191),
            'description' => $this->faker->sentence(15),
            'has_free_xm' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'exam_category_id' => function () {
                return ExamCategory::factory()->create([
                    'exam_category_id' => null,
                ])->id;
            },
        ];
    }
}
