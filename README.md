# Website YISI

Website company profile Yayasan Investasi Sosial Indonesia dengan halaman publik Blade + Tailwind CSS dan CMS Filament.

## Kebutuhan

- PHP 8.3+
- Composer
- Node.js dan npm
- SQLite untuk pengembangan lokal atau PostgreSQL 14+ untuk deployment

## Menjalankan secara lokal

```sh
composer install
npm install
cp .env.example .env
php artisan key:generate
php artisan migrate --seed
npm run build
php artisan serve
```

Buka `http://127.0.0.1:8000`. Admin CMS tersedia di `/admin`.

Untuk membuat akun administrator pertama, jalankan `php artisan app:create-admin-user`. Perintah ini meminta nama, email, dan password secara interaktif; tidak ada akun bawaan atau kredensial default.

## Database

SQLite digunakan sebagai default lokal. Untuk PostgreSQL, atur `DB_CONNECTION=pgsql`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` di `.env`, lalu jalankan migrasi dan seeder.

Seeder hanya memuat pilar YISI, kategori awal, identitas publik, dan alamat kantor yang tercantum dalam PRD. Program, anggota tim, dokumen, serta artikel dimasukkan melalui CMS setelah data dan persetujuan publikasinya siap.

## Pengelolaan CMS

- `/admin/posts`: artikel, status publikasi, metadata SEO, dan kategori.
- `/admin/programs`: ringkasan program, pilar, mitra, lokasi, tahun, dan status publikasi.
- `/admin/post-categories`: kategori artikel.
- `/admin/tags`: tag artikel.
- `/admin/contact-messages`: pesan dari formulir publik.
- `/admin/team-members`, `/admin/offices`, `/admin/legal-identities`: profil, kantor, dan identitas legal.
- `/admin/media` dan `/admin/documents`: pustaka media serta dokumen publik.
- `/admin/partners` dan `/admin/pillars`: data mitra dan pilar.
- `/admin/users`: akun CMS, khusus administrator.
- `/admin/subscribers`: daftar pelanggan kabar dengan persetujuan dan status konfirmasi.

Peran CMS adalah `admin`, `editor`, dan `author`. Penulis hanya dapat membuat atau memperbarui draf miliknya. Administrator wajib mengaktifkan autentikasi dua faktor melalui aplikasi authenticator.

## Pengujian

```sh
php artisan test
npm run build
```
# yisindonesia
