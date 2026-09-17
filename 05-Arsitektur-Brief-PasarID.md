ARSITEKTUR BRIEF — PASAR.ID

Arsitektur Cross-Platform dan Scalable

## 1. Prinsip Utama
One Backend, Multiple Clients. Business logic dan data access dipusatkan di NestJS API. Next.js dan Flutter bertindak sebagai client. Client tidak mengakses database secara langsung.

## 2. High-Level Architecture
Users → Next.js Web / Flutter Mobile → REST API → NestJS → PostgreSQL + Redis + Object Storage. Background jobs menggunakan Redis Queue/worker.

## 3. Backend Architecture
Gunakan Modular Monolith. Modul utama: AuthModule, UsersModule, SellersModule, StoresModule, CategoriesModule, ProductsModule, CartModule, OrdersModule, PaymentsModule, ShippingModule, ReviewsModule, NotificationsModule, AdminModule.

## 4. API Architecture
REST API dengan versioning /api/v1. Contoh: GET/POST/PATCH/DELETE /api/v1/products, GET/POST /api/v1/orders, GET /api/v1/stores/:id. Dokumentasi menggunakan OpenAPI/Swagger.

## 5. Cross-Platform
Next.js Web dan Flutter Android/iOS menggunakan API yang sama. Authentication, validation, order logic, payment abstraction, dan authorization tidak digandakan pada tiap platform.

## 6. Database
PostgreSQL sebagai primary database. Entitas inti: users, roles, stores, categories, products, product_images, addresses, carts, cart_items, orders, seller_orders, order_items, payments, reviews, notifications.

## 7. Redis
Redis digunakan untuk cache, rate limiting, temporary data, session-related use cases bila diperlukan, dan queue. Redis bukan pengganti PostgreSQL untuk data transaksi utama.

## 8. Storage
Gambar produk/toko disimpan pada object storage S3-compatible. Database menyimpan metadata/URL, bukan binary image utama.

## 9. Deployment
Development menggunakan Docker Compose. Production dapat menggunakan Next.js pada hosting web, NestJS pada VPS/cloud/container platform, managed PostgreSQL, managed Redis, dan object storage.

## 10. Scalability
Mulai sebagai modular monolith. Tambahkan Redis/queue ketika dibutuhkan. Horizontal scaling API dan pemisahan service hanya dilakukan ketika traffic, reliability, atau organizational needs benar-benar membenarkannya.

## 11. Security
HTTPS, JWT access/refresh token, password hashing, CORS policy, rate limiting, DTO validation, RBAC, secure file upload, database least privilege, secret management, logging, dan audit trail untuk aksi penting.

Pasar.ID — Project Documentation
