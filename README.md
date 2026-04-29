# Pengembangan Aplikasi Mobile dan Sistem Website Bank Koperasi Eceng Gondok

![Status: In Development](https://img.shields.io/badge/status-development-yellow) ![License: MIT](https://img.shields.io/badge/license-MIT-blue)

> _Bank Koperasi Eceng Gondok: Melestarikan lingkungan Danau Toba melalui digitalisasi transaksi, pemasaran, dan manajemen stok produk kerajinan berbahan eceng gondok._

---

## 📌 Daftar Isi
1. [🎯 Latar Belakang & Tujuan](#-latar-belakang--tujuan)
2. [📅 Daily Task Management](#-daily-task-management)
   - [Teknis Project](#-teknis-project)
   - [Bisnis Project](#-bisnis-project)
3. [🎨 Desain UI/UX di Figma](#-desain-uiux-di-figma)
4. [✨ Gambaran Umum Proyek](#-gambaran-umum-proyek)
5. [📋 Fitur & Modul Utama](#-fitur--modul-utama)
6. [🛠️ Tech Stack](#️-tech-stack)
7. [⚙️ Instalasi & Konfigurasi](#️-instalasi--konfigurasi)
8. [🚀 Cara Penggunaan](#-cara-penggunaan)
9. [📐 Arsitektur & Desain Teknis](#-arsitektur--desain-teknis)
10. [📁 Struktur Direktori](#-struktur-direktori)
11. [🧪 Pengujian](#-pengujian)
12. [📝 Dokumentasi & Referensi](#-dokumentasi--referensi)
13. [🤝 Kontribusi](#-kontribusi)
14. [📄 Lisensi](#-lisensi)
15. [🙏 Ucapan Terima Kasih](#-ucapan-terima-kasih)

---

## 🎯 Latar Belakang & Tujuan
Bank Koperasi Eceng Gondok didirikan pada tahun 2023 untuk mengatasi dua permasalahan utama di sekitar Danau Toba, khususnya di Samosir:

1. **Lingkungan:** Pertumbuhan eceng gondok yang berlebihan mengotori perairan, mengancam ekosistem, dan menurunkan daya tarik wisata.
2. **Ekonomi Lokal:** Pemasaran produk kerajinan (sandal hotel, cover buku, tas, souvenir) masih manual melalui media sosial, menyebabkan pencatatan transaksi dan manajemen stok terfragmentasi.

**Tujuan Proyek:**
- Digitalisasi seluruh alur bisnis: pemesanan, stok, pembayaran, dan laporan.
- Memperluas jangkauan pemasaran dan promosi.
- Meningkatkan efisiensi operasional dan akurasi data.
- Memberdayakan masyarakat lokal melalui lapangan kerja dan pelatihan digital.

---

## 📅 Daily Task Management
### 🔧 Teknis Project
[Klik untuk Daily Task Management Teknis](https://trello.com/b/mvhn4cag/daily-task-management-project-bank-koperasi-eceng-gondok)

- Pengaturan sprint 1–4
- Backlog refinement & planning
- Implementasi API, database, dan integrasi frontend–backend
- Pengujian unit dan integrasi

### 💼 Bisnis Project
[Klik untuk Daily Task Management Bisnis](https://trello.com/b/jKmn180e/bisnis-project-bank-koperasi-eceng-gondok)

- Riset pasar & analisis SWOT
- Strategi promosi & branding digital
- Koordinasi mitra pemasok eceng gondok
- Pelatihan pengguna dan lokakarya

---

## 🎨 Desain UI/UX di Figma
[Link Figma Mobile & Website](https://www.figma.com/design/UE7BRHWyp3Em3iMkB7qaMS/PA3?node-id=21-2&p=f&t=v6rcA6iDYpDAYGSy-0)

- Wireframes dan prototype interaktif
- Halaman: Beranda, Katalog Produk, Detail Produk, Dashboard Admin, Form Request Bahan Baku
- Komponen: Navigasi, Formulir, Tabel Data, Grafik Statistik

---

## ✨ Gambaran Umum Proyek
Aplikasi terdiri dari dua platform terintegrasi:

1. **Website Admin & User**  
   - Dashboard visual (grafik penjualan, statistik permintaan, notifikasi).  
   - Manajemen produk, stok, dan pesanan.  
   - Modul lowongan pekerjaan dan manajemen pelamar.

2. **Mobile App (Flutter)**  
   - Pemesanan on-the-go untuk pelanggan.  
   - Role ganda: sebagai pembeli atau pemasok eceng gondok.  
   - Fitur chat & negosiasi langsung.

> Sistem ini memungkinkan otomasi end-to-end, mulai dari permintaan bahan baku hingga laporan keuangan.

---

## 📋 Fitur & Modul Utama
1. **Modul Pemesanan Produk**
   - Pencarian, filter, detail produk.  
   - Keranjang & checkout dengan Virtual Account Midtrans.  
   - Pre-order & custom request.

2. **Modul Manajemen Stok & Inventory**
   - Pencatatan masuk–keluar stok real time.  
   - Alert restock otomatis.

3. **Modul Request Pemasok**
   - Form pengajuan (kondisi kering/basah, ukuran, kuantitas, lokasi).  
   - Dashboard supplier dan notifikasi status.

4. **Modul Lowongan & Rekrutmen**
   - Posting, edit, dan tutup lowongan.  
   - Tracking status lamaran dan kurasi portofolio.

5. **Laporan & Analitik**
   - Laporan penjualan harian, mingguan, bulanan.  
   - Grafik tren pemesanan dan permintaan bahan baku.

---

## 🛠️ Tech Stack
| Lapisan          | Teknologi / Tools                |
|------------------|----------------------------------|
| Backend          | Laravel (PHP), Express.js (Node) |
| Frontend Web     | Bootstrap 5, Blade Templates     |
| Mobile App       | Flutter (Dart)                   |
| Database         | MySQL, Redis (cache)             |
| API              | RESTful API, JWT Auth            |
| DevOps & CI/CD   | GitHub Actions, Docker           |
| Desain & Prototipe| Figma, Adobe XD                 |
| Monitoring       | Sentry, Google Analytics         |

---

## ⚙️ Instalasi & Konfigurasi
### Prasyarat
- PHP >= 7.4 & Composer
- Node.js >= 14 & npm
- Flutter SDK >= 3.0
- MySQL Server 8.0+
- Docker (opsional)

### Setup Backend (Laravel)
```bash
git clone https://github.com/username/eceng-gondok-app.git
cd eceng-gondok-app/backend
composer install
cp .env.example .env
# Atur database dan Midtrans credentials di .env
php artisan key:generate
php artisan migrate --seed
npm install && npm run dev
php artisan serve --host=0.0.0.0 --port=8000
```

### Setup Frontend Web
```bash
# Jika terpisah di folder frontend
cd ../frontend
npm install
npm run build
# Deploy hasil build ke server atau layanan hosting
```

### Setup Mobile App
```bash
cd ../mobile
flutter pub get
flutter run --release
```

---

## 🚀 Cara Penggunaan
1. **Registrasi**: Pilih peran (Admin, Pelanggan, Pemasok).  
2. **Login**: Akses dashboard sesuai peran.  
3. **Jelajahi Produk**: Cari & tambahkan ke keranjang.  
4. **Checkout**: Bayar melalui Virtual Account.  
5. **Kelola Stok & Request**: Supplier memonitor dan memenuhi permintaan.  
6. **Posting Lowongan**: Admin buka rekrutmen, kandidat apply.  
7. **Pantau Laporan**: Lihat grafik dan unduh laporan PDF.

---

## 📐 Arsitektur & Desain Teknis
- **Metodologi:** Agile-Scrum (Sprint 1–4: Maret–Juni 2025)
- **Diagram Utama:** Use Case, ERD, Deployment, Sequence

```plaintext
[Mobile App] ↔ [API Gateway] ↔ [Microservices: Auth, Order, Inventory, HR]
                    ↘ [Database MySQL]
                    ↘ [Redis Cache]
``` 

![ER Diagram](docs/erd.png)

---

## 📁 Struktur Direktori
```
/eceng-gondok-app
│
├─ backend/          # API & Web Admin (Laravel)
│  ├─ app/
│  ├─ database/migrations/
│  ├─ resources/views/
│  └─ routes/
│
├─ frontend/         # SPA Web (Vue/React)
│  ├─ src/
│  ├─ public/
│  └─ build/
│
├─ mobile/           # Flutter App
│  ├─ lib/
│  └─ assets/
│
├─ docs/             # Laporan, diagram, ToR
├─ tests/            # PHPUnit, Flutter Test
├─ docker-compose.yml
└─ README.md         # Dokumen ini
``` 

---

## 🧪 Pengujian
- **Unit Test:** PHPUnit (backend), Flutter Test (mobile)
- **Integration Test:** Postman/Newman, Selenium WebDriver
- **Load Test:** Apache JMeter
- **CI/CD:** GitHub Actions—`phpunit`, `flutter test`, `npm test`

```bash
# Contoh menjalankan test backend
git checkout sprint-3
cd backend
php artisan test
``` 

---

## 📝 Dokumentasi & Referensi
- **Dokumen DPP:** `docs/Laporan Pengembangan Proyek.pdf`
- **Term of Reference & MoM:** `docs/TOR/`, `docs/MoM/`
- **Desain Figma:** Tautan Figma di atas
- **Referensi Akademik:** Aditya et al. (2024), Nugroho et al. (2014), Sianturi & Tyas (2018)

---

## 🤝 Kontribusi
1. **Fork** repositori  
2. **Buat branch** feature: `git checkout -b feature/<nama-fitur>`  
3. **Commit** perubahan: `git commit -m "feat: deskripsi singkat"`  
4. **Push & Pull Request**  

Lihat [CONTRIBUTING.md](CONTRIBUTING.md) untuk panduan lebih lanjut.

---

## 📄 Lisensi
MIT License © 2025 Bank Koperasi Eceng Gondok.  
Lihat [LICENSE](LICENSE) untuk detail - sionpardosi12@gmail.com.

---

## 🙏 Ucapan Terima Kasih
Terima kasih kepada:
- Tim Bank Koperasi Eceng Gondok atas dukungan domain.
- Masyarakat lokal dan mitra pemasok eceng gondok.
- Komunitas open source dan kontributor library yang digunakan.
