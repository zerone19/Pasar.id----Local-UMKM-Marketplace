# Pasar.ID — Project Progress Tracker

## Project Overview
Pasar.ID adalah marketplace UMKM lokal berbasis multi-vendor e-commerce.

**Tagline:** "Gotong Royong Memajukan UMKM Indonesia"

---

## 📊 STATUS TERKINI — 1 Oktober 2026
### Mobile UX — "Seperti aplikasi online shop" & device-aware — PROGRES
- [x] `layout.tsx`: tambah `<meta name="viewport" content="width=device-width, initial-scale=1">` — fondasi device-aware. Sebelumnya tak ada → mobile render lebar 980px & zoom out.
- [x] `Icon.tsx`: tambah ikon `home` (untuk bottom nav).
- [x] `Footer.tsx`: footer mobile → **bottom tab-bar native-app style** (Home/Produk/UMKM/Keranjang/Akun), `fixed inset-x-0 bottom-0 md:hidden`, `z-40`, safe-area inset notch. Desktop footer tetap.
- [x] `AddToCartButton.tsx`: qty tombol `w-9`→`w-11` (≥44px min touch target); tombol "Tambah ke Keranjang" `w-full` + `whitespace-normal sm:whitespace-nowrap` anti overflow.
- [ ] **Production build (`next build`) — PRE-EXISTING FAILURE, tidak berkaitan mobile:** `TypeError: Cannot read properties of null (reading 'useContext')` saat SSG prerender semua route. Akar: `Header` pakai `useCart()` (CartContext) yang null di prerender; `localStorage` hanya di `useEffect` (bukan root cause). Dev & runtime normal; perlu perbaikan terpisah bila deploy production dibutuhkan.

### 📱 Backlog / hal-hal yang mau diperbaiki di tampilan mobile (roadmap)
- [ ] Migrasi Material Icons (46 occ, 9 halaman: cart/checkout/auth/{login,register}/seller/*) → `<Icon/>` SVG lokal agar ikon andal di mobile (hilangkan dependensi font Google Fonts; cegah FOIT/ikon-kotak bila jaringan lambat). Perlu tambah ikon: lock, edit, delete, attach_money, check_circle.
- [ ] Audit touch target ≥44×44px di semua halaman (tombol qty, add-to-cart, nav link, form button) term. seller & admin tables.
- [ ] List produk & toko: ketatkan `sm:` gap & `px-5` konsisten agar tidak terlipat ketepi; tambah `mb-16`+safe-area agar konten tak tertutup bottom tab-bar.
- [ ] `next/image` `sizes` audit (produk & gambar) agar beban gambar mobile optimal (lazy + resize).
- [ ] Sticky cart summary/CTA di halaman cart & checkout (native feel) + safe-area notch.
- [ ] Header mobile: backdrop blur/shadow saat scroll; drawer menu tertutup otomatis setelah pilih link.
- [ ] Pull-to-refresh / infinite scroll di /products & /stores (native-ish).
- [ ] Konfirmasi visual di perangkat asli (vision dev env down → QA terbatas audit kode+SSR; minta screenshot device sebenarnya bila ada elemen masih belum rapi).

### Verifikasi runtime — 1 Oktober 2026
- [x] docker: api(3000), web(3001), db(PG16), redis, phpmyadmin(8080) running.
- [x] db push + seed: 10 users/8 stores/32 produk/8 kategori.
- [x] Auth e2e: login → 200, /admin/dashboard w/ Bearer → 200, no token → 401.
- [x] Frontend (dev) compile clean & SSR markup terkonfirmasi: viewport meta + mobile nav (`aria-label="Navigasi bawah"`) + AddToCart `w-full`/`whitespace-normal` + qty `w-11` (44px) di semua halaman publik.
- [ ] Vision/screenshot & device-resize tak tersedia di env ini → mobile QA terbatas audit kode+SSR.

---

## 📊 STATUS TERKINI — 21 September 2026

### Audit UI & Data Produk — SELESAI
- [x] Homepage `/` tetap menjadi route awal Beranda; tidak ada redirect otomatis ke `/products`.
- [x] Header dan footer memakai logo lokal Pasar.ID dari `/stitch/logo-mark.jpg`.
- [x] Icon publik dimigrasikan dari teks `material-icons` yang rawan tampil literal ke komponen SVG lokal.
- [x] Product listing membaca kontrak API `{ data, meta }` dengan benar.
- [x] Kartu produk menggunakan rasio gambar dan tinggi konten yang konsisten.
- [x] Halaman detail toko UMKM menampilkan kartu sebagai link ke `/products/[slug]`; selector jumlah dan tombol keranjang tidak lagi berada di kartu toko.
- [x] Aksi tambah ke keranjang tetap tersedia di halaman detail produk.
- [x] Empat asset gambar produk lokal dibuat untuk kopi, sayur, kerajinan, dan jajanan.
- [x] Seed idempotent menghasilkan 8 toko dan minimal 4 produk per toko; runtime terverifikasi 36 produk aktif karena data legacy dipertahankan.
- [x] Normalisasi gambar backend berlaku untuk semua toko dan produk baru: URL eksternal/legacy atau gambar kosong memakai fallback berdasarkan kategori.
- [x] API audit: 8 toko, 36 produk, 0 produk dengan gambar non-lokal.
- [x] Docker web/API direcreate setelah perubahan untuk menghindari cache/HMR stale; halaman toko dan detail produk HTTP 200.
- [x] Frontend production build, backend type-check, dan `git diff --check` berhasil.

---

## 📊 STATUS TERKINI — 20 September 2026
**Catatan historis:** status di bawah ini adalah snapshot sebelum audit UI/data 21 September 2026.

### Backend — NestJS API (port 3000) ✅ JALAN

#### Update 21 September 2026
- Seed lama yang tertulis di bagian historis tidak lagi menjadi ukuran runtime; gunakan audit terbaru di atas sebagai sumber status.
- Material Icons tetap tercatat di beberapa halaman internal lama, tetapi area marketplace publik menggunakan SVG lokal.

---

### Backend — NestJS API (port 3000) ✅ JALAN

### Backend — NestJS API (port 3000) ✅ JALAN
- Docker Compose running
- PostgreSQL 16 + Prisma migrations applied (8 tables)
- Modul: Auth, Users, Stores, Products, Orders (semua endpoint OK)
- ValidationPipe + DTOs aktif
- CORS untuk localhost:3001 — sudah diverifikasi
- **Fix kritis:** Hapus @nestjs/swagger v12 yang crash (loadPackageSync mismatch)
- **Fix:** UsersController registered di UsersModule (CRUD users aktif)
- **Fix:** OrdersService price bug — order items store correct product prices
- Seeder jalan — 4 products, 3 users (admin/seller/buyer), 3 categories, 1 store
- Endpoint baru: `GET /products/slug/:slug`, `GET /stores/slug/:slug`
- Security hardening: JWT + role guard untuk users/orders; passwordHash tidak bocor pada response publik
- Validasi order: user/product aktif, quantity positif, stok mencukupi, dan stock decrement atomik dalam transaksi
- Seller dashboard: revenue dihitung berdasarkan `price × quantity`, total sold/order diperbaiki
- Backend build berhasil diverifikasi dengan `npm run build`

### Frontend — Next.js (port 3001) ✅ JALAN
- Docker container running (Next.js 14.2 + App Router)
- Tailwind CSS terhubung (globals.css + postcss.config.js di-fix)
- Material Icons via Google Fonts — sudah load
- Fonts: Be Vietnam Pro + Work Sans — sudah terhubung
- Design system tokens: surface colors, outline, error, label-md — sudah work
- **Halaman sudah siap:**
  - `/` — Home (Hero, Categories, Featured UMKM)
  - `/products` — Product listing (fetch ke API, grid, loading skeletons)
  - `/products/[slug]` — Product detail (gallery, deskripsi, AddToCartButton)
  - `/stores` — Stores listing (fetch ke API, grid cards)
  - `/cart` — Cart page (Context + localStorage, qty adjust, clear, checkout CTA)
  - `/checkout` — Checkout page (3-step: alamat → pembayaran → review, order API)
  - `/checkout/success` — Success page (detail pesanan, instruksi COD/transfer)
  - `/auth/login` — Login page (form validasi, JWT simpan, redirect)
  - `/auth/register` — Register page (role BUYER/SELLER, validasi, redirect)
- **Header** — sudah update: link ke rute nyata, cart badge dinamis via CartContext, auth links
- AddToCartButton komponen — quantity picker + dynamic state
- CartContext — React Context + useReducer + localStorage persistence
- Auth flow diperbaiki: token konsisten, checkout mengambil identitas dari JWT
- Halaman baru: `/about`, `/orders`, `/seller/products/new`, `/seller/products/[id]/edit`
- Header: pencarian aktif, nama user, logout, dan link riwayat pesanan
- Production build berhasil diverifikasi dengan `npm run build`

### Issues / yang perlu diperhatikan
- `nestjs-backend/src/prisma/seed.ts` (file anomali) sudah dihapus

---

## 📋 Phase & Milestone Breakdown

### ✅ Phase 0 — Planning & Dokumen (SELESAI)
- [x] 01-Planning-PasarID.md
- [x] 02-PRD-PasarID.md
- [x] 03-MVP-PasarID.md
- [x] 04-Feature-Brief-PasarID.md
- [x] 05-Arsitektur-Brief-PasarID.md
- [x] 06-Teknologi-Brief-PasarID.md
- [x] Pasar.ID Design System (DESIGN.md)
- [x] 15 halaman mockup HTML (Tailwind CSS)
- [x] Git repo + GitHub push

### ✅ Phase 1a — Backend Foundation (SELESAI)
- [x] Docker Compose setup (api, web, db, redis, phpmyadmin)
- [x] PostgreSQL database with schema migrations
- [x] Redis cache
- [x] NestJS API server (port 3000) — **crash-free**
  - [x] Auth (JWT, register, login)
  - [x] Users (CRUD)
  - [x] Stores (CRUD)
  - [x] Products (CRUD + slug lookup)
  - [x] Orders (CRUD)
- [x] Prisma ORM with schema & migrations
- [x] ValidationPipe with DTOs
- [x] CORS configured for localhost:3001
- [x] Semua database tables created & migrations applied
- [x] Seeder jalan (4 products, 3 users, 3 categories, 1 store)

### ✅ Phase 1b — Frontend Foundation (SELESAI)
- [x] Next.js 14 project initialized
- [x] Tailwind CSS configured + globals.css + postcss.config.js di-fix
- [x] Docker container running (port 3001)
- [x] Material Icons + Be Vietnam Pro / Work Sans fonts terhubung
- [x] Design system classes (surface-container-*, on-surface-variant, etc.) terdaftar di tailwind.config.ts

### ✅ Phase 1c — Frontend Pages (SELESAI — 17 Sept 2026)
- [x] Home page (`app/page.tsx`) — HERO, Categories, Featured UMKM
- [x] Header component (`components/Header.tsx`) — responsive, dynamic cart badge
- [x] Footer component (`components/Footer.tsx`)
- [x] Products listing (`app/products/page.tsx`) — API fetch, grid, skeleton loading
- [x] Product detail (`app/products/[slug]/page.tsx`) — gallery, deskripsi, seller info, AddToCartButton
- [x] Stores listing (`app/stores/page.tsx`) — API fetch, grid cards
- [x] Cart (`app/cart/page.tsx`) — full implementation (Context, qty adjust, clear cart, checkout)
- [x] CartContext (`src/contexts/CartContext.tsx`) — localStorage persistence
- [x] AddToCartButton (`components/AddToCartButton.tsx`) — quantity picker + dynamic state
- [x] Login/Register (`app/auth/login/page.tsx`, `app/auth/register/page.tsx`) — full API integration
- [x] Checkout flow (`app/checkout/page.tsx`, `app/checkout/success/page.tsx`) — 3-step form, API integration

### ✅ .env Setup (SELESAI — 17 Sept 2026)
- [x] Buat file `.env` untuk NestJS backend
- [x] Konfigurasi DATABASE_URL, JWT_SECRET, REDIS_URL
- [x] Buat file `.env.local` untuk Next.js
- [x] Koneksi database stabil (sudah jalan via Docker)

### ✅ Phase 2 — Marketplace (SELESAI)
- [x] Product CRUD API (sudah ada)
- [x] Category management (`GET /categories`, `GET /categories/:id`, `GET /categories/slug/:slug`, `POST /categories`, `PUT /categories/:id`, `DELETE /categories/:id`)
- [x] Search & filter API (`GET /products?search=&category=&minPrice=&maxPrice=&sortBy=&sortOrder=&page=&limit=`)
- [x] Store/profile management (`GET /stores/:id` — includes owner + products, `PUT /stores/:id`)
- [x] Integrasi API → Frontend (products, stores, cart pages sudah jalan)

### ✅ Phase 3 — Transaction (SELESAI)
- [x] Cart (multi-seller support — Context + localStorage)
- [x] Checkout flow (`app/checkout/page.tsx`, `app/checkout/success/page.tsx`) — 3-step form, API integration
- [x] Address management (checkout page: full address form with notes, shippingAddress stored in order)
- [x] Order lifecycle (`GET /orders`, `GET /orders/:id`, `GET /orders/user/:userId`, `POST /orders`, `PUT /orders/:id/status` — supports PENDING → CONFIRMED → PROCESSING → READY/SHIPPED → COMPLETED)
- [x] Payment abstraction (MVP: COD + Manual Transfer — status tracking, transfer instructions di success page)

### ✅ Phase 4 — Seller (SELESAI)
- [x] Seller module di backend (SellerModule, SellerController, SellerService)
- [x] Role guard + JWT auth
- [x] Seller dashboard API (`GET /seller/dashboard` — stats: totalProducts, totalStock, totalOrders, totalRevenue, totalSold, lowStock)
- [x] Product management API (`GET /seller/products`, `POST /seller/products`, `PUT /seller/products/:id`, `DELETE /seller/products/:id`)
- [x] Order management API (`GET /seller/orders`, `GET /seller/orders/:id`, `PUT /seller/orders/:id/status`)
- [x] Store management API (`GET /seller/store`, `POST /seller/store`, `PUT /seller/store/:id`)
- [x] Seller dashboard frontend (`app/seller/page.tsx` — stats grid, quick actions)
- [x] Seller products frontend (`app/seller/products/page.tsx` — table, toggle status, delete)
- [x] Seller orders frontend (`app/seller/orders/page.tsx` — list, status update dropdown)
- [x] Seller store frontend (`app/seller/store/page.tsx` — create/update form)
- [x] Auth helper (`src/lib/auth.ts` — token/user management)
- [x] Header updated — Seller Dashboard link (conditional for SELLER/ADMIN role)
- [x] Login page updated — save user data to localStorage

### ✅ Phase 5 — Admin (SELESAI)
- [x] Admin dashboard API dan frontend (`/admin`) dengan statistik users, sellers, products, inactive products, orders, dan revenue
- [x] User/seller management: daftar user ber-pagination dan perubahan role
- [x] Proteksi admin terakhir dan pencegahan admin menurunkan role dirinya sendiri
- [x] Product moderation: aktif/nonaktif produk melalui endpoint admin terproteksi
- [x] Order monitoring: daftar order ber-pagination dengan customer, item, status, dan total
- [x] Admin dapat memperbarui status order
- [x] Mutasi kategori sekarang hanya dapat dilakukan ADMIN
- [x] Product creation publik ditutup; seller ID diambil dari JWT
- [x] Produk nonaktif tidak tampil melalui endpoint publik
- [x] Audit runtime dan production build berhasil diverifikasi
- [ ] Moderation history/rejection reason — membutuhkan model database baru, ditunda ke enhancement terpisah

### 🔎 Phase 5 Audit Findings
- Fixed: AdminModule awalnya belum mengimpor PrismaModule sehingga API gagal bootstrap; diperbaiki dan diverifikasi melalui Docker logs.
- Fixed: Order access check memakai field JWT `userId` pada satu cabang; diseragamkan ke `id ?? userId`.
- Fixed: Endpoint product detail publik dapat membaca produk nonaktif; sekarang hanya produk aktif yang dikembalikan.
- Fixed: Category mutation dan public product creation sebelumnya tidak memiliki otorisasi; sekarang dilindungi JWT/RBAC.
- No unresolved critical bugs ditemukan pada audit final.
- Docker image rebuild sempat gagal karena timeout registry `node:20-slim`; container existing berhasil direstart dan runtime source terverifikasi.

### ✅ Phase 6 — Mobile (MVP scaffold selesai)
- [x] Flutter customer app scaffold di `mobile/`
- [x] Konfigurasi API base URL dan REST client untuk products, categories, auth, cart, dan orders
- [x] Halaman dasar mobile: katalog produk
- [x] REST client mobile: products, categories, login, dan orders
- [ ] UI detail produk, cart, login, dan orders — slice mobile berikutnya
- [ ] Device build/runtime Flutter — belum dapat diverifikasi karena Flutter SDK tidak tersedia di environment ini

### ✅ Phase 7 — Growth (MVP selesai)
- [x] Notifications: model, user-scoped API, mark-as-read, dan notifikasi order dibuat dalam transaksi checkout
- [x] Reviews & ratings: product reviews dengan rating 1–5 dan validasi pembelian bila order ID diberikan
- [x] Vouchers & promotions: validasi masa berlaku, usage limit, minimum purchase, percentage discount, dan max discount
- [x] Analytics: overview terproteksi untuk ADMIN
- [x] Chat: conversation dan message API dengan access control, batas panjang pesan, dan transaksi update timestamp
- [x] Migration database `phase7_growth` dibuat dan diaplikasikan
- [x] Backend build, Prisma validate/migrate status, Docker bootstrap, dan endpoint auth boundary diaudit
- [ ] Push notification realtime, moderation history, voucher CRUD UI, dan chat realtime — enhancement lanjutan

### 🔎 Phase 6–7 Audit Findings
- Fixed: Prisma client di container stale setelah schema growth; regenerate dan recreate container dilakukan, API kembali bootstrap normal.
- Fixed: Docker Compose kini me-mount folder Prisma agar schema/migration dan generated client tetap sinkron saat development.
- Fixed: Analytics dibatasi untuk ADMIN; voucher validation memakai JWT dan role guard.
- Fixed: Checkout sekarang membuat notification `ORDER_CREATED` dalam transaksi database.
- No unresolved critical bugs ditemukan pada backend MVP scope.
- Limitation: Flutter SDK tidak tersedia, sehingga `flutter analyze` dan device run belum bisa dilakukan.

---

## 🔍 Audit Project & Rekomendasi Fitur Mendatang

Audit ini membandingkan README/PRD, struktur NestJS–Prisma–Next.js–Flutter, model database, endpoint backend, dan dependensi aktual. Rekomendasi di bawah adalah backlog produk/teknis; belum dianggap selesai sampai implementasi dan verifikasi dicentang.

### Temuan utama saat ini
- Fondasi buyer, seller, admin, katalog, multi-seller cart, checkout, order lifecycle, voucher validation, review, notification, analytics, dan chat API sudah tersedia.
- Growth API belum memiliki seluruh UI web yang sepadan: UI voucher, review, notification center, dan chat realtime masih perlu dibangun.
- Pembayaran masih berupa COD/manual transfer; belum ada payment gateway, bukti transfer upload, webhook, refund, atau rekonsiliasi pembayaran.
- Pengiriman masih disimpan sebagai satu string alamat; belum ada ongkir, kurir, tracking number, split shipment, atau estimasi tiba.
- Model Store belum memiliki data operasional seperti logo/banner, alamat terstruktur, koordinat, jam buka, status buka/tutup, dan verifikasi seller.
- Model Product belum memiliki wishlist/favorite, varian, berat/dimensi, SKU, atau riwayat harga; upload gambar masih perlu alur storage yang aman.
- `nestjs-backend` belum memiliki test file yang terdeteksi; perlu regression suite agar perubahan transaksi, stok, role, dan normalisasi gambar tidak mudah rusak.
- Beberapa halaman internal masih memakai `material-icons`, berbeda dengan area publik yang sudah memakai SVG lokal.
- Docker Compose development masih memuat credential placeholder langsung di file; konfigurasi production harus memakai secret manager atau environment yang tidak di-commit.
- Flutter masih berupa scaffold katalog/API client; Flutter SDK tidak tersedia di environment saat audit sehingga build perangkat belum tervalidasi.

### Backlog prioritas P0 — Production readiness & keamanan
- [ ] Tambahkan unit test dan integration/e2e test untuk auth/RBAC, stok atomik, checkout, order ownership, voucher, review ownership, normalisasi gambar, dan endpoint admin.
- [ ] Tambahkan CI pipeline: install reproducible, Prisma validate/migrate check, backend build, frontend build/lint, test, dan smoke test Docker.
- [ ] Pindahkan semua secret/credential Compose ke `.env` atau secret manager; rotasi secret development yang pernah ditulis di konfigurasi dan dokumentasikan `.env.example` tanpa nilai rahasia.
- [ ] Tambahkan rate limiting, validasi ukuran/format upload, sanitasi input chat/review, security headers, dan audit log untuk perubahan role, produk, voucher, serta status order.
- [ ] Sediakan error handling terstandar, request ID, structured logging, health/readiness endpoint, dan monitoring untuk API, database, Redis, serta job gagal.

### Backlog prioritas P1 — Transaksi marketplace nyata
- [ ] Integrasikan payment gateway secara adapter-based dengan signature verification, idempotency key, webhook, status payment yang konsisten, expiry order, refund, dan rekonsiliasi.
- [ ] Buat modul shipping: alamat terstruktur, ongkir, kurir, nomor resi, tracking event, estimasi tiba, dan dukungan order multi-toko/split shipment.
- [ ] Tambahkan upload bukti transfer dan alur verifikasi admin bila manual transfer tetap dipertahankan.
- [ ] Perjelas state machine order/payment agar transisi ilegal ditolak dan perubahan status tercatat dalam riwayat.
- [ ] Tambahkan seller verification/KYC ringan, profil toko lengkap, jam operasional, lokasi peta, dan status toko buka/tutup.

### Backlog prioritas P1 — Pengalaman buyer & seller
- [ ] Selesaikan UI reviews/ratings, notification center, vouchers, dan chat; tambahkan unread count, pagination, dan empty/error states.
- [ ] Tambahkan wishlist/favorite, recently viewed, share produk, laporan produk, dan rekomendasi berdasarkan kategori/riwayat.
- [ ] Tambahkan varian produk, SKU, berat/dimensi, minimum order, stok per varian, dan riwayat perubahan harga.
- [ ] Tambahkan seller image upload dengan storage object/S3-compatible, thumbnail, validasi MIME, batas ukuran, dan penghapusan asset yatim.
- [ ] Tambahkan bulk product import/export, low-stock alert, promo seller, laporan CSV, dan dashboard tren penjualan.
- [ ] Migrasikan icon internal yang masih memakai `material-icons` ke komponen SVG bersama agar tidak ada icon literal saat font eksternal gagal.

### Backlog prioritas P1 — Mobile & aksesibilitas
- [ ] Selesaikan Flutter: login/register, detail produk, cart, checkout, order history, notifications, dan deep link.
- [ ] Jalankan `flutter analyze`, test, Android build, dan smoke test perangkat/emulator setelah Flutter SDK tersedia.
- [ ] Audit WCAG: keyboard navigation, focus state, contrast, semantic labels, alt text, error announcement, dan responsive layout pada mobile/tablet.
- [ ] Tambahkan PWA/offline read cache secara selektif untuk katalog dan halaman error/retry yang jelas.

### Backlog prioritas P2 — Scale, discovery & growth
- [ ] Tambahkan PostgreSQL full-text search yang terindeks; evaluasi Meilisearch/OpenSearch setelah volume katalog dan kebutuhan typo search meningkat.
- [ ] Tambahkan cache invalidation yang jelas untuk katalog, pagination/filter yang stabil, cursor pagination, dan query/index audit database.
- [ ] Tambahkan observability funnel: search → detail → cart → checkout → paid/completed, conversion seller, dan retention buyer tanpa menyimpan data sensitif berlebihan.
- [ ] Tambahkan loyalty/referral, bundling produk, subscription/recurring order, dan program kurasi produk lokal setelah transaksi inti stabil.
- [ ] Siapkan backup/restore PostgreSQL, disaster recovery runbook, object storage lifecycle, staging environment, dan deployment production yang repeatable.

### Urutan implementasi yang direkomendasikan
1. P0: test/regression, CI, secret hygiene, rate limit, logging, dan health checks.
2. P1 transaksi: payment gateway atau bukti transfer yang aman, shipping, dan order state history.
3. P1 UX: UI Growth, seller verification/profile, image upload, wishlist, dan varian produk.
4. P1 mobile: selesaikan alur end-to-end dan validasi device build.
5. P2: search scale, observability funnel, loyalty/referral, backup, dan production operations.

### Definition of Done untuk setiap fitur backlog
- Kontrak API/DTO dan authorization diuji.
- Migration/seed aman untuk data existing dan idempotent bila relevan.
- UI memiliki loading, empty, error, success, responsive, dan accessibility state.
- Test otomatis serta build/lint terkait berhasil.
- Docker/runtime smoke test dilakukan dan progress diperbarui berdasarkan output nyata.

---

## Sprint Plan (MVP)

| Sprint | Focus | Deliverable |
|--------|-------|-------------|
| Sprint 1 | Infrastructure & Docker | Docker Compose, project scaffolding |
| Sprint 2 | Authentication & Roles | JWT, register/login, role-based access |
| Sprint 3 | Marketplace, Store, Product, Category, Search | Buyer-side product discovery |
| Sprint 4 | Cart, Address, Checkout, Order | End-to-end order flow |
| Sprint 5 | Seller Dashboard | Seller management tools |
| Sprint 6 | Admin Dashboard | Moderation & management |
| Sprint 7 | Testing, Security, Deployment | Full system test & deploy |

---

## Design System Reference
All UI components follow the **Pasar.ID Design System** (`stitch_pasar.id_local_digital_marketplace/pasar.id_design_system/DESIGN.md`).

Key design tokens:
- Primary: `#154212` (Forest Green)
- Secondary: `#456800` (Fresh Leaf)
- Tertiary: `#52330f` (Burlap Brown)
- Background: `#fbf9f4` (Cream)
- Typography: Be Vietnam Pro + Work Sans
- Border radius: 0.25rem–full

---

## Repository Structure
```
Pasar Id -- Marketplace UMKM Local/
├── 01-Planning-PasarID.md
├── 02-PRD-PasarID.md
├── 03-MVP-PasarID.md
├── 04-Feature-Brief-PasarID.md
├── 05-Arsitektur-Brief-PasarID.md
├── 06-Teknologi-Brief-PasarID.md
├── progress.md
├── README.md
├── docker-compose.yml
├── stitch_pasar.id_local_digital_marketplace/
│   └── (mockup HTML + DESIGN.md)
├── nestjs-backend/
│   ├── src/
│   │   ├── app.module.ts
│   │   ├── main.ts
│   │   ├── config/
│   │   ├── modules/{auth,users,stores,products,orders}/
│   │   └── prisma/
│   ├── prisma/
│   │   ├── schema.prisma
│   │   ├── migrations/
│   │   └── seed.ts
│   ├── package.json
│   └── Dockerfile
├── nextjs-web/
│   ├── src/
│   │   ├── app/
│   │   │   ├── (products)/
│   │   │   ├── (stores)/
│   │   │   ├── (cart)/
│   │   │   ├── layout.tsx
│   │   │   └── globals.css  ← NEW
│   │   ├── components/
│   │   │   ├── Header.tsx
│   │   │   ├── Footer.tsx
│   │   │   └── AddToCartButton.tsx  ← NEW
│   │   └── contexts/
│   │       └── CartContext.tsx  ← NEW
│   ├── package.json
│   ├── Dockerfile
│   ├── tailwind.config.ts
│   └── postcss.config.js
└── .git/
```

---

## Environment
- Docker Compose running:
  - pasar-id-api (NestJS, port 3000)
  - pasar-id-web (Next.js, port 3001)
  - pasar-id-db (PostgreSQL 16, port 5432)
  - pasar-id-redis (Redis 7, port 6379)
  - pasar-id-phpmyadmin (port 8080)
- Database: plasaid_dev
  - User: plasaid (superuser)
  - Tables: users, stores, products, categories, orders, order_items, refresh_tokens, _prisma_migrations
- API routes: base URL http://localhost:3000 (no /api prefix)
  - Auth: /auth/register, /auth/login
  - Products: GET /products, GET /products/:id, GET /products/slug/:slug
  - Stores: GET /stores, GET /stores/:id
- .env file: CREATED (nestjs-backend/.env, nextjs-web/.env.local) — runtime using Docker env vars + local .env

---

## Notes
- All mockup HTML files use Tailwind CSS CDN and are standalone static pages
- Screenshots accompany each page in `screen.png` files
- Design system is documented in `DESIGN.md` under `stitch_pasar.id_local_digital_marketplace/`
- Project follows Modular Monolith architecture pattern
- One backend (NestJS), multiple clients (Next.js Web + Flutter Mobile)
- Database migrations completed, all tables created
- Next.js frontend: product listing, detail, stores, cart, checkout, auth pages sudah deployed di http://localhost:3001
- Header & Footer components sudah siap pakai
- .env file: CREATED (nestjs-backend/.env, nextjs-web/.env.local)
- **GitHub repo:** github.com/zerone19/Pasar.id----Local-UMKM-Marketplace
- **Latest verified scope:** Phase 1–4 audit fixes — checkout, RBAC, data exposure, stock validation, seller metrics, and missing frontend routes
- **Latest verification:** NestJS build, Next.js production build, Docker smoke test, protected endpoint checks, and passwordHash exposure check
- **Next milestone:** Phase 5 — Admin dashboard and marketplace moderation

---
*Last updated: September 21, 2026*
*Project owner: Ascjul Opreker (Ascjul Zerone)*