# Pasar.ID — Project Progress Tracker

## Project Overview
Pasar.ID adalah marketplace UMKM lokal berbasis multi-vendor e-commerce.

**Tagline:** "Gotong Royong Memajukan UMKM Indonesia"

## Tech Stack
- **Backend:** NestJS + TypeScript (REST API)
- **Frontend:** Next.js 14 + TypeScript + React + Tailwind CSS
- **Mobile (planned):** Flutter + Dart
- **Database:** PostgreSQL + Prisma ORM
- **Cache:** Redis
- **Auth:** JWT access + refresh token
- **Infra:** Docker + Docker Compose

## 📊 Status Terkini

### Backend — NestJS API (port 3000) ✅
- Docker Compose running
- PostgreSQL + Prisma migrations applied (8 tables)
- Modul: Auth, Users, Stores, Products, Orders
- ValidationPipe + DTOs aktif
- CORS untuk localhost:3001

### Frontend — Next.js (port 3001) ✅
- Docker container running
- Tailwind CSS terpasan
- Next.js 14 + App Router
- **Home page sudah ter-implement**: Hero section, Categories, Featured UMKM
- Header & Footer components siap pakai
- **BELUM ada**: Product listing, Store listing, Cart, Product detail, Auth pages

### Issues
- `.env` file tidak ada (pakai fallback config)

## 📋 Phase & Milestone Breakdown

### ✅ Phase 0 — Planning & Dokumen (SELESAI)
- [x] 01-Planning-PasarID.md — Gambaran umum, target platform, roadmap
- [x] 02-PRD-PasarID.md — Product requirements document
- [x] 03-MVP-PasarID.md — Minimum viable product definition
- [x] 04-Feature-Brief-PasarID.md — Ringkasan modul & fitur
- [x] 05-Arsitektur-Brief-PasarID.md — Arsitektur cross-platform
- [x] 06-Teknologi-Brief-PasarID.md — Technology stack & alasan
- [x] Pasar.ID Design System (DESIGN.md)
- [x] 15 halaman mockup HTML (Tailwind CSS)
- [x] Git repo + GitHub push

### ✅ Phase 1a — Backend Foundation (SELESAI)
- [x] Docker Compose setup (api, web, db, redis, phpmyadmin)
- [x] PostgreSQL database with schema migrations
- [x] Redis cache
- [x] NestJS API server (port 3000)
  - [x] Auth (JWT, register, login)
  - [x] Users (CRUD)
  - [x] Stores (CRUD)
  - [x] Products (CRUD)
  - [x] Orders (CRUD)
- [x] Prisma ORM with schema & migrations
- [x] ValidationPipe with DTOs
- [x] Swagger (di dependencies)
- [x] CORS configured untuk localhost:3001
- [x] Semua database tables created & migrations applied

### ✅ Phase 1b — Frontend Foundation (SELESAI)
- [x] Next.js 15 project initialized
- [x] Tailwind CSS configured
- [x] Docker container running (port 3001)

### ✅ Phase 1c — Frontend Pages (HOMPAGE SELESAI)
- [x] Home page (`app/page.tsx`) — HERO, Categories, Featured UMKM
- [x] Header component (`components/Header.tsx`) — design system compliant
- [x] Footer component (`components/Footer.tsx`) — full footer
- [ ] Products listing (`app/products/page.tsx`)
- [ ] Stores listing (`app/stores/page.tsx`)
- [ ] Cart (`app/cart/page.tsx`)
- [ ] Product detail (`app/products/[id]/page.tsx`)
- [ ] Login/Register (`app/auth/login/page.tsx`, `app/auth/register/page.tsx`)

### 🔜 .env Setup
- [ ] Buat file `.env` untuk NestJS backend
- [ ] Konfigurasi DATABASE_URL, JWT_SECRET, REDIS_URL
- [ ] Buat file `.env.local` untuk Next.js
- [ ] Pastikan koneksi database stabil

### 🔜 Phase 2 — Marketplace
- [ ] Product CRUD API (endpoint tambahan)
- [ ] Category management
- [ ] Search & filter API
- [ ] Store/profile management
- [ ] Integrasi API → Frontend (semua pages di atas)

### 🔜 Phase 3 — Transaction
- [ ] Cart (multi-seller support)
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
│   │   └── seed.{ts,js}
│   ├── package.json
│   └── Dockerfile
├── nextjs-web/
│   ├── src/
│   ├── package.json
│   ├── Dockerfile
│   └── tailwind.config.ts
└── .git/
```

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
- .env file: NOT FOUND (runtime using fallback config values)

## Notes
- All mockup HTML files use Tailwind CSS CDN and are standalone static pages
- Screenshots accompany each page in `screen.png` files
- Design system is documented in `DESIGN.md` under `stitch_pasar.id_local_digital_marketplace/`
- Project follows Modular Monolith architecture pattern
- One backend (NestJS), multiple clients (Next.js Web + Flutter Mobile)
- Database migrations completed, all tables created
- Next.js 14 frontend: Home page sudah terdeploy di http://localhost:3001
- Header & Footer components sudah siap pakai
- .env file missing, using fallback configuration values

---
*Last updated: September 17, 2026*
*Project owner: Ascjul Opreker (Ascjul Zerone)*