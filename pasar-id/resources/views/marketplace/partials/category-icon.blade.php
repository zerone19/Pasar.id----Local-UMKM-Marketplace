@php
    // Pilih ikon berdasarkan slug/nama kategori (fallback: box)
    $key = strtolower($category->slug ?? $category->name);
    $icons = [
        'sayur'        => '<path d="M12 21c5-2 8-6 8-11V5l-8 2-8-2v5c0 5 3 9 8 11Z" stroke-linejoin="round"/><path d="M12 9c0-2 1-3 3-3M12 13c0-2-1-3-3-3" stroke-linecap="round"/>',
        'buah'         => '<path d="M12 7c0-3 2-5 5-4-1 3-2 4-5 4ZM12 7c-1 4-3 6-6 6 0-4 3-7 6-6Z" stroke-linejoin="round"/><path d="M12 7v9" stroke-linecap="round"/>',
        'fashion'      => '<path d="M9 4l3 2 3-2 4 2-2 4-2-1v11H9V9L7 10 5 6Z" stroke-linejoin="round"/>',
        'elektronik'   => '<rect x="4" y="4" width="16" height="11" rx="2"/><path d="M9 19h6M12 15v4" stroke-linecap="round"/>',
        'kerajinan'    => '<circle cx="6" cy="6" r="2.4"/><circle cx="6" cy="18" r="2.4"/><path d="M8 7.4 20 17M8 16.6 20 7" stroke-linecap="round" stroke-linejoin="round"/>',
        'pertanian'    => '<path d="M12 21V10" stroke-linecap="round"/><path d="M12 12c-1-4-4-5-7-5 0 4 3 6 7 5Z" stroke-linecap="round" stroke-linejoin="round"/><path d="M12 10c1-4 4-5 7-5 0 4-3 6-7 5Z" stroke-linecap="round" stroke-linejoin="round"/>',
        'sembako'      => '<path d="M5 9h14l-1.3 10.5a1 1 0 0 1-1 .95H7.3a1 1 0 0 1-1-.95L5 9Z" stroke-linejoin="round"/><path d="M9 9c0-2.5 1.5-4 3-4s3 1.5 3 4" stroke-linecap="round"/>',
        'minuman'      => '<path d="M7 4h10l-1 15a2 2 0 0 1-2 2H10a2 2 0 0 1-2-2L7 4Z" stroke-linejoin="round"/><path d="M7 9h10" stroke-linecap="round"/>',
        'rumah'        => '<path d="M4 11l8-7 8 7M6 10v9h12v-9" stroke-linecap="round" stroke-linejoin="round"/>',
        'makanan'      => '<path d="M6 3v8a3 3 0 0 0 6 0V3M9 3v18M16 3c-1 2-1 4 0 6v12" stroke-linecap="round" stroke-linejoin="round"/>',
        'kesehatan'    => '<path d="M12 5v14M5 12h14" stroke-linecap="round"/><circle cx="12" cy="12" r="9"/>',
        'kebutuhan'    => '<path d="M4 11l8-7 8 7M6 10v9h12v-9" stroke-linecap="round" stroke-linejoin="round"/>',
    ];
    $svg = $icons[collect(array_keys($icons))->first(fn($k) => str_contains($key, $k))] ?? $icons['kerajinan'];
@endphp
<span class="grid h-14 w-14 place-items-center rounded-full bg-brand-soft/70 text-brand">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" class="h-7 w-7">{!! $svg !!}</svg>
</span>
