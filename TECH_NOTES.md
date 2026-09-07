# Tech Notes — Pasar.ID

> Catatan teknis singkat untuk developer yang ingin berkontribusi.

---

## Docker Setup

Gunakan Docker untuk menjalankan environment lokal:

```bash
cd "c:\project saya\pasar id"
docker compose up -d --build
```

### Service

| Service     | Port     | Deskripsi                  |
|-------------|----------|----------------------------|
| App (Laravel) | —       | PHP-FPM + Composer         |
| Nginx       | 8080     | Web server                 |
| MySQL       | 3306     | Database                   |
| phpMyAdmin  | 8081     | Admin DB (root / root)     |

### Akses

- Web: [http://localhost:8080](http://localhost:8080)
- phpMyAdmin: [http://localhost:8081](http://localhost:8081)

---

## Migrasi & Seeder

### Jalankan Migrasi

```bash
docker compose exec app php artisan migrate
```

Jika fresh install (hapus semua data terlebih dahulu):

```bash
docker compose exec app php artisan migrate:fresh --seed
```

Seeder utama ada di `DatabaseSeeder.php`. Untuk hanya meng-seed data dummy:

```bash
docker compose exec app php artisan db:seed --class=DummyUsersSeeder
```

---

## Build Frontend

Gunakan Node.js untuk compile Tailwind & Alpine.js assets:

```bash
cd pasar-id
npm install
npm run build
```

---

## Permission (Dev Only)

Di environment dev, gunakan perintah berikut untuk set permission storage:

```bash
docker compose exec app chown -R www-data:www-data storage bootstrap/cache
```

⚠️ Di production, hindari `chmod 777`. Gunakan volume persistent + user yang tepat.

---

## Tips Debug

- Cek log Laravel: `tail -f pasar-id/storage/logs/laravel.log`
- Cek container logs: `docker compose logs -f <service>`
- Pastikan port 8080 tidak dipakai aplikasi lain

---

*Dokumen ini bisa diperluas seiring kebutuhan.*
