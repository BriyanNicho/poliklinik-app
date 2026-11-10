# Aplikasi Poliklinik

Aplikasi sistem informasi manajemen layanan kesehatan Poliklinik berbasis web yang dikembangkan menggunakan **Laravel 11/12**, **Tailwind CSS**, **DaisyUI**, **Font Awesome**, dan database **MySQL**. Aplikasi ini mendukung multi-user role (Admin, Dokter, dan Pasien) untuk memfasilitasi operasional klinik mulai dari manajemen master data hingga pencatatan rekam medis pemeriksaan pasien.

---

## 🌟 Fitur Utama

### 1. Modul Admin
- **Dashboard Admin**: Ringkasan operasional dan navigasi sistem klinik.
- **Manajemen Poli (CRUD)**:
  - Menampilkan daftar poli layanan kesehatan.
  - Tambah poli baru dengan validasi data.
  - Ubah informasi nama poli dan keterangan.
  - Hapus data poli.
- **Manajemen Dokter (CRUD)**:
  - Menampilkan data lengkap dokter beserta bidang poli masing-masing.
  - Tambah dokter baru (Nama, Email, No. KTP, No. HP, Alamat, Pilihan Poli, Password terenkripsi).
  - Edit profil dokter dan penggantian password opsional.
  - Hapus data akun dokter.
- **Manajemen Pasien (CRUD)**:
  - Menampilkan daftar pasien terdaftar.
  - Pendaftaran pasien baru dari sisi admin.
  - Edit data identitas pasien.
  - Hapus data pasien.
- **Manajemen Obat (CRUD)**:
  - Menampilkan katalog obat beserta kemasan dan harga satuan.
  - Tambah master obat baru.
  - Edit informasi obat, kemasan, dan harga.
  - Hapus data obat.

### 2. Modul Dokter
- **Dashboard Dokter**: Akses cepat layanan dokter.
- **Jadwal Periksa (CRUD)**:
  - Pengaturan jadwal praktik dokter per hari (Senin - Minggu).
  - Penentuan jam mulai dan jam selesai praktik.
  - Pembaruan dan penghapusan jadwal praktik.
- **Periksa Pasien**:
  - Menampilkan daftar antrean pasien yang mendaftar pada jadwal praktik dokter yang sedang login.
  - Status pemeriksaan pasien (Badge: *Belum Diperiksa* / *Sudah Diperiksa*).
  - Form pemeriksaan pasien: tanggal & waktu periksa, catatan diagnosa medis.
  - Pemilihan resep obat yang diresepkan dari master obat dengan kalkulator rincian biaya langsung (*real-time*).
  - Perhitungan otomatis total biaya pemeriksaan: Biaya dasar konsultasi dokter (Rp 150.000) + akumulasi total harga obat yang dipilih.
  - Penyimpanan dan sinkronisasi otomatis ke relasi tabel `periksa` dan pivot `detail_periksa`.
  - Dukungan pemeriksaan baru dan fitur pembaruan (*edit*) data pemeriksaan yang telah selesai.
- **Riwayat Pasien**:
  - Daftar riwayat pasien yang pernah ditangani oleh dokter yang bersangkutan.
  - Detail riwayat pemeriksaan lengkap: data pasien, nomor antrian, keluhan, catatan dokter/diagnosa, daftar obat yang diresepkan beserta harganya, dan total biaya pemeriksaan.

### 3. Modul Pasien
- **Pendaftaran Poli**: Pendaftaran antrian poli dan pemilihan dokter & jadwal periksa yang tersedia.
- **Pemeriksaan Saya**: Memantau nomor antrian dan status pendaftaran poli.

### 4. Autentikasi & Otorisasi
- Multi-role authentication (Admin, Dokter, Pasien).
- Role-based redirect otomatis setelah login menuju dashboard masing-masing.
- Proteksi route berbasis middleware `auth` dan `role:{role}`.

---

## 🔑 Akun Demo (Default Credentials)

Database dilengkapi dengan seeder akun demo bawaan:

| Role | Email | Password | Akses Dashboard |
|---|---|---|---|
| **Admin** | `admin@gmail.com` | `admin` | `/admin/dashboard` |
| **Dokter** | `dokter@gmail.com` | `dokter` | `/dokter/dashboard` |
| **Pasien** | `pasien@gmail.com` | `pasien` | `/pasien/dashboard` |

---

## 📋 Persyaratan Sistem

- **PHP**: >= 8.2 (direkomendasikan PHP 8.3+)
- **Composer**: >= 2.x
- **Database**: MySQL / MariaDB (Direkomendasikan menggunakan [Laragon](https://laragon.org/))
- **Node.js**: >= 18.x & NPM

---

## 🚀 Panduan Instalasi & Menjalankan

### 1. Clone Repository
```bash
git clone https://github.com/BriyanNicho/poliklinik-app.git
cd poliklinik-app
```

### 2. Install Dependensi PHP & JavaScript
```bash
composer install
npm install
```

### 3. Konfigurasi Environment
Salin file `.env.example` ke `.env`:
```bash
cp .env.example .env
```
Buka file `.env` dan sesuaikan koneksi database Anda:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=poliklinik_db
DB_USERNAME=root
DB_PASSWORD=
```

Generate application key:
```bash
php artisan key:generate
```

### 4. Migrasi & Seeder Database
Pastikan database MySQL sudah dibuat di Laragon/phpMyAdmin (nama default: `poliklinik_db`), lalu jalankan:
```bash
php artisan migrate --seed
```

### 5. Build Aset Frontend
```bash
npm run build
```
*(Atau gunakan `npm run dev` untuk pengembangan aktif dengan fitur Hot Module Replacement)*.

### 6. Menjalankan Server Aplikasi

#### **Cara A: Menggunakan Laragon (Direkomendasikan)**
Jika proyek berada di dalam direktori `C:\laragon\www\poliklinik-app`:
1. Buka aplikasi Laragon.
2. Klik tombol **"Start All"**.
3. Akses aplikasi melalui browser:
   👉 **`http://poliklinik-app.test`**

#### **Cara B: Menggunakan Artisan Serve**
1. Pastikan service MySQL di Laragon sudah aktif.
2. Jalankan perintah:
   ```bash
   php artisan serve
   ```
3. Akses aplikasi melalui browser:
   👉 **`http://127.0.0.1:8000`**

---

## 🗺️ Struktur Routing Utama

### **Admin Routes** (`prefix: /admin`, middleware: `auth`, `role:admin`)
- `GET /admin/dashboard` ➔ `admin.dashboard`
- `RESOURCE /admin/polis` ➔ `polis.*` (`AdminPoliController`)
- `RESOURCE /admin/dokter` ➔ `dokter.*` (`DokterController`)
- `RESOURCE /admin/pasien` ➔ `pasien.*` (`PasienController`)
- `RESOURCE /admin/obat` ➔ `obat.*` (`ObatController`)

### **Dokter Routes** (`prefix: /dokter`, middleware: `auth`, `role:dokter`)
- `GET /dokter/dashboard` ➔ `dokter.dashboard`
- `RESOURCE /dokter/jadwal-periksa` ➔ `jadwal-periksa.*` (`JadwalPeriksaController`)
- `GET /dokter/periksa-pasien` ➔ `periksa-pasien.index` (`PeriksaPasienController`)
- `POST /dokter/periksa-pasien` ➔ `periksa-pasien.store` (`PeriksaPasienController`)
- `GET /dokter/periksa-pasien/{id}` ➔ `periksa-pasien.create` (`PeriksaPasienController`)
- `GET /dokter/periksa-pasien/{id}/edit` ➔ `periksa-pasien.edit` (`PeriksaPasienController`)
- `GET /dokter/riwayat-pasien` ➔ `riwayat-pasien.index` (`RiwayatPasienController`)
- `GET /dokter/riwayat-pasien/{id}` ➔ `riwayat-pasien.show` (`RiwayatPasienController`)

### **Pasien Routes** (`prefix: /pasien`, middleware: `auth`, `role:pasien`)
- `GET /pasien/dashboard` ➔ `pasien.dashboard`
- `GET /pasien/daftar-poli` ➔ `pasien.daftar-poli.index` (`PoliController`)
- `POST /pasien/daftar-poli` ➔ `pasien.daftar-poli.store` (`PoliController`)
- `DELETE /pasien/daftar-poli/{daftarPoli}` ➔ `pasien.daftar-poli.destroy` (`PoliController`)

---

## 🧪 Pengujian (Testing)

Untuk menjalankan seluruh unit dan feature test:
```bash
php artisan test
```

---

## 📄 Lisensi
Proyek ini dibuat untuk keperluan akademik dan sistem layanan poliklinik di bawah lisensi [MIT](LICENSE).
