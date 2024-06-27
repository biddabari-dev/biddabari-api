<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Backend\PdfManagement\PdfStoreCategory;

class PdfStoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PdfStoreCategory::factory()
            ->count(5)
            ->create();
    }
}
