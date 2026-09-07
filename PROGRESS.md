# Progress Project Pasar.ID

> Marketplace UMKM Lokal — Laravel 13 + Docker + MySQL + Tailwind (Breeze)
> Dikelola oleh: Ascjul Zerone (Master) · Dibantu oleh: Nera Everis

---

## 📌 Status Terkini (2026-08-31)

**MVP SELESAI** — 7/7 sprint selesai & terverifikasi (35 test lulus).
**UI Marketplace** sudah di-polish mengikuti design system Stitch (warna, font, logo & foto asli).
**Sinkronisasi Desain Stitch pt2 SELESAI** — menu kategori mandiri, layout seller seragam
(sidebar + dashboard + manajemen produk + riwayat transaksi), halaman Daftar Mitra UMKM
(`/mitra`), dan auth pages pembeli split-layout "Gotong Royong". Lihat section
"🎨 Sinkronisasi Desain Stitch pt2" di bawah.

**SESI LANJUTAN (2026-08-31, same day)**: ditambahkan **data dummy** (10 pembeli +
8 pemilik UMKM via `DummyUsersSeeder`) dan **aset visual asli** — 22 foto produk
+ 9 logo toko AI-generated (.png), menggantikan placeholder. Audit gambar produk
juga menemukan & memperbaiki bug seeder (path DB vs file disk tidak konsisten).
Lihat section "📊 Data Dummy & Aset Visual" di bawah.

---

## 🗂️ Struktur Project

```
c:\project saya\pasar id\
├── docker-compose.yml          # app + web(nginx) + db(mysql) + phpmyadmin
├── docker-compose.prod.yml     # konfigurasi production
├── Dockerfile                  # image php-fpm + permission storage (dev)
├── backup-db.sh               # backup mysqldump ke ./backups/
├── .dockerignore
├── pasar-id/                  # source code Laravel
│   ├── app/Models/            # User, Profile, Category, Store, Product,
│   │                         #   ProductImage, Cart, CartItem, Order,
│   │                         #   OrderItem, Payment
│   ├── app/Http/Controllers/  # Auth, Buyer, Seller, Admin
│   ├── app/Http/Middleware/   # RoleMiddleware (role: buyer/seller/admin)
│   ├── database/migrations/   # 2026_08_28_* (marketplace, cart, order)
│   ├── database/seeders/      # DatabaseSeeder (demo data)
│   ├── resources/views/       # layouts, marketplace, seller, admin
│   ├── routes/web.php         # semua route
│   └── public/assets/img/     # logo-pasar-id.png, hero-pasar.png
└── design-references/
    ├── stitch_pasar.id_local_digital_marketplace/  # desain referensi pt1
    └── stitch_pasar.id_local_digital_marketplace pt 2/  # desain referensi pt2
```

---

## ✅ Sprint 1–7 (MVP)

| Sprint | Fokus | Status | Catatan |
|--------|-------|--------|---------|
| 1 | Infrastruktur Docker (app/web/db/phpmyadmin) | ✅ | Container running, key:generate, migrate, npm build |
| 2 | Auth & Role (buyer/seller/admin) | ✅ | RoleMiddleware, redirect dashboard per role |
| 3 | Marketplace (kategori, toko, produk, browse) | ✅ | slug route key, 8 kategori, 6 produk demo |
| 4 | Cart & Checkout (per-toko order) | ✅ | kurangi stok, payment COD/transfer |
| 5 | Seller (toko + produk + order) | ✅ | seller CRUD, moderate status |
| 6 | Admin (user/store/category/product/order) | ✅ | approve toko, CRUD kategori, moderasi |
| 7 | Testing & Deploy | ✅ | 35 test lulus, docker-compose.prod, backup script |

---

## 🧪 Testing

- **35 test passed, 92 assertions** (RefreshDatabase — DB terpisah dari seed produksi).
- File: `tests/Feature/RoleAuthorizationTest.php`, `CartCheckoutTest.php`,
  `SellerFlowTest.php`, `AdminFlowTest.php` + auth tests dari Breeze.

---

## 🎨 UI / UX (Opsi A — ikut desain Stitch)

### Design Tokens (dari `DESIGN.md`)
- **Warna**: Forest Green `#154212` (primary), `#2d5a27` (container),
  `#bcf0ae` (soft accent), Leaf `#456800`, Burlap `#52330f`, Cream `#fbf9f4`.
- **Font**: Be Vietnam Pro (headline/body) + Work Sans (label) via Google Fonts.
- **Komponen**: `.btn-primary`, `.btn-outline`, `.btn-leaf`, `.card`,
  `.chip`, `.input-field`, `.label` (di `tailwind.config.js` + `app.css`).

### Aset dari folder Stitch (yang layak dipakai)
- `logo-pasar-id.png` → logo PNG asli (navbar + footer).
- `hero-pasar.png` → foto pasar tradisional murni (crop bersih dari `beranda/screen.png`).

> **Catatan jujur**: Foto produk di mockup Stitch menyatu dengan teks UI
> (bukan aset terpisah), jadi tidak diekstrak. Produk tetap pakai
> placeholder bertema anyaman.

### Yang sudah dikerjakan
- [x] Tailwind theme (warna brand + font + radius + shadow leaf).
- [x] Navbar sticky hijau + logo asli + search + cart badge (count dari DB).
- [x] Footer cream + link.
- [x] Home: hero split (foto pasar + teks), Kategori Pilihan (icon variatif),
      Produk Unggulan, Produk Terbaru, Toko Populer.
- [x] Product card: gambar 1:1, chip kategori, harga brand, badge "Habis".
- [x] Detail produk, Cart, Checkout, Orders, Order ikut desain.
- [x] Category & Store view dengan breadcrumb.
- [x] Icon kategori beda per kategori (partial `category-icon.blade.php`).
- [x] Hapus carousel duplikat (Master minta hanya hero).

---

## 🎨 Sinkronisasi Desain Stitch pt2 (2026-08-31)

Folder `design-references/stitch_pasar.id_local_digital_marketplace pt 2/` diekstrak dari
`stitch_pasar.id_local_digital_marketplace pt 2.zip` (6 halaman + `DESIGN.md` Material 3).
Disinkronkan ke project **tanpa menyalin CDN Tailwind/Material Symbols** — menggunakan
design token app (`.card`, `.btn-primary`, `.input-field`, warna brand) + inline SVG agar
konsisten dan tidak depend CSP/CDN.

### Yang sudah dikerjakan (pt2)
- [x] **Menu Kategori mandiri** — dropdown Alpine.js di navbar + halaman index `/categories`
      (grid semua kategori + ikon + jumlah produk). Route `categories.index` baru.
- [x] **Layout Seller seragam (opsi b)** — `layouts/seller.blade.php` + component
      `SellerLayout`: sidebar kiri + topbar mobile. Dipakai di dashboard, produk, pesanan,
      detail pesanan, profil toko, buat/edit produk, no-store.
- [x] **Dashboard & Manajemen Produk Seller** — stat cards + recent orders (data asli,
      tanpa dummy chart karena app belum punya tracking pengunjung).
- [x] **Riwayat Transaksi Penjual (`/seller/orders`)** — upgrade jadi tabel: filter status
      + search, badge status berwarna, avatar inisial, pagination.
- [x] **Daftar Mitra UMKM (`/mitra`)** — halaman register seller khusus (split-screen
      "Bergabung Bersama Kami"): bikin `User` (role=seller) + `Store` draft otomatis
      (status=pending). Butuh migrasi `category_id` di tabel `stores`.
- [x] **Auth pages pembeli (`/login`, `/register`)** — split-layout "Gotong Royong",
      `layouts/guest` pakai font Be Vietnam Pro + background cream. Link ke `/mitra`.

### File yang diubah/dibuat
- `routes/web.php` — route `/categories`, `/mitra`.
- `app/Http/Controllers/Buyer/ProductController.php` — method `categories()`.
- `app/Http/Controllers/Seller/OrderController.php` — filter status + search.
- `app/Http/Controllers/Auth/MitraController.php` (baru).
- `app/Providers/AppServiceProvider.php` — view composer navbar kategori.
- `app/Models/Store.php`, `User.php` — fillable `category_id` + relasi `store()`.
- `database/migrations/2026_08_31_065751_add_category_id_to_stores_table.php` (baru).
- `resources/views/marketplace/categories.blade.php` (baru), `partials/navbar.blade.php`.
- `resources/views/layouts/seller.blade.php` (baru), `app/View/Components/SellerLayout.php` (baru).
- `resources/views/seller/*` (dashboard, products, orders, order, store-edit, product-create/edit, no-store).
- `resources/views/auth/mitra.blade.php` (baru), `login.blade.php`, `register.blade.php`, `layouts/guest.blade.php`.

### Catatan
- Verifikasi: container up, `/`, `/categories`, `/mitra`, `/login`, `/register`,
  `/seller/dashboard`, `/seller/products`, `/seller/orders` → HTTP 200.
- Flow `/mitra` diuji: user seller + store draft kebuat, redirect ke dashboard seller.
- Test user (`testmitra`, `tinkermitra`) sudah dibersihkan.
- Login seller test: `seller@pasar.id` / `password` (dari sesi testing).

---

## 📊 Data Dummy & Aset Visual (2026-08-31, sesi lanjutan)

### Data Dummy (`DummyUsersSeeder`)
File baru: `database/seeders/DummyUsersSeeder.php` (jalankan:
`docker compose exec app php artisan db:seed --class=DummyUsersSeeder`).
Pakai `updateOrCreate` → aman dijalankan berkali-kali (tidak duplikat).

- **10 pembeli** — `users.role=buyer`, email `pembeli1..10@pasar.id`, nama + kota asal Indonesia.
- **8 pemilik UMKM** — `users.role=seller` (`umkm1..8@pasar.id`) + 1 `stores` per user
  (7 active, 1 pending: "Sayur Organik Tani Makmur" sengaja pending untuk contoh moderasi admin).
  Tiap toko punya 2 produk (total 16 produk baru) dengan kategori yang nyambung.
- Password semua akun dummy: `password`.
- Total setelah seeder awal: 10 pembeli + 8 seller (termasuk `seller@pasar.id` demo) +
  9 toko + 22 produk (16 dummy baru + 6 demo awal).

### ASET VISUAL ASLI (AI-generated)
- **22 foto produk** (.png, ~1–1.9 MB masing-masing) → `storage/app/public/products/<slug>.png`.
- **9 logo toko** (emblem lingkaran per brand) → `storage/app/public/stores/logos/logo-<id>.png`.
- DB di-update: `product.thumbnail` → `products/<slug>.png`,
  `product_images.image_path` ikut diubah, `store.logo` → `stores/logos/logo-<id>.png`.
- Logo toko sudah kepakai di sidebar seller (`layouts/seller.blade.php:20`).
- `store.banner` **tidak** dibuat karena tidak dipakai di view manapun.

### Bug yang ditemukan & diperbaiki (audit gambar)
|| # | Severity | Bug | Fix |
||---|----------|-----|-----|
|| 1 | HIGH | Seeder hanya menulis path `thumbnail`/`image_path` ke DB, tapi **tidak pernah membuat file-nya** → 16 produk dummy broken image | Generator placeholder SVG per-kategori (`scripts/gen_product_images.php`) + method `ensureProductPlaceholder()` di seeder |
|| 2 | MEDIUM | 6 file .svg placeholder lama warnanya statis ungu, tidak sesuai kategori | Ditimpa warna per kategori (makanan coklat, minuman cyan, dst) |
|| 3 | HIGH | Saat simpan foto PNG, DB masih nyebut `.svg` → foto baru tidak kepakai (view tetap nyampilkan placeholder lama) | Samakan ekstensi `.png` di `product.thumbnail` + `product_images` + hapus sisa `.svg` |

### Verifikasi
- HTTP lewat web (`asset('storage/...')`): produk & logo → **200** ✔
- File size normal (bukan 0 byte) ✔
- Sisa `.svg` placeholder: **0** ✔
- DB path sudah `.png` ✔

### Perbaikan Gambar Produk & Logo Toko (2026-09-02)
**Masalah:** Database masih menyimpan path `.svg` untuk semua 22 produk dummy dan 9 logo toko, padahal file asli sudah ada dalam bentuk `.png`. Akibatnya: gambar di web menampilkan placeholder SVG yang rusak/broken.

**Yang diperbaiki:**
- **22 produk**: `products.thumbnail` + `product_images.image_path` di-update dari `.svg` ke `.png` dengan mapping nama file yang tepat (misal: `tas-rajut-handmade.svg` → `tas-rajut-handmade-1.png`)
- **9 toko**: `stores.logo` di-assign dan di-update ke file `.png` yang sesuai (logo-1/5/6/7/8/9/10/11/12.png)
- **16 file `.svg` placeholder** dihapus dari `storage/app/public/products/` (tidak terpakai lagi)
- **Logo-10/11/12** yang sebelumnya tidak terpakai, sekarang di-assign ke store ID 2/3/4

**Hasil:**
- Database: semua thumbnail produk dan logo toko sekarang pakai ekstensi `.png` ✓
- Disk: hanya menyisa 22 file `.png` produk + 9 file `.png` logo toko (0 file `.svg`) ✓
- Web access: HTTP 200 untuk semua gambar produk dan logo toko ✓

### Catatan
- Foto produk & logo adalah AI-generated (bukan foto merek asli) — cukup untuk demo UI agar
  tidak broken. Bila Master punya foto asli, bisa diupload lewat seller dashboard nanti.
- Script generator tersimpan: `scripts/gen_product_images.php`, `scripts/save_gen_images.php`
  (bisa diulang kalau perlu regenerasi).

---

## 🐛 Audit & Bug Fix (2026-08-28)

| # | Severity | Bug | Fix |
|---|----------|-----|-----|
| 1 | CRITICAL | `Order::payment()` salah relasi (`belongsTo`) → payment selalu null | → `hasOne(Payment::class)` |
| 2 | HIGH | Seller Dashboard double-`where` menumpuk (statistik salah) | pakai `clone()` per count |
| 3 | MEDIUM | Admin hapus kategori tanpa guard produk | tolak kalau `products()->exists()` |
| 4 | MEDIUM | Cart add melebihi stok | cek `newQty <= stock` |
| 5 | — | Foto hero kepanjangan (ikut teks UI) | recrop area pasar murni |
| 6 | — | Icon kategori semua sama (trash placeholder) | partial `category-icon` per slug |
| 7 | — | Carousel duplikat hero | dihapus (Master minta hanya hero) |

---

## 🔌 Cara Menjalankan

```bash
cd "c:\project saya\pasar id"
docker compose up -d --build
docker compose exec app php artisan key:generate   # pertama kali
docker compose exec app php artisan migrate --seed
```

Akses:
- Web:    http://localhost:8080
- phpMyAdmin: http://localhost:8081 (root / root)
- Demo: admin@pasar.id · seller@pasar.id · buyer@pasar.id (password: `password`)

Build asset (kalau ubah CSS/JS):
```bash
cd pasar-id && npm install && npm run build
```

---

## 📋 Rencana Ke Depan (Ditambahkan & Diperbaiki)

Konsolidasi dari sesi review + sinkronisasi Stitch pt2. Dipisah antara fitur
baru yang akan **ditambahkan** dan penyempurnaan yang akan **diperbaiki**.
Boleh dikerjakan bertahap.

> Catatan: Seller area (layout sidebar + dashboard + produk + riwayat transaksi +
> auth pembeli) **sudah selesai** — lihat section "🎨 Sinkronisasi Desain Stitch pt2".

### 📥 Akan Ditambahkan (Fitur Baru)
- [ ] **Upload gambar produk** — aktifkan field `thumbnail`/`product_images`,
      storage ke `public/storage` (Laravel media): form upload, validasi, resize,
      tampil di kartu & detail.
- [ ] **Email verification** — aktifkan SMTP / Mailpit (mailer masih `log`) agar
      link verifikasi beneran terkirim.
- [ ] **Payment gateway beneran** — QRIS / Midtrans / Xendit (saat ini COD/transfer
      simulasi, ditunda di MVP).
- [ ] **Rating & review + wishlist** — fitur interaksi pembeli.
- [ ] **Manajemen stok lanjut** — notifikasi stok menipis, batas minimum,
      multiple variant (ukuran/warna).
- [ ] **Search & filter lanjut** — filter kategori + lokasi + harga (sidebar
      filter lengkap ala Stitch); perbaiki pencarian (saat ini hanya `LIKE` nama).
- [ ] **Order & kurir** — ongkos kirim ("Kurir Pasar"), status pengiriman, resi,
      notifikasi perubahan status ke buyer.
- [ ] **Empty state & loading state** — placeholder ramah + skeleton di semua list.
- [ ] **Detail produk** — galeri thumbnail (saat ini 1 foto), rating & ulasan
      placeholder, share button.
- [ ] **CI/CD pipeline** — GitHub Actions jalankan `php artisan test` + `npm run build`
      tiap push.
- [ ] **Logging & monitoring** — log rotation, error tracking (Flare/Sentry) di prod.
- [ ] **Backup otomatis** — `backup-db.sh` jadi cron harian + simpan ke cloud/object storage.
- [ ] **Browser test e2e** — Pest + Laravel Dusk untuk alur checkout & admin.
- [ ] **A11y audit** — alt text, kontras warna, keyboard navigation.

### 🛠️ Akan Diperbaiki (Penyempurnaan)
- [ ] **Polish admin area** — masih pakai Tailwind default; samakan tema Stitch
      (navbar, sidebar, kartu statistik, tabel) seperti seller sudah dilakukan.
- [x] **Foto produk asli** — 22 foto produk AI-generated (.png) + 9 logo toko
      menggantikan placeholder anyaman (sesi 2026-08-31). Bukan foto merek asli,
      cukup untuk demo; upload foto asli bisa lewat seller dashboard.
- [ ] **Ikon kategori asli** — PNG per kategori (bukan SVG inline) kalau Master
      punya aset ikon.
- [ ] **Responsive fine-tune** — cek mobile (navbar search, grid produk, hero
      split jadi stack).
- [ ] **Storage permission produksi** — Dockerfile `chmod 777` dev-only; pakai
      www-data + volume persistent di prod.
- [ ] **Env & secrets produksi** — pisahkan `.env` prod (jangan `chmod 777`,
      jangan commit); `docker-compose.prod.yml` pakai env eksternal.
- [x] **Seeder realistis** — `DummyUsersSeeder`: 10 pembeli + 8 pemilik UMKM + 16 produk
      baru + logo toko (sesi 2026-08-31). Demo marketplace jadi lebih hidup.
- [ ] **Test coverage** — tingkatkan coverage controller admin & seller.

---

## 📊 Perbaikan Audit Data & Desain (2026-09-06)

### Audit bug ditemukan & diperbaiki
1. **Tabel `categories` kosong** → dropdown kategori di seller product page & navbar kosong. Fix: migration seed 9 kategori default.
2. **Thumbnail produk masih `.svg`** → gambar produk broken. Fix: migration update semua 16 thumbnail ke `.png` yang valid.
3. **`category_id` produk & logo toko `NULL`** → assignment lupa. Fix: migration assign kategori per produk & logo per toko.

### Desain ulang pagination (final)
- [x] Rewrite total ke flat minimalis — tidak ada background bulat/shadow/container berwarna
- [x] Model: prev/next arrow tipis (h-3) + page dropdown kecil (w-10) + "of {total}" (text-xs)
- [x] Margin eliminator: `mt-0` wrapper + `py-0` nav — pagination benar-benar menempel di bawah grid
- [x] Dropdown memakai border tipis `border-outline-variant` + angka primary
- [x] Arrow icons `h-3 w-3` (lebih kecil dari sebelumnya)
- [x] Fix bug: margin ganda (`mt-6`+`mt-10`) → `mt-0` + `py-0`
- [x] Fix bug: JS function bentrok URL → `window.pasarPageUrls` + `pasarPaginationGo()`
- [x] Verifikasi di homepage (`/`), produk listing (`/products`), kategori, store listing

---

## 📝 Log Singkat

- **Sprint 1–5**: Infrastruktur + Auth + Marketplace + Cart/Checkout + Seller.
- **Sprint 6–7**: Admin panel + Testing/Deploy. 35 test lulus.
- **Audit (2026-09-06)**: 3 bug ditemukan & diperbaiki — (1) tabel `categories` kosong → 9 kategori seed, (2) `thumbnail` produk masih `.svg` → 16 thumbnail di-update ke `.png`, (3) `category_id` & `logo` toko NULL → assigned via migration.
- **Pagination redesign (2026-09-06)**: Rewrite ke flat minimalis mirip desain referensi — arrow tipis + dropdown kecil + "of N". Fix margin ganda + JS identifier injection (URL-encoded path → fungsi nama error). Pakai `window.pasarPageUrls` global object. Verifikasi di `/`, `/products`, `/categories/{slug}`, `/stores/{slug}`.
- **Audit**: 4 bug fungsional diperbaiki (payment relasi, dashboard stats,
  guard kategori, stok cart).
- **UI Polish (Opsi A)**: Terapkan design system Stitch — warna, font, logo
  asli, foto hero pasar, icon kategori variatif. Carousel dibuang atas
  permintaan Master (hindari duplikasi dengan hero).
- **Sinkronisasi Stitch pt2 (2026-08-31)**: Ekstrak `stitch_pasar.id_local_digital_marketplace
  pt 2.zip` ke `design-references/`. Disinkronkan tanpa CDN: (1) menu kategori mandiri +
  `/categories`, (2) layout seller seragam (sidebar) + dashboard/produk/riwayat, (3) halaman
  Daftar Mitra UMKM `/mitra` (register seller → store draft), (4) auth pages pembeli
  split-layout "Gotong Royong". Migrasi `category_id` di `stores`. Verifikasi HTTP 200
  semua route + flow `/mitra` bikin user+store.
- **Data dummy & aset visual (2026-08-31, sesi lanjutan)**: Tambah `DummyUsersSeeder`
  (10 pembeli + 8 UMKM + 16 produk, password `password`). Audit gambar produk temukan
  bug seeder (path DB vs file disk tidak konsisten) → bikin generator placeholder SVG +
  perbaiki. Lalu generate 22 foto produk + 9 logo toko AI-generated (.png), update DB,
  hapus sisa .svg. Verifikasi HTTP 200 semua aset.

---

*Dokumen ini otomatis disusun dari sesi kerja — boleh diedit manual bila ada
penambahan fitur di luar catatan di atas.*
