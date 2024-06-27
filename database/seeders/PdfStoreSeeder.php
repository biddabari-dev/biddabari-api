<?php

namespace Database\Seeders;

use App\Models\Backend\PdfManagement\PdfStore;
use Illuminate\Database\Seeder;

class PdfStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PdfStore::factory()
            ->count(5)
            ->create();
    }
}
