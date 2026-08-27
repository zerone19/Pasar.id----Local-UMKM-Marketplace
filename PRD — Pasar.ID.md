# PRODUCT REQUIREMENTS DOCUMENT
## Pasar.ID — Marketplace UMKM Lokal

### 1. Product Overview

**Nama:** Pasar.ID

**Kategori:** Local Marketplace / Multi-Vendor E-Commerce

**Platform:** Web

**Backend:** Laravel

**Infrastructure:** Docker

**Database:** MySQL / MariaDB

---

# 2. Problem Statement

Banyak UMKM dan pedagang tradisional masih mengandalkan transaksi secara offline atau melalui media sosial.

Permasalahan:

- katalog produk tidak terstruktur;
- pelanggan sulit menemukan produk;
- informasi harga tidak selalu tersedia;
- pengelolaan pesanan masih manual;
- UMKM sulit memperluas pasar;
- tidak tersedia pusat marketplace lokal.

Pasar.ID hadir untuk memberikan satu platform yang menghubungkan **pedagang lokal dengan pembeli**.

---

# 3. Product Goals

### Primary Goals

- menyediakan marketplace lokal;
- menyediakan sistem multi-vendor;
- mendigitalkan toko UMKM;
- menyediakan sistem transaksi;
- menyediakan dashboard seller;
- menyediakan dashboard admin.

### Secondary Goals

- meningkatkan visibilitas UMKM;
- membangun database produk lokal;
- mempermudah pencarian produk;
- membangun kepercayaan pembeli.

---

# 4. User Roles

## Buyer

Permission:

```text
register
login
browse products
search products
view store
add cart
checkout
view orders
manage profile
```

## Seller

Permission:

```text
login
manage store
create product
update product
delete product
manage stock
view orders
update order status
view sales
```

## Admin

Permission:

```text
manage users
manage sellers
manage categories
manage products
manage orders
manage stores
manage reports
moderate content
```

---

# 5. Functional Requirements

## 5.1 Authentication

Sistem harus menyediakan:

- registration;
- login;
- logout;
- password reset;
- email verification;
- role-based authorization.

---

# 5.2 User Profile

User dapat:

- mengubah nama;
- mengubah foto;
- mengubah nomor telepon;
- mengelola alamat;
- mengubah password.

---

# 5.3 Seller Store

Seller dapat membuat toko.

Data toko:

```text
store_name
slug
description
logo
banner
phone
address
city
province
status
```

Status:

```text
pending
active
suspended
rejected
```

---

# 5.4 Product

Data produk:

```text
name
slug
description
price
stock
weight
category
store
thumbnail
status
```

Status:

```text
draft
active
inactive
out_of_stock
```

Seller dapat:

- membuat produk;
- mengedit produk;
- menghapus produk;
- mengubah harga;
- mengubah stok;
- mengunggah gambar.

---

# 5.5 Category

Contoh:

```text
Makanan
Minuman
Sembako
Fashion
Kerajinan
Pertanian
Elektronik
Kebutuhan Rumah
Produk Lokal
```

Kategori dapat dikelola Admin.

---

# 5.6 Marketplace

Halaman utama:

```text
Header
│
├── Search
├── Category
├── Login
└── Cart

Hero
│
├── Produk Lokal
├── UMKM
└── Promo

Categories

Featured Products

Popular Stores

Latest Products

Footer
```

---

# 5.7 Search

Pembeli dapat mencari berdasarkan:

- nama produk;
- kategori;
- toko;
- lokasi;
- harga.

Filter:

```text
Harga
Kategori
Lokasi
Rating
Ketersediaan
```

Untuk MVP, filter dapat dibatasi menjadi:

```text
keyword
category
price range
```

---

# 5.8 Shopping Cart

Keranjang menyimpan:

```text
product
seller
quantity
price
subtotal
```

Pembeli dapat:

- menambah produk;
- mengurangi quantity;
- menghapus produk;
- melihat subtotal;
- melihat total.

---

# 5.9 Checkout

Data checkout:

```text
customer
address
phone
products
quantity
subtotal
shipping
total
payment_method
notes
```

MVP dapat menggunakan:

```text
COD
Manual Transfer
```

Payment gateway dapat ditambahkan pada fase berikutnya.

---

# 5.10 Order

Order memiliki:

```text
order_number
buyer
seller
address
subtotal
shipping_cost
total
payment_status
order_status
created_at
```

Order status:

```text
pending
confirmed
processing
shipped
completed
cancelled
```

Payment status:

```text
unpaid
pending
paid
failed
refunded
```

---

# 5.11 Seller Dashboard

Dashboard seller menampilkan:

```text
Total Products
Total Orders
Pending Orders
Completed Orders
Revenue
```

Menu:

```text
Dashboard
Products
Orders
Store
Profile
```

---

# 5.12 Admin Dashboard

Admin dapat melihat:

```text
Total Users
Total Sellers
Total Products
Total Orders
Revenue
Pending Sellers
Pending Products
```

Menu:

```text
Dashboard
Users
Sellers
Stores
Categories
Products
Orders
Reports
Settings
```

---

# 6. Database Design

Core entities:

```text
users
roles
stores
categories
products
product_images
addresses
carts
cart_items
orders
order_items
payments
```

Relasi utama:

```text
User
 ├── Store
 ├── Addresses
 └── Orders

Store
 ├── Products
 └── Orders

Category
 └── Products

Product
 ├── ProductImages
 └── OrderItems

Order
 ├── OrderItems
 └── Payment
```

---

# 7. API Architecture

Walaupun MVP berbasis web, backend sebaiknya disiapkan API-ready.

Contoh:

```text
/api/v1/auth
/api/v1/products
/api/v1/categories
/api/v1/stores
/api/v1/cart
/api/v1/orders
/api/v1/profile
```

Hal ini memungkinkan Pasar.ID nantinya memiliki:

- mobile app;
- Android app;
- Flutter app;
- aplikasi seller;
- integrasi pihak ketiga.

---

# 8. Non-Functional Requirements

## Performance

Target:

- halaman utama < 3 detik pada koneksi normal;
- database menggunakan indexing;
- gambar dikompresi;
- pagination digunakan pada katalog.

## Security

Menggunakan:

- Laravel authentication;
- CSRF protection;
- validation;
- authorization policy;
- password hashing;
- rate limiting;
- secure file upload;
- SQL injection protection.

## Scalability

Arsitektur harus memungkinkan penambahan:

```text
Redis
Queue
Object Storage
CDN
Search Engine
Payment Gateway
```

---

# 9. Docker Architecture

```text
                    Internet
                       │
                       ▼
                  Web Server
                       │
                       ▼
                Laravel App
                       │
          ┌────────────┼────────────┐
          ▼            ▼            ▼
       MySQL         Redis      Queue Worker
          │
          ▼
       Database
```

Development:

```text
docker-compose.yml

services:
  app
  web
  db
  phpmyadmin
```

Future:

```text
app
web
db
redis
queue
scheduler
storage
```

---

# 10. UX Requirements

Pasar.ID harus terasa seperti:

> “Datang ke pasar, tetapi melalui HP.”

Karakter UI:

- sederhana;
- hangat;
- lokal;
- tidak terlalu korporat;
- mudah dipahami;
- tombol besar;
- informasi harga jelas;
- gambar produk dominan.

---

# 11. Future Features

Setelah MVP:

### Payment

- Midtrans;
- Xendit;
- QRIS;
- virtual account;
- e-wallet.

### Delivery

- kurir lokal;
- pickup;
- delivery tracking.

### Engagement

- rating;
- review;
- wishlist;
- chat seller;
- notification.

### Marketing

- voucher;
- flash sale;
- promo;
- banner;
- sponsored products.

### Seller Analytics

- penjualan;
- produk terlaris;
- revenue;
- conversion;
- pelanggan.

---

# 12. Acceptance Criteria

Fitur dianggap selesai apabila:

- dapat digunakan melalui browser;
- validasi berjalan;
- data tersimpan dengan benar;
- authorization berjalan;
- tidak dapat diakses role yang tidak berhak;
- responsive;
- dapat dijalankan melalui Docker;
- memiliki error handling dasar.