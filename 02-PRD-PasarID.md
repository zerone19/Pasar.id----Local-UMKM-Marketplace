PRODUCT REQUIREMENTS DOCUMENT — PASAR.ID

Product Requirements untuk Marketplace UMKM Lokal

## 1. Product Overview
Nama: Pasar.ID. Kategori: Local Marketplace / Multi-Vendor E-Commerce. Platform: Web, Android, iOS. Backend: NestJS. Web: Next.js. Mobile: Flutter. Database: PostgreSQL. Cache/Queue: Redis. Infrastructure: Docker.

## 2. Problem Statement
UMKM dan pedagang tradisional sering memiliki jangkauan pelanggan terbatas, katalog yang tidak terstruktur, transaksi manual, informasi stok/harga yang tidak konsisten, serta belum memiliki pusat marketplace lokal. Pasar.ID menyediakan satu platform untuk mendigitalisasi toko dan transaksi lokal.

## 3. User Roles
Buyer: mencari dan membeli produk. Seller: mengelola toko, produk, stok, dan pesanan. Admin: mengelola pengguna, seller, toko, kategori, produk, pesanan, dan moderasi. Courier dapat ditambahkan pada fase berikutnya.

## 4. Functional Requirements
Authentication: register, login, logout, reset password, email verification, JWT, role-based authorization.

Store: profil toko, logo, banner, alamat/lokasi, jam operasional, status.

Product: CRUD, gambar, harga, stok, SKU, berat, kategori, status.

Marketplace: homepage, kategori, pencarian, filter, produk, toko.

Cart: multi-product, quantity, subtotal.

Checkout: alamat, metode pembayaran, catatan, ringkasan.

Order: nomor order, seller order, item, status pembayaran, status pesanan.

Seller Dashboard: produk, order, stok, revenue.

Admin Dashboard: user, seller, store, product, category, order, laporan.

## 5. Multi-Vendor Order
Keranjang dapat berisi produk dari beberapa seller. Saat checkout, parent order dapat dipecah menjadi seller order berdasarkan toko. Hal ini penting untuk pembayaran, fulfillment, status, dan perhitungan pengiriman per seller.

## 6. Non-Functional Requirements
Performance: pagination, indexing, image optimization, caching sesuai kebutuhan. Security: validation, authorization, rate limiting, secure upload, password hashing. Scalability: API versioning, modular backend, Redis, queue, object storage, dan managed infrastructure.

## 7. Acceptance Criteria
Fitur selesai jika validasi berjalan, data konsisten, role tidak dapat mengakses resource yang tidak berwenang, UI responsive, API terdokumentasi, error handling tersedia, dan sistem dapat dijalankan menggunakan Docker.

Pasar.ID — Project Documentation
