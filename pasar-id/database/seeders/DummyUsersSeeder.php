<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DummyUsersSeeder extends Seeder
{
    /**
     * Data dummy pembeli & pemilik UMKM (seller + store + produk).
     * Dijalankan dengan: php artisan db:seed --class=DummyUsersSeeder
     */
    public function run(): void
    {
        $catIds = Category::pluck('id', 'slug')->toArray();

        // -------------------- PEMBELI --------------------
        $buyers = [
            ['Budi Santoso', 'Jakarta', 'DKI Jakarta'],
            ['Siti Rahayu', 'Bandung', 'Jawa Barat'],
            ['Agus Pratama', 'Surabaya', 'Jawa Timur'],
            ['Dewi Lestari', 'Yogyakarta', 'DI Yogyakarta'],
            ['Rizki Firmansyah', 'Medan', 'Sumatera Utara'],
            ['Maya Sari', 'Semarang', 'Jawa Tengah'],
            ['Joko Susilo', 'Solo', 'Jawa Tengah'],
            ['Fitriani', 'Makassar', 'Sulawesi Selatan'],
            ['Hendra Gunawan', 'Palembang', 'Sumatera Selatan'],
            ['Nur Aisyah', 'Denpasar', 'Bali'],
        ];

        foreach ($buyers as $i => [$name, $city, $province]) {
            $email = 'pembeli' . ($i + 1) . '@pasar.id';
            User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $name,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'buyer',
                    'email_verified_at' => now(),
                ]
            );
        }

        $this->command->info('Pembeli dummy: ' . count($buyers) . ' akun.');

        // -------------------- PEMILIK UMKM --------------------
        // [nama toko, slug kategori, kota, provinsi, nama pemilik, [nama produk]]
        $umkms = [
            ['Toko Keripik Bu Fatimah', 'makanan', 'Bandung', 'Jawa Barat', 'Fatimah', ['Keripik Singkong Pedas', 'Keripik Pisang Cokelat']],
            ['Sanggar Batik Prabu', 'fashion', 'Yogyakarta', 'DI Yogyakarta', 'Prabu Santosa', ['Batik Tulis Parang', 'Batik Cap Sogan']],
            ['Kopi Senja', 'minuman', 'Medan', 'Sumatera Utara', 'Rina Marlina', ['Kopi Arabika Gayo', 'Kopi Robusta Lampung']],
            ['Rajut Cinta', 'fashion', 'Bandung', 'Jawa Barat', 'Sinta Wulandari', ['Tas Rajut Cantik', 'Syal Rajut Hangat']],
            ['Madu Asli Bumi', 'makanan', 'Solo', 'Jawa Tengah', 'Slamet Riyadi', ['Madu Murni 250ml', 'Madu Klanceng 500ml']],
            ['Souvenir Kayu Jati', 'kerajinan', 'Semarang', 'Jawa Tengah', 'Bambang Wijaya', ['Hiasan Dinding Jati', 'Kotak Kayu Ukir']],
            ['Sayur Organik Tani Makmur', 'pertanian', 'Lembang', 'Jawa Barat', 'Ustadz Yanuar', ['Paket Sayur Sehat', 'Bibit Tomat Organik']],
            ['Elektronik Rimba', 'elektronik', 'Jakarta', 'DKI Jakarta', 'Rimba Saputra', ['Kabel USB Tahan Lama', 'Charger Fast 20W']],
        ];

        $pendingIndex = 6; // index ke-7 (Sayur Organik) dibuat pending, sisanya active

        foreach ($umkms as $i => [$storeName, $catSlug, $city, $province, $ownerName, $products]) {
            $email = 'umkm' . ($i + 1) . '@pasar.id';
            $status = ($i === $pendingIndex) ? 'pending' : 'active';

            $user = User::updateOrCreate(
                ['email' => $email],
                [
                    'name' => $ownerName,
                    'email' => $email,
                    'password' => Hash::make('password'),
                    'role' => 'seller',
                    'email_verified_at' => now(),
                ]
            );

            $store = Store::updateOrCreate(
                ['user_id' => $user->id],
                [
                    'user_id' => $user->id,
                    'category_id' => $catIds[$catSlug] ?? null,
                    'store_name' => $storeName,
                    'slug' => 'toko-' . Str::slug($storeName),
                    'description' => 'Toko ' . strtolower($storeName) . ' menjual produk UMKM lokal berkualitas asli ' . $city . '.',
                    'phone' => '08' . rand(1000000000, 9999999999),
                    'address' => 'Jl. ' . $storeName . ' No. ' . rand(1, 99),
                    'city' => $city,
                    'province' => $province,
                    'status' => $status,
                ]
            );

            foreach ($products as $pname) {
                $slug = Str::slug($pname . '-' . $store->id);
                $thumb = 'products/' . Str::slug($pname) . '.svg';

                $product = Product::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'store_id' => $store->id,
                        'category_id' => $catIds[$catSlug] ?? null,
                        'name' => $pname,
                        'slug' => $slug,
                        'description' => 'Produk ' . strtolower($pname) . ' khas lokal dari ' . $store->store_name . '.',
                        'price' => rand(15000, 300000),
                        'stock' => rand(5, 60),
                        'thumbnail' => $thumb,
                        'status' => 'active',
                    ]
                );

                if ($product->images()->count() === 0) {
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $thumb,
                        'sort_order' => 0,
                    ]);
                }

                // Pastikan file placeholder SVG-nya ada di disk (audit fix: gambar
                // sebelumnya cuma rekam jejak DB, filenya tidak pernah dibuat).
                $this->ensureProductPlaceholder($thumb, $catIds[$catSlug] ?? null, $pname);
            }
        }

        $this->command->info('Pemilik UMKM dummy: ' . count($umkms) . ' toko (' . (count($umkms) - 1) . ' active, 1 pending).');
    }

    /**
     * Buat file placeholder SVG di storage/app/public/products bila belum ada.
     * Warna dasar mengikuti kategori supaya konsisten dengan brand.
     */
    private function ensureProductPlaceholder(string $relativePath, ?int $categoryId, string $label): void
    {
        $catColors = [
            'makanan'         => '#b45309',
            'minuman'         => '#0e7490',
            'sembako'         => '#4d7c0f',
            'fashion'         => '#7c3aed',
            'kerajinan'       => '#be123c',
            'pertanian'       => '#15803d',
            'elektronik'      => '#1d4ed8',
            'kebutuhan-rumah' => '#a16207',
        ];
        $default = '#154212';

        $slug = $categoryId ? \App\Models\Category::find($categoryId)?->slug : null;
        $color = $catColors[$slug] ?? $default;

        $dir = storage_path('app/public/products');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $file = $dir . '/' . basename($relativePath);
        if (is_file($file)) {
            return; // jangan timpa kalau sudah ada
        }

        $words = explode(' ', $label);
        $lines = [];
        $cur = '';
        foreach ($words as $w) {
            if ($cur !== '' && strlen($cur . ' ' . $w) > 18) {
                $lines[] = $cur;
                $cur = $w;
            } else {
                $cur = $cur === '' ? $w : $cur . ' ' . $w;
            }
        }
        if ($cur !== '') {
            $lines[] = $cur;
        }
        $lines = array_slice($lines, 0, 3);
        $startY = 300 - (count($lines) - 1) * 28;
        $tspan = '';
        foreach ($lines as $i => $ln) {
            $tspan .= '<tspan x="300" y="' . ($startY + $i * 56) . '">' . htmlspecialchars($ln, ENT_XML1) . '</tspan>';
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600">'
            . '<rect width="600" height="600" fill="' . $color . '"/>'
            . '<circle cx="300" cy="200" r="150" fill="#ffffff" opacity="0.10"/>'
            . '<text text-anchor="middle" font-family="Segoe UI, Helvetica, Arial, sans-serif" font-size="36" font-weight="700" fill="#ffffff">' . $tspan . '</text>'
            . '<text x="300" y="545" text-anchor="middle" font-family="Segoe UI, Helvetica, Arial, sans-serif" font-size="20" fill="#ffffff" opacity="0.85">Pasar.ID</text>'
            . '</svg>';

        file_put_contents($file, $svg);
    }
}
