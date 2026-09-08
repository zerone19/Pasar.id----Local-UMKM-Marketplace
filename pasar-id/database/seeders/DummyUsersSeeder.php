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

        // -------------------- PEMBELI (10 akun) --------------------
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

        // -------------------- PEMILIK UMKM (10 toko, tiap 10+ produk) --------------------
        // Format: [nama toko, slug kategori, kota, provinsi, nama pemilik, [daftar nama produk]]
        $umkms = [
            [
                'Toko Keripik Bu Fatimah',
                'makanan',
                'Bandung',
                'Jawa Barat',
                'Fatimah',
                [
                    'Keripik Singkong Pedas',
                    'Keripik Pisang Cokelat',
                    'Keripik Kentang Keju',
                    'Keripik Tempe Goreng',
                    'Keripik Ubi Keju',
                    'Snack Mix Mania',
                    'Keripik Singkong Original',
                    'Keripik Pisang Madu',
                    'Keripik Kentang Pedas',
                    'Coklat Kacang Cekral',
                ],
            ],
            [
                'Sanggar Batik Prabu',
                'fashion',
                'Yogyakarta',
                'DI Yogyakarta',
                'Prabu Santosa',
                [
                    'Batik Tulis Parang',
                    'Batik Cap Sogan',
                    'Kain Batik Mega Mendung',
                    'Jarik Tanpa Batas',
                    'Kemeja Batik Lengan Pendek',
                    'Rok Bakul',
                    'Selendang Batik',
                    'Tas Anyaman Rotan',
                    'Topi Batik',
                    'Sashiko Kain',
                ],
            ],
            [
                'Kopi Senja',
                'minuman',
                'Medan',
                'Sumatera Utara',
                'Rina Marlina',
                [
                    'Kopi Arabika Gayo',
                    'Kopi Robusta Lampung',
                    'Kopi Susu Kental Manis',
                    'Kopi Tubruk Aceh',
                    'Kopi Luwak Gayo',
                    'Essens Kopi Cair',
                    'Biji Kopi Blend Specialty',
                    'Kopi Hijau Bubuk',
                    'Sirup Kopi',
                    'Kopi Instan Rasa',
                ],
            ],
            [
                'Rajut Cinta',
                'fashion',
                'Bandung',
                'Jawa Barat',
                'Sinta Wulandari',
                [
                    'Tas Rajut Cantik',
                    'Syal Rajut Hangat',
                    'Topi Rajut Rib',
                    'Tas Penyimpanan',
                    'Joki Kulit',
                    'Guling Rajut',
                    'Tas Sekolah Rajut',
                    'Pashmina Rajut',
                    'Tas Kulit Mini',
                    'Syal Polos Eksklusif',
                ],
            ],
            [
                'Madu Asli Bumi',
                'makanan',
                'Solo',
                'Jawa Tengah',
                'Slamet Riyadi',
                [
                    'Madu Murni 250ml',
                    'Madu Klanceng 500ml',
                    'Madu Hitam Asli',
                    'Perlehan Madu',
                    'Madu Campur Herbal',
                    'Madu Ubti',
                    'Krupuk Madu',
                    'Madu Cair',
                    'Madu Batu',
                    'Madu Multi Flora',
                ],
            ],
            [
                'Souvenir Kayu Jati',
                'kerajinan',
                'Semarang',
                'Jawa Tengah',
                'Bambang Wijaya',
                [
                    'Hiasan Dinding Jati',
                    'Kotak Kayu Ukir',
                    'Meja Kayu Jati',
                    'Sendok Kayu Jati',
                    'Garpu Kayu Jati',
                    'Piring Kayu Jati',
                    'Cermin Kayu Jati',
                    'Laci Kayu Jati',
                    'Tempat Pensil Kayu',
                    'Boneka Kayu Tradisional',
                ],
            ],
            [
                'Sayur Organik Tani Makmur',
                'pertanian',
                'Lembang',
                'Jawa Barat',
                'Ustadz Yanuar',
                [
                    'Paket Sayur Sehat',
                    'Bibit Tomat Organik',
                    'Bibit Cabai Hijau',
                    'Bibit Selada',
                    'Paket Herbal',
                    'Sayur Mayur Pot',
                    'Bunga Matahari',
                    'Bibit Kangkung',
                    'Paket Sayur Ijo',
                    'Bibit Sereh',
                ],
            ],
            [
                'Elektronik Rimba',
                'elektronik',
                'Jakarta',
                'DKI Jakarta',
                'Rimba Saputra',
                [
                    'Kabel USB Tahan Lama',
                    'Charger Fast 20W',
                    'Power Bank 10000mAh',
                    'Earphone Bluetooth',
                    'Lampu LED',
                    'Speaker Mini',
                    'Kabel OTG',
                    'Charger Mobil',
                    'Flashdisk 32GB',
                    'Baterai Cadangan',
                ],
            ],
            [
                'Kue & Pastri Enak',
                'makanan',
                'Bandung',
                'Jawa Barat',
                'Wulan Sari',
                [
                    'Kue Lapis Legit',
                    'Pastri Coklat',
                    'Donat Glase',
                    'Kue Cubit Mini',
                    'Kue Klepon',
                    'Kue Putu Mayang',
                    'Roti Sobek Coklat',
                    'Kue Mangkok',
                    'Brownies',
                    'Kue Karangan',
                ],
            ],
            [
                'Minuman Segar Nusantara',
                'minuman',
                'Surabaya',
                'Jawa Timur',
                'Dwi Handoko',
                [
                    'Es Teh Manis',
                    'Es Jeruk Segar',
                    'Es Kelapa Muda',
                    'Jus Mangga',
                    'Jus Alpukat',
                    'Kopi Susu Gula',
                    'Sirup Jeruk',
                    'Air Mineral Kemasan',
                    'Minuman Kelapa',
                    'Soda Lemon',
                ],
            ],
        ];

        // Index ke-6 (Sayur Organik) sengaja pending, sisanya active
        $pendingIndex = 6;

        foreach ($umkms as $i => $data) {
            [$storeName, $catSlug, $city, $province, $ownerName, $products] = $data;
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

                $this->ensureProductPlaceholder($thumb, $catIds[$catSlug] ?? null, $pname);
            }
        }

        $this->command->info('Pemilik UMKM dummy: ' . count($umkms) . ' toko (' . (count($umkms) - 1) . ' active, 1 pending).');
        $this->command->info('Total produk dummy: ' . array_sum(array_map(fn($u) => count($u[5]), $umkms)));
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