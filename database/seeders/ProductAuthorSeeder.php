<?php

namespace Database\Seeders;

use App\Models\Backend\ProductManagement\ProductAuthor;
use Illuminate\Database\Seeder;

class ProductAuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ProductAuthor::factory()
            ->count(5)
            ->create();
    }
}
