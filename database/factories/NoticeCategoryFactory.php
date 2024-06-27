<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = NoticeCategory::class;

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
            'status' => $this->faker->numberBetween(0, 127),
            'notice_category_id' => function () {
                return NoticeCategory::factory()->create([
                    'notice_category_id' => null,
                ])->id;
            },
        ];
    }
}
