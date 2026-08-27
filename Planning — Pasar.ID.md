# PLANNING
## Pasar.ID — Marketplace UMKM Lokal

### 1. Gambaran Umum

**Pasar.ID** adalah platform marketplace yang menghubungkan UMKM lokal, pedagang pasar tradisional, dan masyarakat melalui platform digital.

Konsep utama:

> **“Pasar tradisional, pengalaman digital.”**

Pasar.ID memungkinkan masyarakat menemukan produk lokal, melihat katalog pedagang, melakukan pemesanan, dan berkomunikasi dengan penjual tanpa harus datang langsung ke pasar.

Platform dirancang agar dapat berkembang dari marketplace sederhana menjadi ekosistem digital UMKM lokal.

---

## 2. Visi

Menjadi platform digital yang membantu UMKM dan pedagang lokal memperluas pasar tanpa kehilangan karakter khas pasar tradisional.

## 3. Misi

1. Mendigitalisasi katalog produk UMKM lokal.
2. Membantu pedagang menjangkau pelanggan lebih luas.
3. Mempermudah masyarakat membeli produk lokal.
4. Membantu UMKM mengelola produk dan pesanan.
5. Membangun ekosistem marketplace lokal yang terpercaya.
6. Mendorong pertumbuhan ekonomi digital masyarakat lokal.

---

# 4. Target Pengguna

### A. Pembeli

Masyarakat yang ingin:

- mencari produk lokal;
- membeli kebutuhan sehari-hari;
- menemukan UMKM di sekitar mereka;
- melihat harga dan katalog;
- melakukan pemesanan secara online.

### B. Penjual

Target utama:

- pedagang pasar tradisional;
- UMKM makanan;
- UMKM fashion;
- toko kelontong;
- pengrajin;
- penjual hasil pertanian;
- penjual produk rumahan.

### C. Admin

Bertugas mengelola:

- pengguna;
- toko;
- produk;
- kategori;
- pesanan;
- transaksi;
- konten marketplace;
- laporan;
- moderasi.

---

# 5. Konsep Marketplace

Pasar.ID menggunakan konsep **multi-vendor marketplace**.

Struktur:

```text
Pasar.ID
│
├── Pembeli
│
├── Marketplace
│   ├── Kategori
│   ├── Produk
│   ├── Toko
│   └── Pencarian
│
├── Penjual
│   ├── Dashboard
│   ├── Produk
│   ├── Pesanan
│   └── Profil Toko
│
└── Admin
    ├── Dashboard
    ├── User
    ├── Seller
    ├── Produk
    ├── Pesanan
    └── Laporan
```

---

# 6. Tahapan Pengembangan

## Phase 1 — Foundation

Fokus:

- setup Laravel;
- Docker;
- database;
- authentication;
- role management;
- struktur marketplace.

Output:

- Laravel berjalan;
- database berjalan;
- user dapat login/register;
- role Buyer, Seller, Admin tersedia.

---

## Phase 2 — Marketplace Core

Fokus:

- kategori;
- produk;
- toko;
- pencarian;
- detail produk;
- keranjang.

Output:

Pembeli sudah dapat menjelajahi marketplace dan memasukkan produk ke keranjang.

---

## Phase 3 — Transaction

Fokus:

- checkout;
- order;
- status pesanan;
- pembayaran;
- alamat;
- riwayat transaksi.

Output:

Pembeli dapat melakukan transaksi.

---

## Phase 4 — Seller System

Fokus:

- seller dashboard;
- CRUD produk;
- manajemen stok;
- pesanan;
- profil toko.

Output:

UMKM dapat mengelola toko secara mandiri.

---

## Phase 5 — Admin System

Fokus:

- admin dashboard;
- moderasi;
- manajemen pengguna;
- manajemen seller;
- laporan transaksi.

---

## Phase 6 — Growth

Fitur lanjutan:

- voucher;
- promo;
- rating;
- review;
- chat;
- notifikasi;
- kurir;
- pembayaran digital;
- analitik UMKM;
- rekomendasi produk.

---

# 7. Teknologi

### Backend

- Laravel
- PHP
- Laravel Sanctum
- Laravel Queue
- Laravel Scheduler

### Database

- MySQL / MariaDB

### Frontend

Pilihan awal:

- Blade
- Tailwind CSS
- Alpine.js

Alternatif pengembangan:

- Laravel + Inertia
- React
- Vue

### Infrastructure

```text
Docker
├── Laravel / PHP
├── Nginx / Apache
├── MySQL
└── phpMyAdmin
```

### Development Tools

- Git
- GitHub
- Docker Compose
- Composer
- NPM

---

# 8. Prinsip Pengembangan

Pasar.ID harus:

- mobile-first;
- mudah digunakan;
- ringan;
- ramah pengguna awam;
- mudah digunakan oleh UMKM;
- scalable;
- aman;
- modular;
- API-ready.

---

# 9. KPI Awal

Target MVP:

| KPI | Target |
|---|---:|
| Seller terdaftar | 10+ |
| Produk aktif | 50+ |
| Pembeli terdaftar | 50+ |
| Pesanan | 25+ |
| Seller aktif | >60% |
| Produk dengan gambar | >90% |

---

# 10. Roadmap

```text
FOUNDATION
    ↓
AUTHENTICATION
    ↓
MARKETPLACE
    ↓
PRODUCT
    ↓
CART
    ↓
CHECKOUT
    ↓
ORDER
    ↓
SELLER DASHBOARD
    ↓
ADMIN DASHBOARD
    ↓
PAYMENT
    ↓
REVIEW
    ↓
PROMOTION
    ↓
ECOSYSTEM
```

---

# 11. Definition of Success

MVP dianggap berhasil apabila:

1. User dapat melakukan registrasi.
2. Seller dapat membuat toko.
3. Seller dapat menambahkan produk.
4. Pembeli dapat menemukan produk.
5. Pembeli dapat memasukkan produk ke keranjang.
6. Pembeli dapat melakukan checkout.
7. Sistem dapat membuat order.
8. Seller dapat melihat order.
9. Admin dapat mengelola marketplace.
10. Seluruh sistem dapat dijalankan menggunakan Docker.