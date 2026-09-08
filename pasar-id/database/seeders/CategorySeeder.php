<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $cats = [
            ['name' => 'Makanan', 'slug' => 'makanan', 'description' => 'Makanan olahan dan jajanan lokal'],
            ['name' => 'Minuman', 'slug' => 'minuman', 'description' => 'Minuman tradisional dan kekinian'],
            ['name' => 'Sembako', 'slug' => 'sembako', 'description' => 'Kebutuhan pokok harian'],
            ['name' => 'Fashion', 'slug' => 'fashion', 'description' => 'Pakaian dan aksesoris lokal'],
            ['name' => 'Kerajinan', 'slug' => 'kerajinan', 'description' => 'Kerajinan tangan dan souvenir'],
            ['name' => 'Pertanian', 'slug' => 'pertanian', 'description' => 'Hasil tani dan perkebunan'],
            ['name' => 'Elektronik', 'slug' => 'elektronik', 'description' => 'Alat elektronik dan aksesori'],
            ['name' => 'Kebutuhan Rumah', 'slug' => 'kebutuhan-rumah', 'description' => 'Peralatan dan kebutuhan rumah tangga'],
        ];

        foreach ($cats as $cat) {
            Category::updateOrCreate(
                ['slug' => $cat['slug']],
                $cat
            );
        }

        $this->command->info('Kategori seeded: ' . count($cats));
    }
}