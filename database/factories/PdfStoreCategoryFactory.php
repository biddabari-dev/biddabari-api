<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\Backend\PdfManagement\PdfStoreCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

class PdfStoreCategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PdfStoreCategory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'slug' => $this->faker->text,
            'status' => $this->faker->numberBetween(0, 127),
            'parent_id' => function () {
                return PdfStoreCategory::factory()->create([
                    'parent_id' => null,
                ])->id;
            },
        ];
    }
}
