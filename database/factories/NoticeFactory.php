<?php

namespace Database\Factories;

use App\Models\Backend\NoticeManagement\Notice;
use App\Models\Backend\NoticeManagement\NoticeCategory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class NoticeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Notice::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'type' => 'normal',
            'body' => $this->faker->text,
            'slug' => $this->faker->slug,
            'status' => $this->faker->numberBetween(0, 127),
            'notice_category_id' => NoticeCategory::factory(),
        ];
    }
}
