<?php

namespace Database\Factories;

use App\Models\Backend\BlogManagement\Blog;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class BlogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Blog::class;

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
            'video_url' => $this->faker->text,
            'body' => $this->faker->text,
            'author_id' => $this->faker->randomNumber,
            'is_featured' => $this->faker->numberBetween(0, 127),
            'status' => $this->faker->numberBetween(0, 127),
            'blog_category_id' => Blog::factory(),
        ];
    }
}
