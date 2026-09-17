# Pasar.ID — Project Progress Tracker

## Project Overview
Pasar.ID adalah marketplace UMKM lokal berbasis multi-vendor e-commerce.

**Tagline:** "Gotong Royong Memajukan UMKM Indonesia"

---

## 📊 STATUS TERKINI — 17 September 2026

### Backend — NestJS API (port 3000) ✅ JALAN
- Docker Compose running
- PostgreSQL 16 + Prisma migrations applied (8 tables)
- Modul: Auth, Users, Stores, Products, Orders (semua endpoint OK)
- ValidationPipe + DTOs aktif
- CORS untuk localhost:3001 — sudah diverifikasi
- **Fix kritis:** Hapus @nestjs/swagger v12 yang crash (loadPackageSync mismatch)
- Seeder jalan — 4 products, 3 users (admin/seller/buyer), 3 categories, 1 store
- Endpoint baru: `GET /products/slug/:slug`

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
- **Header** — sudah update: link ke rute nyata, cart badge dinamis via CartContext
- AddToCartButton komponen — quantity picker + dynamic state
- CartContext — React Context + useReducer + localStorage persistence

### Issues / yang perlu diperhatikan
- `.env` file backend masih pakai fallback config (bukan critical — runtime via Docker env vars)
- `nestjs-backend/src/prisma/seed.ts` (file anomali) sudah dihapus
- Frontend: auth pages (login/register) belum ada — ada stub route di header
- Checkout flow (order creation) belum terintegrasi

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
- [ ] Login/Register (`app/auth/login/page.tsx`, `app/auth/register/page.tsx`)

### 🔜 .env Setup
- [ ] Buat file `.env` untuk NestJS backend
- [ ] Konfigurasi DATABASE_URL, JWT_SECRET, REDIS_URL
- [ ] Buat file `.env.local` untuk Next.js
- [ ] Pastikan koneksi database stabil

### 🔜 Phase 2 — Marketplace
- [x] Product CRUD API (sudah ada)
- [ ] Category management
- [ ] Search & filter API
- [ ] Store/profile management
- [x] Integrasi API → Frontend (products, stores, cart pages sudah jalan)

### 🔜 Phase 3 — Transaction
- [x] Cart (multi-seller support — Context + localStorage)
- [ ] Checkout flow
- [ ] Address management
- [ ] Order lifecycle (PENDING → CONFIRMED → PROCESSING → READY/SHIPPED → COMPLETED)
- [ ] Payment abstraction (MVP: COD + Manual Transfer)

### 🔜 Phase 4 — Seller
- [ ] Seller dashboard (products, orders, stock, revenue)
- [ ] Order management
- [ ] Store management

### 🔜 Phase 5 — Admin
- [ ] Admin dashboard
- [ ] User/seller management
- [ ] Product moderation
- [ ] Order monitoring

### 🔜 Phase 6 — Mobile
- [ ] Flutter customer app
- [ ] Shared API integration

### 🔜 Phase 7 — Growth
- [ ] Notifications
- [ ] Reviews & ratings
- [ ] Vouchers & promotions
- [ ] Analytics
- [ ] Chat

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
- .env file: NOT FOUND (runtime using fallback / Docker env vars)

---

## Notes
- All mockup HTML files use Tailwind CSS CDN and are standalone static pages
- Screenshots accompany each page in `screen.png` files
- Design system is documented in `DESIGN.md` under `stitch_pasar.id_local_digital_marketplace/`
- Project follows Modular Monolith architecture pattern
- One backend (NestJS), multiple clients (Next.js Web + Flutter Mobile)
- Database migrations completed, all tables created
- Next.js frontend: product listing, detail, stores, cart pages sudah deployed di http://localhost:3001
- Header & Footer components sudah siap pakai
- .env file missing, using fallback configuration values
- **GitHub repo:** github.com/zerone19/Pasar.id----Local-UMKM-Marketplace
- **Latest commit:** 549a076 — feat: cart system, product detail, stores listing, header fix

---
*Last updated: September 17, 2026*
*Project owner: Ascjul Opreker (Ascjul Zerone)*