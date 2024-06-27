<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\ProductManagement\ProductCategory;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductCategory::factory()
            ->count(5)
            ->create();
    }
}
