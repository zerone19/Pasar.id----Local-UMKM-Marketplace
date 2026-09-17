# Pasar.ID 🛒

**Pasar Lokal yang Hidup di Dunia Digital.**

> *"Gotong Royong Memajukan UMKM Indonesia"*

Pasar.ID adalah marketplace UMKM lokal yang menghubungkan pedagang pasar tradisional, pelaku UMKM, dan masyarakat dalam satu ekosistem digital. Temukan kesegaran sayur mayur, kelezatan jajanan pasar, dan keunikan kerajinan tangan dari ribuan penjual lokal terpercaya.

---

## 🎯 Visi & Misi

**Visi:** Menjadi platform marketplace lokal terbesar di Indonesia yang memberdayakan UMKM.

**Misi:**
- Mendigitalisasi pasar tradisional dan UMKM lokal
- Menghubungkan pembeli dengan produk lokal berkualitas
- Membangun ekosistem ekonomi yang adil dan berkelanjutan
- Memperkenalkan kekayaan lokal ke pasar yang lebih luas

---

## 🏗️ Tech Stack

| Layer | Technology |
|-------|-----------|
| **Web Frontend** | Next.js + TypeScript + React + Tailwind CSS |
| **Mobile** | Flutter + Dart (Android & iOS) |
| **Backend API** | NestJS + TypeScript |
| **Database** | PostgreSQL |
| **ORM** | Prisma |
| **Cache & Queue** | Redis + BullMQ |
| **Storage** | S3-compatible (Cloudflare R2, AWS S3, dll) |
| **Authentication** | JWT access + refresh token |
| **Infrastructure** | Docker + Docker Compose |
| **API Documentation** | OpenAPI/Swagger |
| **Search** | PostgreSQL (MVP) → Meilisearch/OpenSearch (growth) |
| **Design System** | Pasar.ID Design System |

**Arsitektur:** Modular Monolith — *One Backend, Multiple Clients*

---

## 📋 Fitur Utama

### 👤 Untuk Pembeli (Buyer)
- Register & login dengan email/HP
- Jelajahi produk lokal berdasarkan kategori
- Pencarian & filter canggih
- Detail produk & toko
- Keranjang belanja multi-seller
- Checkout dengan COD & transfer manual
- Riwayat pesanan
- Profil & alamat
- Review & rating

### 🏪 Untuk Penjual (Seller/UMKM)
- Register & verifikasi toko
- Dashboard toko (overview, produk, pesanan, revenue)
- Kelola produk (CRUD, stok, gambar, harga)
- Manajemen pesanan
- Statistik & laporan penjualan
- Profil toko (lokasi, jam operasional, reputasi)

### 🛡️ Untuk Admin
- Dashboard admin
- Manajemen pengguna & seller
- Verifikasi toko
- Moderasi produk & kategori
- Pantau pesanan
- Laporan & analytics

---

## 📐 Arsitektur

```
┌─────────────────────────────────────────────┐
│              CLIENTS                        │
│                                             │
│   ┌──────────┐      ┌──────────────┐       │
│   │ Next.js  │◄────►│   NestJS     │◄──────┐
│   │  Web     │  API │    API       │       │
│   └──────────┘      └──────┬───────┘       │
│                            │               │
│   ┌──────────┐      ┌─────▼───────┐       │
│   │ Flutter  │      │             │       │
│   │ Mobile   │◄────►│             │       │
│   └──────────┘      └─────┬───────┘       │
│                            │               │
└────────────────────────────┼───────────────┘
                             │
              ┌──────────────▼───────────────┐
              │         INFRASTRUCTURE        │
              │                              │
              │   ┌──────────┐  ┌──────────┐ │
              │   │PostgreSQL│  │   Redis  │ │
              │   │          │  │          │ │
              │   └──────────┘  └──────────┘ │
              │   ┌──────────┐  ┌──────────┐ │
              │   │  S3      │  │  BullMQ  │ │
              │   │ Storage  │  │  Queue   │ │
              │   └──────────┘  └──────────┘ │
              └──────────────────────────────┘
```

---

## 🚀 Tahapan Pengembangan

| Phase | Fokus | Status |
|-------|-------|--------|
| **Phase 0** | Planning & Design | ✅ Selesai |
| **Phase 1** | Foundation (Docker, Auth, DB) | 🔜 Selanjutnya |
| **Phase 2** | Marketplace (Product, Store, Category) | 📋 Planned |
| **Phase 3** | Transaction (Cart, Checkout, Order) | 📋 Planned |
| **Phase 4** | Seller (Dashboard, Product Mgmt) | 📋 Planned |
| **Phase 5** | Admin (Management, Moderation) | 📋 Planned |
| **Phase 6** | Mobile (Flutter App) | 📋 Planned |
| **Phase 7** | Growth (Notifications, Reviews, etc.) | 📋 Planned |

### MVP Sprint Plan

| Sprint | Deliverable |
|--------|-------------|
| Sprint 1 | Infrastructure & Docker |
| Sprint 2 | Authentication & Roles |
| Sprint 3 | Marketplace, Store, Product, Category |
| Sprint 4 | Cart, Address, Checkout, Order |
| Sprint 5 | Seller Dashboard |
| Sprint 6 | Admin Dashboard |
| Sprint 7 | Testing, Security, Deployment |

---

## 🎨 Design System

Pasar.ID menggunakan **Pasar.ID Design System** yang terinspirasi dari filosofi *"Gotong Royong"* dan kekayaan pasar tradisional Indonesia.

### Palet Warna
- **Primary:** Forest Green `#154212` — kedalaman daun pisang matang
- **Secondary:** Fresh Leaf `#456800` — energi segar
- **Tertiary:** Burlap Brown `#52330f` — kehangatan kerajinan
- **Background:** Cream `#fbf9f4` — kelembutan kertas minyak
- **Functional:** Error terracotta, warning turmeric

### Tipografi
- **Headlines:** Be Vietnam Pro
- **Labels/Data:** Work Sans
- **Sistem spacing:** 8px base unit
- **Border radius:** 0.25rem–full (organik, hangat)

### Filosofi Visual
**Tactile Minimalism** — grounded in earth, not sterile corporate. Menggunakan tekstur organik (anyaman bambu, daun) sebagai latar belakang halus, dan *tonal layers* alih-alih shadow buatan.

Detail lengkap: [`stitch_pasar.id_local_digital_marketplace/pasar.id_design_system/DESIGN.md`](stitch_pasar.id_local_digital_marketplace/pasar.id_design_system/DESIGN.md)

---

## 📂 Struktur Project

```
Pasar Id -- Marketplace UMKM Local/
├── 01-Planning-PasarID.md              → Gambaran umum & roadmap
├── 02-PRD-PasarID.md                   → Product requirements
├── 03-MVP-PasarID.md                   → Minimum viable product
├── 04-Feature-Brief-PasarID.md         → Ringkasan fitur
├── 05-Arsitektur-Brief-PasarID.md      → Arsitektur sistem
├── 06-Teknologi-Brief-PasarID.md       → Tech stack & alasan
├── progress.md                          → Progress tracker
├── README.md                            → File ini
├── stitch_pasar.id_local_digital_marketplace/
│   ├── pasar.id_design_system/
│   │   └── DESIGN.md                   → Design system documentation
│   ├── beranda_pasar.id/               → Homepage mockup
│   ├── daftar_produk_umkm/             → Product catalog mockup
│   ├── daftar_mitra_umkm_pasar.id/     → Seller login/register mockup
│   ├── daftar_pembeli_pasar.id/        → Buyer registration mockup
│   ├── masuk_daftar_pembeli_pasar.id/  → Buyer login mockup
│   ├── detail_produk_pasar.id/         → Product detail mockup
│   ├── keranjang_belanja_pasar.id/     → Shopping cart mockup
│   ├── dashboard_penjual_pasar.id/     → Seller dashboard mockup
│   ├── profil_umkm_pasar.id/           → Seller profile mockup
│   ├── manajemen_produk_umkm_pasar.id/ → Product management mockup
│   ├── riwayat_transaksi_penjual_pasar.id/ → Order history mockup
│   └── logo_pasar_id.png/              → Logo screen mockup
└── .git/
```

---

## 🔧 Quick Start (Development)

### Prasyarat
- Docker & Docker Compose
- Node.js 18+
- Flutter SDK (untuk mobile development)
- PostgreSQL
- Redis

### Mulai Development
```bash
# Clone repository
git clone https://github.com/zerone19/Pasar.id----Local-UMKM-Marketplace.git
cd Pasar.Id----Local-UMKM-Marketplace

# Mulai semua layanan dengan Docker
docker-compose up -d

# Setup database
npx prisma migrate dev

# Jalankan backend API
cd api && npm run start:dev

# Jalankan web frontend
cd web && npm run dev

# Jalankan mobile app (Flutter)
cd mobile && flutter run
```

> **Catatan:** Backend API, web, dan mobile dapat dijalankan secara terpisah karena berbasis REST API.

---

## 🤝 Kontribusi

Kontribusi sangat diterima! Silakan buka *issue* atau *pull request* untuk:
- Perbaikan bug
- Fitur baru
- Dokumentasi
- Peningkatan desain

Harap ikuti standar coding yang sudah ditentukan dalam dokumen arsitektur dan PRD.

---

## 📄 Lisensi

Project ini dilisensikan di bawah MIT License. Lihat file [LICENSE](LICENSE) untuk detail lebih lanjut.

---

## 📬 Hubungi Kami

- **Project Owner:** Ascjul Opreker (Ascjul Zerone)
- **Repository:** [github.com/zerone19/Pasar.id----Local-UMKM-Marketplace](https://github.com/zerone19/Pasar.id----Local-UMKM-Marketplace)
- **Email:** [kontak@bisa-melalui-issue.github.com]

---

*Dibangun dengan ❤️ untuk UMKM Indonesia*
