# Online Store — Practical Laravel

Kode ini adalah hasil akhir (sudah di-refactor) dari proyek **Online Store** pada buku
*Practical Laravel: Develop Clean MVC Web Applications* (Daniel Correa & Paola Vallejo),
mengikuti urutan Bab 1–28.

## Struktur file yang dibuat

```
onlineStore/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Controller.php
│   │   │   ├── HomeController.php          (Bab 6-7)
│   │   │   ├── ProductController.php       (Bab 9, 13-14)
│   │   │   ├── CartController.php          (Bab 25, 27)
│   │   │   ├── MyAccountController.php     (Bab 28)
│   │   │   ├── Admin/
│   │   │   │   ├── AdminHomeController.php     (Bab 15)
│   │   │   │   └── AdminProductController.php  (Bab 16-20)
│   │   │   └── Auth/
│   │   │       └── RegisterController.php  (Bab 21-22, modifikasi balance)
│   │   ├── Middleware/
│   │   │   └── AdminAuthMiddleware.php     (Bab 23)
│   │   └── Kernel-middleware-snippet.php   (cuplikan untuk Kernel.php)
│   └── Models/
│       ├── Product.php   (Bab 12, 14, 20 — getter/setter + validate())
│       ├── User.php      (Bab 21-22, 26 — role, balance, relasi orders)
│       ├── Order.php     (Bab 26)
│       └── Item.php      (Bab 26)
├── database/migrations/
│   ├── ..._create_products_table.php   (Bab 11)
│   ├── ..._alter_users_table.php       (Bab 22)
│   ├── ..._create_orders_table.php     (Bab 26)
│   └── ..._create_items_table.php      (Bab 26)
├── public/
│   ├── css/app.css     (Bab 5)
│   └── css/admin.css   (Bab 15)
├── resources/views/
│   ├── layouts/app.blade.php     (Bab 5, 7, 21, 25, 28)
│   ├── layouts/admin.blade.php   (Bab 15, 19)
│   ├── home/index.blade.php, about.blade.php       (Bab 6-7)
│   ├── product/index.blade.php, show.blade.php     (Bab 9, 14, 18, 25)
│   ├── admin/home/index.blade.php                  (Bab 15)
│   ├── admin/product/index.blade.php, edit.blade.php (Bab 16-19)
│   ├── cart/index.blade.php, purchase.blade.php    (Bab 25, 27)
│   └── myaccount/orders.blade.php                  (Bab 28, eager loading)
├── routes/web.php
└── .env.example
```

## Seeder & Factory (pengganti INSERT SQL manual — Bab 11 & 22)

Folder `database/seeders/` dan `database/factories/` berisi:

| File | Fungsi |
|---|---|
| `ProductSeeder.php` | Mengisi 4 produk dummy (TV, iPhone, Chromecast, Glasses) — sama persis dengan query SQL manual di Bab 11 |
| `AdminUserSeeder.php` | Membuat 1 user admin otomatis (`admin@onlinestore.com` / `password`), pengganti langkah manual via Tinker di Bab 22 |
| `DatabaseSeeder.php` | Memanggil kedua seeder di atas |
| `ProductFactory.php` | Factory untuk membuat produk dummy **acak** (nama, harga, deskripsi random) |
| `ProductFakerSeeder.php` | Seeder opsional yang memakai `ProductFactory` untuk membuat 20 produk acak sekaligus |

Cara pakai, setelah `php artisan migrate`:
```bash
php artisan db:seed
```
Ini otomatis menjalankan `ProductSeeder` + `AdminUserSeeder`. Kalau ingin tambahan 20 produk acak:
```bash
php artisan db:seed --class=Database\\Seeders\\ProductFakerSeeder
```

> Catatan: model `Product` di buku ini sengaja **tidak** memakai trait `HasFactory`
> (lihat Bab 14), jadi `ProductFactory` dipanggil langsung lewat `ProductFactory::new()`
> di dalam `ProductFakerSeeder`, bukan lewat `Product::factory()`.

## Deploy ke Cloud (Bab 29-30)

Lihat **`DEPLOY.md`** untuk panduan lengkap deploy database ke **Clever Cloud** dan
aplikasi Laravel ke **Heroku**, langkah demi langkah sesuai urutan buku.

## Cara memasangnya ke proyek Laravel baru (ikuti urutan buku)

1. **Buat proyek Laravel 9** (Bab 3):
   ```bash
   composer create-project laravel/laravel:^9.0 onlineStore
   cd onlineStore
   ```

2. **Salin semua file** dari folder ini ke proyek Laravel Anda (timpa file yang sama nama-nya:
   `routes/web.php`, `app/Models/User.php`, dll).

3. **Konfigurasi `.env`** (Bab 10-11): buat database MySQL `online_store` di phpMyAdmin,
   lalu salin nilai dari `.env.example` ke `.env` Anda dan sesuaikan `DB_USERNAME`/`DB_PASSWORD`.

4. **Generate APP_KEY**:
   ```bash
   php artisan key:generate
   ```

5. **Jalankan migrasi** (Bab 11, 22, 26):
   ```bash
   php artisan migrate
   ```
   Lalu isi data dummy otomatis dengan seeder (lihat bagian **Seeder & Factory** di bawah):
   ```bash
   php artisan db:seed
   ```

6. **Buat symbolic link storage** (untuk gambar produk, Bab 18):
   ```bash
   php artisan storage:link
   ```

7. **Pasang sistem login `laravel/ui`** (Bab 21):
   ```bash
   composer require laravel/ui
   php artisan ui bootstrap --auth
   ```
   Saat ditanya untuk replace `app.blade.php` dan `HomeController`, jawab **no** (kita sudah
   punya versi sendiri di folder ini).

8. **Daftarkan middleware admin** (Bab 23): buka `app/Http/Kernel.php`, tambahkan baris
   `'admin' => \App\Http\Middleware\AdminAuthMiddleware::class,` ke dalam `$routeMiddleware`
   (lihat `app/Http/Kernel-middleware-snippet.php` sebagai contoh).

9. **Download gambar produk dummy** (`game.png`, `safe.png`, `submarine.png`,
   `undraw_profile.svg`) dari repo resmi buku dan taruh di `public/img/`:
   https://github.com/PracticalBooks/Practical-Laravel

10. **Jadikan user pertama sebagai admin** (Bab 22) — opsional, karena `AdminUserSeeder`
    sudah otomatis membuat akun admin (`admin@onlinestore.com` / `password`) saat
    `php artisan db:seed`. Kalau mau jadikan user lain sebagai admin, via Tinker:
    ```bash
    php artisan tinker
    >>> $user = App\Models\User::find(1);
    >>> $user->role = 'admin';
    >>> $user->save();
    ```

11. **Jalankan aplikasi**:
    ```bash
    php artisan serve
    ```
    Buka `http://127.0.0.1:8000/`.

## Catatan penting
- Saya **tidak menerima file gambar terpisah** di chat ini — gambar yang muncul di
  dokumen Word hanya berupa *screenshot hasil tampilan* (Figure 5-3, 9-1, dst), bukan
  source code tambahan. Semua kode di sini sudah disusun **sama persis** dengan kode
  final yang dijelaskan teks buku, bab demi bab, termasuk hasil refactor di setiap bab.
- Kode `RegisteredUserController`/`RegisterController` di sini memakai jalur
  `laravel/ui` (Controller-based) sesuai isi buku — bukan Breeze.
- Beberapa command (`php artisan migrate`, `composer require`, dst) perlu dijalankan
  di komputer Anda sendiri yang sudah terpasang PHP 8 + Composer + MySQL (XAMPP),
  karena environment saya di sini tidak punya PHP/Composer terpasang.

Kalau Anda mau saya lanjutkan ke **Bab 29-30 (deploy ke Clever Cloud + Heroku)**, atau
mau saya tambahkan **seeder/factory untuk dummy product data**, tinggal bilang saja.
