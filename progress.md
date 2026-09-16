# Pasar.ID — Project Progress Tracker

## Project Overview
Pasar.ID adalah marketplace UMKM lokal berbasis multi-vendor e-commerce yang menghubungkan pedagang pasar tradisional, UMKM, dan pembeli dalam satu ekosistem digital.

**Tagline:** "Gotong Royong Memajukan UMKM Indonesia"

## Tech Stack
- **Web Frontend:** Next.js + TypeScript + React + Tailwind CSS
- **Mobile:** Flutter + Dart (Android/iOS)
- **Backend:** NestJS + TypeScript (REST API)
- **Database:** PostgreSQL + Prisma ORM
- **Cache/Queue:** Redis + BullMQ
- **Storage:** S3-compatible object storage
- **Auth:** JWT access + refresh token
- **Infra:** Docker + Docker Compose
- **Design:** Pasar.ID Design System (Material Symbols + Tailwind)

## Current Phase: Phase 1 — Foundation ✅

### ✅ Completed (Phase 0)
- [x] 01-Planning-PasarID.md — Gambaran umum, target platform, roadmap
- [x] 02-PRD-PasarID.md — Product requirements document
- [x] 03-MVP-PasarID.md — Minimum viable product definition
- [x] 04-Feature-Brief-PasarID.md — Ringkasan modul & fitur
- [x] 05-Arsitektur-Brief-PasarID.md — Arsitektur cross-platform
- [x] 06-Teknologi-Brief-PasarID.md — Technology stack & alasan pemilihan
- [x] Pasar.ID Design System (DESIGN.md)
- [x] 15 halaman mockup HTML (Tailwind CSS) — `stitch_pasar.id_local_digital_marketplace/`
- [x] Git repo initialized & initial commit
- [x] progress.md
- [x] README.md
- [x] GitHub repo created & pushed to `main` branch

### ✅ Phase 1 — Foundation (Completed)
- [x] Docker Compose setup (api, web, db, redis, phpmyadmin)
- [x] PostgreSQL database with schema migrations
- [x] Redis cache/queue
- [x] NestJS API server (port 3000) with 5 modules:
  - [x] Auth (JWT, register, login)
  - [x] Users (CRUD)
  - [x] Stores (CRUD)
  - [x] Products (CRUD)
  - [x] Orders (CRUD)
- [x] Prisma ORM with schema & migrations
- [x] Next.js Web frontend (port 3001)
  - [x] Home page
  - [x] Products page
  - [x] Stores page
  - [x] Cart page
- [x] Dockerfiles for API and Web
- [x] Shared types
- [x] DTOs for validation
- [x] phpMyAdmin (port 8080)
- [x] GitHub push completed

### 🔜 Upcoming Phases

#### Phase 2 — Marketplace
- [ ] Setup Docker Compose (NestJS API, Next.js Web, PostgreSQL, Redis)
- [ ] Initialize Prisma schema & migrations
- [ ] Setup authentication module (JWT, roles)
- [ ] Project scaffolding (modules: Auth, Users, Stores, Products, Orders, etc.)

#### Phase 2 — Marketplace
- [ ] Product CRUD API
- [ ] Category management
- [ ] Search & filter
- [ ] Store/profile management
- [ ] Homepage & category pages (Next.js)

#### Phase 3 — Transaction
- [ ] Cart (multi-seller support)
- [ ] Checkout flow
- [ ] Address management
- [ ] Order lifecycle (PENDING → CONFIRMED → PROCESSING → READY/SHIPPED → COMPLETED)
- [ ] Payment abstraction (MVP: COD + Manual Transfer)

#### Phase 4 — Seller
- [ ] Seller dashboard (products, orders, stock, revenue)
- [ ] Order management
- [ ] Store management

#### Phase 5 — Admin
- [ ] Admin dashboard
- [ ] User/seller management
- [ ] Product moderation
- [ ] Order monitoring

#### Phase 6 — Mobile
- [ ] Flutter customer app
- [ ] Shared API integration

#### Phase 7 — Growth
- [ ] Notifications
- [ ] Reviews & ratings
- [ ] Vouchers & promotions
- [ ] Analytics
- [ ] Chat

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

## Design System Reference
All UI components follow the **Pasar.ID Design System** (`stitch_pasar.id_local_digital_marketplace/pasar.id_design_system/DESIGN.md`).

Key design tokens:
- Primary: `#154212` (Forest Green)
- Secondary: `#456800` (Fresh Leaf)
- Tertiary: `#52330f` (Burlap Brown)
- Background: `#fbf9f4` (Cream)
- Typography: Be Vietnam Pro + Work Sans
- Border radius: 0.25rem–full

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
├── stitch_pasar.id_local_digital_marketplace/
│   ├── pasar.id_design_system/
│   │   └── DESIGN.md
│   ├── beranda_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── daftar_produk_umkm/
│   │   ├── code.html
│   │   └── screen.png
│   ├── daftar_mitra_umkm_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── daftar_pembeli_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── masuk_daftar_pembeli_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── detail_produk_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── keranjang_belanja_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── dashboard_penjual_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── profil_umkm_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── manajemen_produk_umkm_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   ├── riwayat_transaksi_penjual_pasar.id/
│   │   ├── code.html
│   │   └── screen.png
│   └── logo_pasar_id.png/
│       └── screen.png
└── .git/
```

## Notes
- All mockup HTML files use Tailwind CSS CDN and are standalone static pages
- Screenshots accompany each page in `screen.png` files
- Design system is documented in `DESIGN.md` under `pasar.id_design_system/`
- Project follows Modular Monolith architecture pattern
- One backend (NestJS), multiple clients (Next.js Web + Flutter Mobile)

---
*Last updated: September 16, 2026*
*Project owner: Ascjul Opreker (Ascjul Zerone)*
