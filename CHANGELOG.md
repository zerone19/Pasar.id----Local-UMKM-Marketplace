# Changelog Ringkas — Pasar.ID

> Ringkasan progres project ini. Detail penuh ada di `progress.md`.

---

## 🏁 Status Saat Ini (2026-09-06)
**MVP SELESAI** — 7 sprint selesai, 35 test lulus, 92 assertions.  
Semua fitur dasar marketplace sudah berjalan: auth multi-role, cart, checkout, seller dashboard, admin panel.

---

## ✨ Fitur Utama (Selesai)

### Sprint 1–5
- Infrastruktur Docker (app + web + db + phpmyadmin)
- Auth & Role Management (buyer / seller / admin)
- Marketplace (kategori, toko, produk, browse)
- Cart & Checkout (per-toko order, stok check)
- Seller area (CRUD toko & produk, riwayat pesanan)

### Sprint 6–7
- Admin panel (user/store/category/product/order management)
- Testing suite (35 test, 92 assertions — RefreshDatabase)

---

## 🎨 UI / UX (Opsi A — Ikut Desain Stitch)

- Tailwind theme: Forest Green primary, Be Vietnam Pro + Work Sans fonts
- Navbar sticky + footer cream + hero split image
- Product card: 1:1 image, chip kategori, badge habis
- Kategori mandiri (`/categories`) + dropdown Alpine.js
- Layout seller seragam (sidebar + topbar mobile)
- Daftar Mitra UMKM (`/mitra`) — split-screen register seller
- Auth pages pembeli split-layout "Gotong Royong"

---

## 🐛 Bug Fix Terbaru (2026-09-06)

1. **Tabel `categories` kosong** → seed 9 kategori default
2. **Thumbnail `.svg` → `.png`** → fix 16 thumbnail via migration
3. **`category_id` & `logo` toko NULL** → assign via migration
4. **Pagination redesign** → flat minimalis (no rounded buttons/shadows)
5. **JS identifier injection** → pakai `window.pasarPageUrls` + `pasarPaginationGo()`

---

## 📦 Data Dummy & Aset Visual

- `DummyUsersSeeder`: 10 pembeli + 8 UMKM + 16 produk baru
- 22 foto produk AI-generated (.png)
- 9 logo toko (.png) — emblem lingkaran per brand
- Password semua akun dummy: `password`

---

## 🛠️ Cara Menjalankan

```bash
cd "c:\project saya\pasar id"
docker compose up -d --build
docker compose exec app php artisan migrate --seed
```

Akses:
- Web: [http://localhost:8080](http://localhost:8080)
- phpMyAdmin: [http://localhost:8081](http://localhost:8081) (root / root)

Demo login:
- Admin: `admin@pasar.id` / `password`
- Seller: `seller@pasar.id` / `password`
- Buyer: `buyer@pasar.id` / `password`

Build asset:
```bash
cd pasar-id && npm install && npm run build
```

---

## 📋 Rencana Ke Depan (Fitur Baru + Penyempurnaan)

### Akan Ditambahkan
- Upload gambar produk (form + validasi + resize)
- Email verification (SMTP / Mailpit)
- Payment gateway beneran (QRIS / Midtrans / Xendit)
- Rating & review + wishlist
- Manajemen stok lanjut + variant
- Search & filter lanjut
- Order & kurir (ongkir, resi, notifikasi)
- Empty state & loading state
- Detail produk galeri
- CI/CD pipeline (GitHub Actions)
- Logging & monitoring (Flare/Sentry)
- Backup otomatis ke cloud
- Browser test e2e (Pest + Laravel Dusk)
- A11y audit

### Akan Diperbaiki
- Polish admin area (tema Stitch)
- Ikon kategori asli (PNG per kategori)
- Responsive fine-tune (mobile layout)
- Storage permission production
- Env & secrets production

---

*Dokumen ini otomatis disusun dari `progress.md` dan log sesi kerja.*
