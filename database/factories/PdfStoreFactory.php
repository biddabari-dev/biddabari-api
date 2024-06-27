<?php

namespace Database\Factories;

use App\Models\Backend\PdfManagement\PdfStoreCategory;
use App\Models\Backend\PdfManagement\PdfStore;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class PdfStoreFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = PdfStore::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(10),
            'preview_image' => $this->faker->text(191),
            'file_external_link' => $this->faker->text,
            'file_size' => $this->faker->randomNumber(0),
            'file_type' => $this->faker->text(191),
            'file_extension' => $this->faker->text(191),
            'total_page' => $this->faker->text(191),
            'slug' => $this->faker->text,
            'status' => $this->faker->numberBetween(0, 127),
            'pdf_store_category_id' => PdfStoreCategory::factory(),
        ];
    }
}
