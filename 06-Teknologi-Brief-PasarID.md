TEKNOLOGI BRIEF — PASAR.ID

Technology Stack dan Alasan Pemilihan

## 1. Frontend Web — Next.js
Next.js + TypeScript + React + Tailwind CSS. Digunakan untuk customer marketplace, seller dashboard, dan admin dashboard. Mendukung SEO, routing, SSR/SSG sesuai kebutuhan, serta ecosystem React yang luas.

## 2. Mobile — Flutter
Flutter + Dart untuk Android dan iOS. Satu codebase mobile dapat digunakan untuk dua platform, sementara komunikasi dengan backend dilakukan melalui REST API.

## 3. Backend — NestJS
NestJS + TypeScript sebagai API backend. Struktur modular, dependency injection, guards, DTO, validation, dan pola arsitektur yang cocok untuk aplikasi bisnis dengan banyak domain.

## 4. Database — PostgreSQL
Primary relational database untuk user, seller, store, product, cart, order, payment, review, dan data transaksional lainnya. Relational model cocok untuk konsistensi dan integritas marketplace.

## 5. ORM — Prisma
Prisma dipilih untuk schema, migrations, query, dan type safety. Drizzle dapat menjadi alternatif jika kebutuhan project berubah.

## 6. Cache & Queue — Redis
Redis digunakan untuk caching data yang sering dibaca, rate limiting, temporary data, dan asynchronous job queue. BullMQ dapat digunakan di atas Redis untuk queue/worker.

## 7. Storage — S3-compatible
Gunakan Cloudflare R2, AWS S3, Supabase Storage, atau layanan S3-compatible lainnya untuk image dan file. Pilih berdasarkan biaya, region, dan kebutuhan deployment.

## 8. Authentication
JWT access token + refresh token. API menjadi sumber kebenaran authentication sehingga Web dan Mobile menggunakan mekanisme yang sama.

## 9. API Documentation
OpenAPI/Swagger untuk dokumentasi endpoint, request/response schema, dan pengujian manual API. Dokumentasi menjadi acuan implementasi Flutter dan client lainnya.

## 10. Infrastructure — Docker
Docker dan Docker Compose digunakan untuk environment yang konsisten. Service development utama: api, web, postgres, redis. Mobile Flutter dapat dijalankan native untuk pengalaman hot reload yang lebih nyaman.

## 11. Search
MVP: PostgreSQL search/indexing. Growth: Meilisearch atau OpenSearch bila kebutuhan pencarian, typo tolerance, filtering, dan ranking semakin kompleks.

## 12. Version Control & CI/CD
Git + GitHub. CI/CD dapat menjalankan lint, type check, unit test, integration test, build, migration checks, dan deployment secara otomatis.

## 13. Recommended Final Stack
Web: Next.js + TypeScript + Tailwind CSS.

Mobile: Flutter + Dart.

Backend: NestJS + TypeScript.

Database: PostgreSQL.

ORM: Prisma.

Cache/Queue: Redis + BullMQ.

Storage: S3-compatible object storage.

API: REST + OpenAPI/Swagger.

Auth: JWT.

Infrastructure: Docker.

Architecture: Modular Monolith.

Pasar.ID — Project Documentation
