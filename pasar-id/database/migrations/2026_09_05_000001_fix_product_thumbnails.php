<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Mapping slug-to-png — berdasarkan file .png yang benar di storage/app/public/products/
        $thumbnailMap = [
            'keripik-singkong-pedas'        => 'products/keripik-singkong-pedas-5.png',
            'keripik-pisang-cokelat'         => 'products/keripik-pisang-cokelat-5.png',
            'batik-tulis-parang'             => 'products/batik-tulis-parang-6.png',
            'batik-cap-sogan'                => 'products/batik-cap-sogan-6.png',
            'kopi-arabika-gayo'              => 'products/kopi-arabika-gayo-7.png',
            'kopi-robusta-lampung'           => 'products/kopi-robusta-lampung-7.png',
            'tas-rajut-cantik'               => 'products/tas-rajut-cantik-8.png',
            'syal-rajut-hangat'              => 'products/syal-rajut-hangat-8.png',
            'madu-murni-250ml'               => 'products/madu-murni-250ml-9.png',
            'madu-klanceng-500ml'            => 'products/madu-klanceng-500ml-9.png',
            // Produk dummy tambahan di progress.md (16 produk baru)
            'keripik-singkong-pedas-1'       => 'products/keripik-singkong-1.png',
            'kopi-arabika-lokal'             => 'products/kopi-arabika-lokal-1.png',
            'madu-murni-1'                   => 'products/madu-murni-1.png',
            'paket-sayur-sehat'              => 'products/paket-sayur-sehat-11.png',
            'bibit-tomat-organik'            => 'products/bibit-tomat-organik-11.png',
            'charger-fast-20w'               => 'products/charger-fast-20w-12.png',
            'kabel-usb-tahan-lama'           => 'products/kabel-usb-tahan-lama-12.png',
            'hiasan-dinding-jati'            => 'products/hiasan-dinding-jati-10.png',
            'kotak-kayu-ukir'                => 'products/kotak-kayu-ukir-10.png',
            'tas-rajut-handmade'             => 'products/tas-rajut-handmade-1.png',
            'sambal-rumahan'                 => 'products/sambal-rumahan-1.png',
            'batik-tulis-1'                  => 'products/batik-tulis-1.png',
        ];

        // Update products table — cari berdasarkan slug
        foreach ($thumbnailMap as $slug => $pngPath) {
            DB::table('products')
                ->where('slug', 'LIKE', $slug . '%')
                ->orWhere('slug', 'LIKE', '%' . $slug . '%')
                ->update(['thumbnail' => $pngPath]);
        }

        // Update products where thumbnail ends with .svg but not in map — set to a default placeholder
        // Actually, let's also check product_images table
        $products = DB::table('products')->get();
        foreach ($products as $product) {
            $slug = $product->slug;
            // Try matching by slug pattern
            $matched = false;
            foreach ($thumbnailMap as $key => $pngPath) {
                if (strpos($slug, $key) !== false) {
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['thumbnail' => $pngPath]);
                    $matched = true;
                    break;
                }
            }
            
            // Jika tidak match dan masih .svg, coba cari file .png dengan slug dasar
            if (!$matched && strpos($product->thumbnail, '.svg') !== false) {
                $baseSlug = str_replace('.svg', '', basename(str_replace('products/', '', $product->thumbnail)));
                // Cek apakah file .png ada dengan pola berbeda
                $pngFiles = glob('/var/www/html/storage/app/public/products/' . $baseSlug . '*.png');
                if (!empty($pngFiles)) {
                    $pngFile = basename($pngFiles[0]);
                    DB::table('products')
                        ->where('id', $product->id)
                        ->update(['thumbnail' => 'products/' . $pngFile]);
                }
            }
        }
    }

    public function down(): void
    {
        // Tidak perlu revert — ini hanya perbaikan data
    }
};
