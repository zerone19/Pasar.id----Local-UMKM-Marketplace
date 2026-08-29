# Progress Project Pasar.ID

> Marketplace UMKM Lokal — Laravel 13 + Docker + MySQL + Tailwind (Breeze)
> Dikelola oleh: Ascjul Zerone (Master) · Dibantu oleh: Nera Everis

---

## 📌 Status Terkini (2026-08-28)

**MVP SELESAI** — 7/7 sprint selesai & terverifikasi (35 test lulus).
**UI Marketplace** sudah di-polish mengikuti design system Stitch (warna, font, logo & foto asli).

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
    └── stitch_pasar.id_local_digital_marketplace/  # desain referensi
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

## 📋 To-Do / Post-MVP (belum dikerjakan)

- [ ] Upload gambar produk (saat ini placeholder).
- [ ] Aktivasi email verification (mailer = log).
- [ ] Payment gateway beneran (QRIS / Midigital).
- [ ] Rating & review, wishlist.
- [ ] Polish admin & seller area ikut tema yang sama.
- [ ] Foto produk asli (butuh aset terpisah dari Master).

---

## 🔧 Hal yang Mau Diperbaiki ke Depannya

List perbaikan & penyempurnaan yang tercatat dari review sesi ini (bukan fitur
baru, tapi perbaikan kualitas & konsistensi). Boleh dikerjakan bertahap.

### UI / UX
- [ ] **Foto produk asli** — saat ini kartu produk pakai placeholder anyaman
      karena foto di mockup Stitch menyatu dengan teks UI. Perlu aset foto
      produk terpisah (Master upload ke `public/assets/img/`) atau ambil dari
      stock photo (butuh izin/API).
- [ ] **Polish admin & seller area** — marketplace sudah ikut desain Stitch,
      tapi halaman admin/seller masih pakai Tailwind default. Samakan tema
      (navbar, sidebar, kartu statistik, tabel).
- [ ] **Empty state & loading state** — tambahkan placeholder ramah saat data
      kosong / sedang dimuat (skeleton) di semua list.
- [ ] **Responsive fine-tune** — cek tampilan di mobile (navbar search, grid
      produk, hero split jadi stack).
- [ ] **Detail produk** — galeri thumbnail (saat ini 1 foto), rating & ulasan
      placeholder, share button.
- [ ] **Kategori** — tambahkan ikon asli per kategori (bukan SVG inline) kalau
      Master punya aset ikon PNG.

### Backend / Fungsional
- [ ] **Upload gambar produk** — field `thumbnail`/`product_images` belum aktif
      (storage ke `public/storage` via Laravel media). Perlu: form upload,
      validasi, resize, tampil di kartu & detail.
- [ ] **Email verification** — mailer masih `log`. Aktifkan SMTP / Mailpit agar
      link verifikasi beneran terkirim.
- [ ] **Payment gateway beneran** — saat ini COD/transfer hanya simulasi.
      Integrasi QRIS / Midtrans / Xendit (sesuai keputusan MVP ditunda).
- [ ] **Manajemen stok lanjut** — notifikasi stok menipis, batas minimum,
      multiple variant (ukuran/warna).
- [ ] **Search & filter** — perbaiki pencarian (saat ini hanya `LIKE` nama),
      tambah filter kategori + lokasi + harga (mockup Stitch punya sidebar
      filter lengkap).
- [ ] **Order & kurir** — ongkos kirim ("Kurir Pasar"), status pengiriman,
      resi, notifikasi perubahan status ke buyer.

### Teknis / Infra
- [ ] **Storage permission** — Dockerfile pakai `chmod 777` (dev-only). Untuk
      production pakai user/group www-data yang benar + volume persistent.
- [ ] **Env & secrets** — pisahkan `.env` production (jangan `chmod 777`,
      jangan commit). Pastikan `docker-compose.prod.yml` pakai env eksternal.
- [ ] **CI/CD** — tambahkan pipeline (GitHub Actions) jalankan `php artisan
      test` + `npm run build` tiap push.
- [ ] **Logging & monitoring** — setup log rotation, error tracking (Flare/
      Sentry) di production.
- [ ] **Backup otomatis** — `backup-db.sh` manual; jadikan cron harian +
      simpan ke cloud/object storage.
- [ ] **Seeder realistis** — tambah lebih banyak produk/toko dengan foto agar
      demo marketplace terlihat hidup.

### QA / Testing
- [ ] **Browser test** — tambahkan test end-to-end (Pest + Laravel Dusk) untuk
      alur checkout & admin.
- [ ] **Coverage** — tingkatkan coverage pada controller admin & seller.
- [ ] **A11y** — audit aksesibilitas (alt text, kontras warna, keyboard nav).

---

## 📝 Log Singkat

- **Sprint 1–5**: Infrastruktur + Auth + Marketplace + Cart/Checkout + Seller.
- **Sprint 6–7**: Admin panel + Testing/Deploy. 35 test lulus.
- **Audit**: 4 bug fungsional diperbaiki (payment relasi, dashboard stats,
  guard kategori, stok cart).
- **UI Polish (Opsi A)**: Terapkan design system Stitch — warna, font, logo
  asli, foto hero pasar, icon kategori variatif. Carousel dibuang atas
  permintaan Master (hindari duplikasi dengan hero).

---

*Dokumen ini otomatis disusun dari sesi kerja — boleh diedit manual bila ada
penambahan fitur di luar catatan di atas.*
