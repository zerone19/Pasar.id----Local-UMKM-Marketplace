FEATURE BRIEF — PASAR.ID

Ringkasan Modul dan Fitur Produk

## 1. Marketplace
Homepage, kategori, produk populer/terbaru, toko lokal, pencarian, filter, dan detail produk.

## 2. Authentication & Account
Register/login, password reset, verification, profile, address, session/token management, dan role-based access.

## 3. Seller Store
Halaman toko UMKM berisi profil, produk, lokasi, jam operasional, status, dan informasi reputasi.

## 4. Product Management
Seller dapat membuat, melihat, mengubah, menghapus, mengaktifkan/nonaktifkan produk, mengelola gambar, harga, SKU, berat, dan stok.

## 5. Cart & Checkout
Cart mendukung beberapa produk dan seller. Checkout menampilkan alamat, seller grouping, subtotal, biaya pengiriman, metode pembayaran, dan total.

## 6. Order Management
Order lifecycle: PENDING → CONFIRMED → PROCESSING → READY/SHIPPED → COMPLETED, dengan CANCELLED sebagai jalur pembatalan.

## 7. Payment
MVP: COD dan manual transfer. Arsitektur PaymentService dibuat berbasis abstraction agar provider seperti QRIS/payment gateway dapat ditambahkan kemudian.

## 8. Shipping
MVP: pickup dan local delivery. Fase berikutnya dapat mengintegrasikan courier API, tarif, tracking, dan delivery status.

## 9. Review & Rating
Pembeli dapat memberi rating/review setelah order selesai. Dapat diterapkan pada produk dan toko.

## 10. Notification
Event seperti order dibuat, pembayaran diterima, order dikonfirmasi, order dikirim, order selesai, dan seller disetujui. Redis Queue dapat digunakan untuk pekerjaan asynchronous.

## 11. Promotion
Future: voucher, diskon, flash sale, store promotion, platform promotion, dan sponsored product.

## 12. Search
MVP menggunakan PostgreSQL search. Jika katalog tumbuh besar, dapat dipindahkan/ditingkatkan dengan Meilisearch atau OpenSearch.

Pasar.ID — Project Documentation
