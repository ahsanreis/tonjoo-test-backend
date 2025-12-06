# Tonjoo Laravel Test

Aplikasi web yang dibangun menggunakan Laravel framework dengan database SQLite.

## 📋 Daftar Isi

-   [Persyaratan](#persyaratan)
-   [Instalasi](#instalasi)
-   [Konfigurasi](#konfigurasi)
-   [Migrasi Database](#migrasi-database)
-   [Menjalankan Aplikasi](#menjalankan-aplikasi)
-   [Struktur Proyek](#struktur-proyek)
-   [Lisensi](#lisensi)

## 💻 Persyaratan

-   PHP >= 8.2
-   Composer
-   SQLite
-   Node.js & NPM (untuk asset frontend)

## 📦 Instalasi

1. Clone atau download proyek ini:

```bash
git clone <repository-url>
cd tonjoo-laravel-test
```

2. Install dependencies PHP:

```bash
composer install
```

3. Install dependencies JavaScript:

```bash
npm install
```

4. Copy file `.env.example` menjadi `.env`:

```bash
copy .env.example .env
```

5. Generate application key:

```bash
php artisan key:generate
```

## ⚙️ Konfigurasi

Database sudah dikonfigurasi menggunakan SQLite. Pastikan file `.env` sudah memiliki konfigurasi database yang benar:

```
DB_CONNECTION=sqlite
DB_DATABASE=database.sqlite
```

## 🗄️ Migrasi Database

Jalankan migrasi untuk membuat tabel-tabel di database:

```bash
php artisan migrate
```

Untuk rollback migrasi (jika diperlukan):

```bash
php artisan migrate:rollback
```

## 🚀 Menjalankan Aplikasi

1. Jalankan development server:

```bash
php artisan serve
```

2. Di terminal lain, jalankan Vite untuk asset frontend:

```bash
npm run dev
```

3. Akses aplikasi di browser: `http://localhost:8000`

Untuk production build:

```bash
npm run build
```

## 📁 Struktur Proyek

```
├── app/
│   ├── Http/Controllers/      # Controllers
│   └── Models/                # Eloquent Models
├── database/
│   ├── migrations/            # Database migrations
│   ├── seeders/               # Database seeders
│   └── factories/             # Model factories
├── resources/
│   ├── css/                   # Stylesheet
│   ├── js/                    # JavaScript
│   └── views/                 # Blade templates
├── routes/                    # Route definitions
├── tests/                     # Unit & Feature tests
├── storage/                   # File storage
└── config/                    # Configuration files
```

## 📝 Model & Tabel

Aplikasi ini memiliki beberapa model:

-   **User** - Model untuk pengguna
-   **Transaction** - Model untuk transaksi
-   **TransactionDetail** - Model untuk detail transaksi

## 🧪 Testing

Jalankan test suite:

```bash
php artisan test
```

## 📄 Lisensi

Proyek ini menggunakan lisensi MIT. Lihat file `LICENSE` untuk detail lebih lanjut.
