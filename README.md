# 📋 Sistem Informasi Pendataan Anak Yatim

Sistem Informasi Pendataan Anak Yatim adalah sebuah platform digital yang dirancang untuk mengelola, memvalidasi, dan menyalurkan bantuan kepada anak yatim secara terstruktur. Sistem ini membagi tingkatan akses pengguna mulai dari tingkat Kelurahan, Kecamatan, Dinas Kesejahteraan Rakyat (Kesra), hingga Superadmin untuk memastikan akurasi data yang dilaporkan dari lapangan.

---

## 🛠️ Teknologi & Framework yang Digunakan

Proyek ini dibangun menggunakan kombinasi teknologi modern untuk memastikan performa, keamanan, dan kemudahan pengembangan:

1. **Backend Framework**: 🚀 Laravel (Versi 10.x / PHP 8.2) atau CodeIgniter 4.
2. **Database**: 🗄️ MySQL / MariaDB untuk penyimpanan data relasional.
3. **Frontend UI**: 🎨 Bootstrap 5 / Tailwind CSS dikombinasikan dengan AdminLTE atau Stisla Template untuk Dashboard Admin.
4. **Tools Tambahan**: 
   - Git & GitHub untuk manajemen repositori kode.
   - Composer untuk manajemen *dependency* PHP.
   - DomPDF / TCPDF untuk fitur cetak laporan PDF.

---

## 👥 Manajemen Pengguna & Pembagian Tugas (Roles & Responsibilities)

Sistem ini menerapkan *Role-Based Access Control* (RBAC) yang membagi pengguna ke dalam 4 tingkatan tingkat otoritas:

| No | Nama Role | Tingkat Otoritas | Ruang Lingkup Kerja & Tugas Utama |
| :--- | :--- | :--- | :--- |
| 1 | **Superadmin** | Sistem Global | 🔑 Mengelola seluruh akun pengguna (semua role).<br>📊 Melakukan backup/restore database sistem.<br>🛠️ Memperbaiki konfigurasi global dan memantau log aktivitas sistem (*system logs*). |
| 2 | **Kesra (Kesejahteraan Rakyat)** | Kabupaten/Kota | 📑 Menjadi validator akhir data anak yatim di tingkat pusat.<br>🎁 Mengelola master data program bantuan (menambah jenis bantuan baru).<br>📈 Melihat dan mengunduh laporan infografis data statistik anak yatim seluruh wilayah. |
| 3 | **Kecamatan** | Tingkat Kecamatan | 🔍 Melakukan verifikasi dan validasi (Approval) data yang diajukan oleh Pendamping Kelurahan.<br>📂 Memantau perkembangan jumlah anak yatim khusus di wilayah kecamatannya.<br>🖨️ Mengunduh laporan berkala per kecamatan. |
| 4 | **Pendamping (Kelurahan)** | Tingkat Kelurahan | 📝 Melakukan input data awal anak yatim langsung dari lapangan.<br>📸 Mengunggah berkas pendukung (Foto, KK, Akta Kelahiran).<br>🔄 Melakukan pembaruan (update) jika ada perubahan status anak (misal: usia melewati batas, pindah domisili). |

---

## 🗄️ Rancangan Struktur Tabel Database

Berikut adalah struktur tabel basis data relasional yang dirancang untuk mendukung alur kerja multi-role dan penjelasannya:

### 1. Tabel `roles`
Menyimpan daftar tingkat otoritas di dalam sistem.
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR(50)) - *Contoh: 'superadmin', 'kesra', 'kecamatan', 'pendamping'*
- `created_at` & `updated_at` (TIMESTAMP)

### 2. Tabel `wilayah_kecamatan`
Menyimpan data wilayah administratif tingkat kecamatan.
- `id` (INT, Primary Key, Auto Increment)
- `nama_kecamatan` (VARCHAR(100))
- `created_at` & `updated_at` (TIMESTAMP)

### 3. Tabel `wilayah_kelurahan`
Menyimpan data wilayah administratif tingkat kelurahan yang terikat ke kecamatan.
- `id` (INT, Primary Key, Auto Increment)
- `kecamatan_id` (INT, Foreign Key -> `wilayah_kecamatan.id`)
- `nama_kelurahan` (VARCHAR(100))
- `created_at` & `updated_at` (TIMESTAMP)

### 4. Tabel `users`
Menyimpan informasi akun pengguna yang mengakses sistem.
- `id` (INT, Primary Key, Auto Increment)
- `name` (VARCHAR(150))
- `email` (VARCHAR(100), Unique)
- `password` (VARCHAR(255))
- `role_id` (INT, Foreign Key -> `roles.id`)
- `kecamatan_id` (INT, Foreign Key -> `wilayah_kecamatan.id`, Nullable)
- `kelurahan_id` (INT, Foreign Key -> `wilayah_kelurahan.id`, Nullable)
- `remember_token` (VARCHAR(100))
- `created_at` & `updated_at` (TIMESTAMP)

### 5. Tabel `anak_yatim`
Tabel utama untuk menyimpan data profil anak yatim yang didata.
- `id` (INT, Primary Key, Auto Increment)
- `nik` (VARCHAR(16), Unique) - *Nomor Induk Kependudukan*
- `nama_lengkap` (VARCHAR(150))
- `tempat_lahir` (VARCHAR(100))
- `tanggal_lahir` (DATE)
- `jenis_kelamin` (ENUM('L', 'P'))
- `status_anak` (ENUM('Yatim', 'Piatu', 'Yatim Piatu'))
- `alamat_lengkap` (TEXT)
- `kecamatan_id` (INT, Foreign Key -> `wilayah_kecamatan.id`)
- `kelurahan_id` (INT, Foreign Key -> `wilayah_kelurahan.id`)
- `nama_ibu_kandung` (VARCHAR(150), Nullable)
- `status_verifikasi` (ENUM('Pending', 'Disetujui Kecamatan', 'Disetujui Kesra', 'Ditolak'))
- `catatan_verifikasi` (TEXT, Nullable) - *Alasan jika data ditolak*
- `foto_anak` (VARCHAR(255), Nullable)
- `file_kk` (VARCHAR(255), Nullable) - *Path berkas Kartu Keluarga*
- `created_by` (INT, Foreign Key -> `users.id`) - *ID Pendamping yang menginput*
- `created_at` & `updated_at` (TIMESTAMP)

### 6. Tabel `bantuan`
Menyimpan data program bantuan yang disediakan oleh pemerintah/Kesra.
- `id` (INT, Primary Key, Auto Increment)
- `nama_bantuan` (VARCHAR(150)) - *Contoh: Santunan Bulanan, Beasiswa Pendidikan*
- `jenis_bantuan` (ENUM('Uang', 'Barang', 'Beasiswa'))
- `sumber_dana` (VARCHAR(100)) - *Contoh: APBD, Zakat*
- `periode` (VARCHAR(50)) - *Contoh: Tahap I 2026*
- `created_at` & `updated_at` (TIMESTAMP)

### 7. Tabel `penerima_bantuan`
Tabel relasi (pivot) untuk mencatat histori penyaluran bantuan kepada anak yatim.
- `id` (INT, Primary Key, Auto Increment)
- `anak_yatim_id` (INT, Foreign Key -> `anak_yatim.id`)
- `bantuan_id` (INT, Foreign Key -> `bantuan.id`)
- `tanggal_penerimaan` (DATE)
- `status_penyaluran` (ENUM('Proses', 'Tersalurkan', 'Gagal'))
- `created_at` & `updated_at` (TIMESTAMP)

---

## 🔁 Alur Kerja Sistem (Workflow)

1. **Input Data**: 📝 **Pendamping Kelurahan** menginput profil anak yatim baru dan mengunggah berkas persyaratan ke dalam sistem. Status awal data adalah `Pending`.
2. **Validasi Tahap 1**: 🔍 **Akun Kecamatan** memeriksa data yang masuk di wilayahnya. Jika berkas sesuai, status diubah menjadi `Disetujui Kecamatan`. Jika tidak, status diubah menjadi `Ditolak` disertai catatan perbaikan.
3. **Validasi Tahap 2 & Sinkronisasi**: 📑 **Kesra** melakukan verifikasi akhir terhadap data yang disetujui kecamatan untuk mengubah status menjadi `Disetujui Kesra`. Data inilah yang sah menjadi penerima program bantuan.
4. **Penyaluran Bantuan**: 🎁 **Kesra** membuat program bantuan di tabel `bantuan`, lalu menghubungkan anak-anak yatim yang lolos verifikasi ke dalam tabel `penerima_bantuan`.


## Agentic Development

Laravel's predictable structure and conventions make it ideal for AI coding agents like Claude Code, Cursor, and GitHub Copilot. Install [Laravel Boost](https://laravel.com/docs/ai) to supercharge your AI workflow:

```bash
composer require laravel/boost --dev

php artisan boost:install
```

Boost provides your agent 15+ tools and skills that help agents build Laravel applications while following best practices.

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
