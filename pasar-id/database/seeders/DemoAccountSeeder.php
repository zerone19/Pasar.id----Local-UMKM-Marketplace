<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ProductImage;
use App\Models\Store;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DemoAccountSeeder extends Seeder
{
    public function run(): void
    {
        // Demo accounts for each role
        User::updateOrCreate(
            ['email' => 'admin@pasar.id'],
            [
                'name' => 'Admin Pasar',
                'email' => 'admin@pasar.id',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'seller@pasar.id'],
            [
                'name' => 'Seller Demo',
                'email' => 'seller@pasar.id',
                'password' => Hash::make('password'),
                'role' => 'seller',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'buyer@pasar.id'],
            [
                'name' => 'Buyer Demo',
                'email' => 'buyer@pasar.id',
                'password' => Hash::make('password'),
                'role' => 'buyer',
                'email_verified_at' => now(),
            ]
        );

        // Seller + Store + Products
        $seller = User::where('email', 'seller@pasar.id')->first();
        if ($seller) {
            $store = Store::updateOrCreate(
                ['user_id' => $seller->id],
                [
                    'user_id' => $seller->id,
                    'store_name' => 'Toko Seller Demo',
                    'slug' => 'toko-seller-demo',
                    'description' => 'Toko demo untuk menjual produk UMKM lokal.',
                    'city' => 'Jakarta',
                    'province' => 'DKI Jakarta',
                    'status' => 'active',
                ]
            );

            $samples = [
                ['Tas Rajut Handmade', 'Fashion', 75000, 10],
                ['Kopi Arabika Lokal', 'Minuman', 45000, 25],
                ['Keripik Singkong', 'Makanan', 20000, 50],
                ['Batik Tulis', 'Fashion', 250000, 5],
                ['Madu Murni', 'Makanan', 90000, 12],
                ['Sambal Rumahan', 'Makanan', 35000, 30],
            ];

            foreach ($samples as $i => [$name, $catName, $price, $stock]) {
                $slug = \Illuminate\Support\Str::slug($name . '-' . $store->id);
                $thumb = 'products/' . \Illuminate\Support\Str::slug($name) . '.svg';

                $product = Product::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'store_id' => $store->id,
                        'category_id' => \App\Models\Category::where('slug', \Illuminate\Support\Str::slug($catName))->first()?->id,
                        'name' => $name,
                        'slug' => $slug,
                        'description' => 'Produk ' . strtolower($name) . ' khas lokal dari ' . $store->store_name . '.',
                        'price' => $price,
                        'stock' => $stock,
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
            }

            // Demo order dari buyer
            $buyer = User::where('email', 'buyer@pasar.id')->first();
            $firstProduct = $store->products()->where('status', 'active')->first();
            if ($buyer && $firstProduct) {
                $order = Order::updateOrCreate(
                    ['order_number' => 'ORD-DEMO-0001'],
                    [
                        'buyer_id' => $buyer->id,
                        'store_id' => $store->id,
                        'order_number' => 'ORD-DEMO-0001',
                        'address' => 'Jl. Contoh No. 1, Jakarta',
                        'phone' => '08123456789',
                        'subtotal' => $firstProduct->price * 2,
                        'shipping_cost' => 0,
                        'total' => $firstProduct->price * 2,
                        'payment_method' => 'cod',
                        'payment_status' => 'unpaid',
                        'order_status' => 'pending',
                        'notes' => 'Pesanan demo',
                    ]
                );

                OrderItem::updateOrCreate(
                    ['order_id' => $order->id, 'product_id' => $firstProduct->id],
                    [
                        'order_id' => $order->id,
                        'product_id' => $firstProduct->id,
                        'store_id' => $store->id,
                        'quantity' => 2,
                        'price' => $firstProduct->price,
                        'subtotal' => $firstProduct->price * 2,
                    ]
                );

                Payment::updateOrCreate(
                    ['order_id' => $order->id],
                    [
                        'order_id' => $order->id,
                        'method' => 'cod',
                        'status' => 'unpaid',
                        'amount' => $order->total,
                    ]
                );
            }
        }
    }
}