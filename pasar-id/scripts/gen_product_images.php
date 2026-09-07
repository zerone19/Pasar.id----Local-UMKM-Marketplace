<?php

// Generator placeholder SVG untuk SELURUH produk Pasar.ID.
// Menimpa file yang ada supaya warna placeholder konsisten dengan kategori.
// Jalankan dari dalam container:
//   docker compose exec app php artisan tinker --execute="require 'scripts/gen_product_images.php';"

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

$dir = storage_path('app/public/products');
if (! is_dir($dir)) {
    mkdir($dir, 0755, true);
}

function buildSvgGen(string $color, string $name): string
{
    $words = explode(' ', $name);
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
    $n = count($lines);
    $startY = 300 - ($n - 1) * 28;
    $tspan = '';
    foreach ($lines as $i => $ln) {
        $y = $startY + $i * 56;
        $tspan .= '<tspan x="300" y="' . $y . '">' . htmlspecialchars($ln, ENT_XML1) . '</tspan>';
    }

    return '<svg xmlns="http://www.w3.org/2000/svg" width="600" height="600" viewBox="0 0 600 600">'
        . '<rect width="600" height="600" fill="' . $color . '"/>'
        . '<circle cx="300" cy="200" r="150" fill="#ffffff" opacity="0.10"/>'
        . '<text text-anchor="middle" font-family="Segoe UI, Helvetica, Arial, sans-serif" font-size="36" font-weight="700" fill="#ffffff">' . $tspan . '</text>'
        . '<text x="300" y="545" text-anchor="middle" font-family="Segoe UI, Helvetica, Arial, sans-serif" font-size="20" fill="#ffffff" opacity="0.85">Pasar.ID</text>'
        . '</svg>';
}

$products = \App\Models\Product::whereNotNull('thumbnail')->get();
$ok = 0;
foreach ($products as $p) {
    $file = basename($p->thumbnail);
    $slug = ($p->category && $p->category->slug) ? $p->category->slug : null;
    $color = $catColors[$slug] ?? $default;
    file_put_contents($dir . '/' . $file, buildSvgGen($color, $p->name));
    $ok++;
}

echo 'Generated/overwritten: ' . $ok . ' product images' . PHP_EOL;
