# Pasar.ID — Project Progress Tracker

## Project Overview
Pasar.ID adalah marketplace UMKM lokal berbasis multi-vendor e-commerce.

**Tagline:** "Gotong Royong Memajukan UMKM Indonesia"

---

## 📊 STATUS TERKINI — 20 September 2026

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
*Last updated: September 20, 2026*
*Project owner: Ascjul Opreker (Ascjul Zerone)*