# MVP
## Pasar.ID — Marketplace UMKM Lokal

## 1. Tujuan MVP

MVP Pasar.ID berfokus pada satu hal:

> **Membuktikan bahwa UMKM dapat memiliki toko digital dan pembeli dapat membeli produk lokal melalui satu marketplace.**

Jangan langsung membangun semua fitur e-commerce.

Prioritas awal adalah:

```text
User
 ↓
Store
 ↓
Product
 ↓
Cart
 ↓
Checkout
 ↓
Order
 ↓
Seller manages order
```

---

# 2. MVP Scope

## PRIORITAS P0 — WAJIB

### Authentication

- [ ] Register
- [ ] Login
- [ ] Logout
- [ ] Password reset
- [ ] Role authorization

### Buyer

- [ ] Homepage
- [ ] Product listing
- [ ] Product detail
- [ ] Store detail
- [ ] Search
- [ ] Category
- [ ] Cart
- [ ] Checkout
- [ ] Order history
- [ ] Profile
- [ ] Address

### Seller

- [ ] Seller registration
- [ ] Store creation
- [ ] Store profile
- [ ] Product CRUD
- [ ] Product image
- [ ] Stock management
- [ ] Order management
- [ ] Order status

### Admin

- [ ] Admin login
- [ ] Dashboard
- [ ] User management
- [ ] Seller management
- [ ] Store management
- [ ] Category management
- [ ] Product moderation
- [ ] Order monitoring

---

# 3. MVP Payment

Untuk versi pertama:

### COD

Pembeli memilih:

```text
Cash on Delivery
```

### Manual Transfer

Pembeli dapat:

```text
Transfer Bank
```

Kemudian seller/admin melakukan verifikasi pembayaran.

**Payment gateway belum menjadi bagian core MVP.**

---

# 4. MVP Order Flow

```text
BUYER
  │
  ▼
Browse Product
  │
  ▼
Add to Cart
  │
  ▼
Checkout
  │
  ▼
Create Order
  │
  ▼
Payment
  │
  ▼
SELLER
  │
  ▼
Confirm Order
  │
  ▼
Processing
  │
  ▼
Shipped / Ready for Pickup
  │
  ▼
Completed
```

---

# 5. MVP Seller Flow

```text
Register
   ↓
Seller Verification
   ↓
Create Store
   ↓
Add Product
   ↓
Publish Product
   ↓
Receive Order
   ↓
Process Order
   ↓
Complete Order
```

---

# 6. MVP Admin Flow

```text
Login
 ↓
Dashboard
 ↓
Review Seller
 ↓
Approve Store
 ↓
Moderate Product
 ↓
Monitor Orders
 ↓
Manage Users
```

---

# 7. MVP Database

Minimal database:

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

---

# 8. MVP Laravel Structure

```text
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/
│   │   ├── Buyer/
│   │   └── Seller/
│   │
│   ├── Requests/
│   └── Middleware/
│
├── Models/
│   ├── User.php
│   ├── Store.php
│   ├── Product.php
│   ├── Category.php
│   ├── Cart.php
│   ├── CartItem.php
│   ├── Order.php
│   ├── OrderItem.php
│   └── Payment.php
│
└── Policies/
```

---

# 9. MVP Routes

```text
/
 /products
 /products/{slug}
 /categories/{slug}
 /stores/{slug}

 /cart
 /checkout
 /orders
 /orders/{order}

 /seller/dashboard
 /seller/store
 /seller/products
 /seller/orders

 /admin/dashboard
 /admin/users
 /admin/sellers
 /admin/stores
 /admin/products
 /admin/categories
 /admin/orders
```

---

# 10. MVP Dashboard

## Buyer

```text
Welcome
Orders
Cart
Addresses
Profile
```

## Seller

```text
Revenue
Orders
Products
Stock
Store
```

## Admin

```text
Users
Sellers
Stores
Products
Orders
Revenue
```

---

# 11. MVP Development Sprint

## Sprint 1 — Infrastructure

- [ ] Laravel setup
- [ ] Docker Compose
- [ ] MySQL
- [ ] phpMyAdmin
- [ ] Environment configuration
- [ ] Git repository
- [ ] Base layout

### Output

Laravel dapat berjalan sepenuhnya melalui Docker.

---

## Sprint 2 — Authentication

- [ ] Register
- [ ] Login
- [ ] Logout
- [ ] Password reset
- [ ] Roles
- [ ] Authorization

### Output

Buyer, Seller, dan Admin memiliki akses berbeda.

---

## Sprint 3 — Marketplace

- [ ] Category
- [ ] Product
- [ ] Store
- [ ] Product detail
- [ ] Store detail
- [ ] Search

### Output

Marketplace sudah dapat digunakan untuk browsing.

---

## Sprint 4 — Cart & Checkout

- [ ] Cart
- [ ] Cart item
- [ ] Address
- [ ] Checkout
- [ ] Order creation

### Output

Pembeli dapat membuat pesanan.

---

## Sprint 5 — Seller

- [ ] Seller dashboard
- [ ] Store management
- [ ] Product CRUD
- [ ] Stock
- [ ] Order management

### Output

Seller dapat mengelola toko secara mandiri.

---

## Sprint 6 — Admin

- [ ] Admin dashboard
- [ ] User management
- [ ] Seller approval
- [ ] Product moderation
- [ ] Category management
- [ ] Order monitoring

### Output

Marketplace dapat dikontrol oleh administrator.

---

## Sprint 7 — Testing & Deployment

- [ ] Feature testing
- [ ] Authentication testing
- [ ] Authorization testing
- [ ] Order testing
- [ ] Responsive testing
- [ ] Docker production configuration
- [ ] Database backup
- [ ] Deployment

---

# 12. Fitur yang Sengaja Ditunda

Agar MVP tidak melebar, fitur berikut **jangan dibuat dulu**:

```text
❌ Live chat
❌ AI recommendation
❌ Flash sale
❌ Voucher
❌ Affiliate
❌ Loyalty point
❌ Complex shipping API
❌ Multiple payment gateway
❌ Advanced analytics
❌ Mobile application
❌ Microservices
```

Fitur tersebut masuk **Post-MVP**.

---

# 13. Post-MVP Roadmap

### Version 1.1

```text
Rating
Review
Wishlist
Notification
Voucher
```

### Version 1.2

```text
QRIS
Payment Gateway
Shipping Integration
Tracking
```

### Version 1.3

```text
Seller Analytics
Promotion System
Chat
```

### Version 2.0

```text
Flutter Mobile App
Seller Mobile App
Push Notification
Recommendation Engine
Advanced Analytics
```

---

# 14. MVP Success Criteria

Pasar.ID siap disebut **MVP berhasil** apabila:

```text
✓ Buyer bisa register
✓ Seller bisa register
✓ Seller bisa membuat toko
✓ Seller bisa menambahkan produk
✓ Buyer bisa mencari produk
✓ Buyer bisa melihat toko
✓ Buyer bisa memasukkan produk ke cart
✓ Buyer bisa checkout
✓ Order tercatat
✓ Seller menerima order
✓ Seller mengubah status order
✓ Admin dapat mengontrol marketplace
✓ Semua berjalan melalui Docker
```

---

# 15. Core MVP Philosophy

Pasar.ID bukan mencoba menjadi “Tokopedia versi kecil”.

Pasar.ID harus menjadi:

> **“Pasar lokal yang kebetulan hidup di internet.”**

Karena itu, pengalaman **toko, pedagang, produk lokal, lokasi, dan interaksi manusia** harus menjadi identitas utama platform.

Teknologi Laravel + Docker menjadi fondasi infrastrukturnya, sementara pengalaman pengguna tetap dibuat sesederhana orang ketika datang ke pasar tradisional.