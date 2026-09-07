<?php

// Simpan gambar yg sudah di-generate (URL di $MAP) ke storage/app/public,
// rename ke .png, hapus placeholder .svg lama, dan update DB
// (product.thumbnail -> .png, store.logo -> .png). Jalankan via tinker.

$base = 'https://v3b.fal.media/files/b/';

$productMap = [
    1  => '0aa88b42/Vw5xHt5FcLzUlc2mcp7iX_uLNCAgTq.png',
    2  => '0aa88b42/GEfhOFYfg43tSKGWpGxg0_9NSdLPMd.png',
    3  => '0aa88b42/wtniqH8lsmcc-rcsquWmU_ctqsxbcX.png',
    4  => '0aa88b42/dGb6AzBFEAfLRYkzyVKF8_TsqzjXVP.png',
    5  => '0aa88b42/lRIl5kLsWgrvYcOn2YSbu_7yrdzB25.png',
    6  => '0aa88b42/iIdeq073YSKZ6E-jUwI61_ZnsX8fEg.png',
    7  => '0aa88b42/8vUhVWZREbQ9QU_Vs-zTF_GAi5Mhow.png',
    8  => '0aa88b42/pYqFpYts7ds56fT54RJlF_cq5C4NYN.png',
    9  => '0aa88b42/MglNYle07ovlcczEOLkaN_WBKVWWOF.png',
    10 => '0aa88b42/7AWzAq9BWd6sKR1EXCNON_KOewX6P6.png',
    11 => '0aa88b43/sM3F94f5eVPflwxvyIlTh_zLVHiWqW.png',
    12 => '0aa88b43/iR8yk1iOPvzLzm7eXEPXM_iUp4gvgd.png',
    13 => '0aa88b5b/KKADZfMcyYv-iHjEt3wmw_vZCUSy1S.png',
    14 => '0aa88b44/CdEhMf0jahEvmC7q58N3c_DRcSl73R.png',
    15 => '0aa88b44/NfAKDgLwvm6XKDebgu_Eu_tJRhppVx.png',
    16 => '0aa88b44/GZU2Fz6zqXt49sZ2AjphV_4DheICTv.png',
    17 => '0aa88b45/UAv6PNeNoE9vcmXXTaDq0_7dh08Kws.png',
    18 => '0aa88b45/4lgcQNpgnEF8ePWbPcQTI_UX2aL0tT.png',
    19 => '0aa88b45/yNsGpJDsak4vzqspQzaiu_vvfDTsHF.png',
    20 => '0aa88b45/SLJ1k2ZJPKXSOfaptMxhi_R9xi8Cw0.png',
    21 => '0aa88b45/1G1wHo4OsLmZlsD8dqf7r_iPrzetbZ.png',
    22 => '0aa88b45/KKtpA3XgvXX-9D8L79zs3_Qh4lmIfP.png',
];

$storeMap = [
    1  => '0aa88b49/0vkH0h2XMymwZ9KtNSAEo_cGReKV85.png',
    5  => '0aa88b48/WcQgDJylEop2A1zV_ktll_jUFic8wQ.png',
    6  => '0aa88b48/iEPLpcLct0_YaQCY5fTLV_XwjUmItC.png',
    7  => '0aa88b48/bbxqpThf74aXjtgHQ6RWq_IrnTeLSM.png',
    8  => '0aa88b48/mJ21eadHKtlUFUqVqtIug_owMU45vI.png',
    9  => '0aa88b49/fppW2RpvLqMa4dfkuZHvm_5ymufDKQ.png',
    10 => '0aa88b49/jfSkNevZ7N14bX5Bp5-MU_aDOZcuIO.png',
    11 => '0aa88b49/YpHEA67vVHAzY8h8ehTai_DuDcOzaB.png',
    12 => '0aa88b49/g-rF7WV3jJw-fV2LmZWlA_hn6T3rzH.png',
];

$client = new \GuzzleHttp\Client(['timeout' => 60, 'verify' => false]);
$dirProducts = storage_path('app/public/products');
$dirLogos = storage_path('app/public/stores/logos');
if (! is_dir($dirProducts)) mkdir($dirProducts, 0755, true);
if (! is_dir($dirLogos)) mkdir($dirLogos, 0755, true);

// Bersihkan placeholder .svg lama agar tidak tumpang tindih
foreach (glob($dirProducts . '/*.svg') as $f) { unlink($f); }

$ok = 0;
foreach ($productMap as $pid => $path) {
    $p = \App\Models\Product::find($pid);
    if (! $p) { echo "SKIP product $pid (not found)\n"; continue; }
    // target selalu .png, terlepas dari ekstensi lama
    $targetRel = 'products/' . pathinfo($p->slug, PATHINFO_FILENAME) . '.png';
    $target = $dirProducts . '/' . basename($targetRel);
    $body = $client->get($base . $path)->getBody()->getContents();
    file_put_contents($target, $body);

    // update juga ProductImage kalau ada
    foreach ($p->images as $img) {
        $img->image_path = $targetRel;
        $img->save();
    }
    $p->thumbnail = $targetRel;
    $p->save();
    $ok++;
}
echo "Products saved+linked (.png): $ok\n";

$okS = 0;
foreach ($storeMap as $sid => $path) {
    $s = \App\Models\Store::find($sid);
    if (! $s) { echo "SKIP store $sid (not found)\n"; continue; }
    $file = 'logo-' . $s->id . '.png';
    $target = $dirLogos . '/' . $file;
    $body = $client->get($base . $path)->getBody()->getContents();
    file_put_contents($target, $body);
    $s->logo = 'stores/logos/' . $file;
    $s->save();
    $okS++;
}
echo "Store logos saved+linked (.png): $okS\n";
