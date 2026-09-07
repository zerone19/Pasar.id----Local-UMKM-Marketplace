<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Assign logo to each store. Logo files are named logo-1.png through logo-12.png
        // but only logo-1, 5, 6, 7, 8, 9, 10, 11, 12 exist.
        $logoMap = [
            1 => 'stores/logos/logo-1.png',
            2 => 'stores/logos/logo-10.png',
            3 => 'stores/logos/logo-11.png',
            4 => 'stores/logos/logo-12.png',
            5 => 'stores/logos/logo-5.png',
            6 => 'stores/logos/logo-6.png',
            7 => 'stores/logos/logo-7.png',
            8 => 'stores/logos/logo-8.png',
        ];

        foreach ($logoMap as $storeId => $logoPath) {
            DB::table('stores')
                ->where('id', $storeId)
                ->update(['logo' => $logoPath]);
        }
    }

    public function down(): void
    {
        DB::table('stores')->update(['logo' => null]);
    }
};