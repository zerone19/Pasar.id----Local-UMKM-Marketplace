<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mapping produk ke kategori berdasarkan nama/slug
        $productCategoryMap = [
            // Makanan
            'keripik-singkong-pedas' => 'makanan',
            'keripik-pisang-cokelat' => 'makanan',
            'madu-murni'            => 'minuman',       // Madu termasuk minuman/historis
            'madu-klanceng'         => 'minuman',
            'kopi-arabika-gayo'     => 'minuman',
            'kopi-robusta-lampung'  => 'minuman',
            
            // Sembako
            'paket-sayur-sehat'     => 'sembako',
            'bibit-tomat-organik'   => 'sembako',
            
            // Fashion / Kerajinan
            'tas-rajut-cantik'      => 'fashion',
            'syal-rajut-hangat'     => 'fashion',
            'batik-tulis-parang'    => 'kerajinan',
            'batik-cap-sogan'       => 'kerajinan',
            
            // Pertanian / Produk Lokal
            'hiasan-dinding-jati'   => 'produk-lokal',
            'kotak-kayu-ukir'       => 'kerajinan',
            
            // Elektronik
            'kabel-usb-tahan-lama'  => 'elektronik',
            'charger-fast-20w'      => 'elektronik',
        ];

        // Dapatkan ID kategori
        $categories = DB::table('categories')->pluck('id', 'slug')->toArray();

        foreach ($productCategoryMap as $keyword => $categorySlug) {
            if (isset($categories[$categorySlug])) {
                DB::table('products')
                    ->where('slug', 'LIKE', '%' . $keyword . '%')
                    ->update(['category_id' => $categories[$categorySlug]]);
            }
        }
    }

    public function down(): void
    {
        DB::table('products')->whereNotNull('category_id')->update(['category_id' => null]);
    }
};