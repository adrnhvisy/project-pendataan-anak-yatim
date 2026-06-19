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
    - Composer untuk manajemen _dependency_ PHP.
    - DomPDF / TCPDF untuk fitur cetak laporan PDF.

---

## 👥 Manajemen Pengguna & Pembagian Tugas (Roles & Responsibilities)

Sistem ini menerapkan _Role-Based Access Control_ (RBAC) yang membagi pengguna ke dalam 4 tingkatan tingkat otoritas:

| No  | Nama Role                        | Tingkat Otoritas  | Ruang Lingkup Kerja & Tugas Utama                                                                                                                                                                                                              |
| :-- | :------------------------------- | :---------------- | :--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| 1   | **Superadmin**                   | Sistem Global     | 🔑 Mengelola seluruh akun pengguna (semua role).<br>📊 Melakukan backup/restore database sistem.<br>🛠️ Memperbaiki konfigurasi global dan memantau log aktivitas sistem (_system logs_).                                                       |
| 2   | **Kesra (Kesejahteraan Rakyat)** | Kabupaten/Kota    | 📑 Menjadi validator akhir data anak yatim di tingkat pusat.<br>🎁 Mengelola master data program bantuan (menambah jenis bantuan baru).<br>📈 Melihat dan mengunduh laporan infografis data statistik anak yatim seluruh wilayah.              |
| 3   | **Kecamatan**                    | Tingkat Kecamatan | 🔍 Melakukan verifikasi dan validasi (Approval) data yang diajukan oleh Pendamping Kelurahan.<br>📂 Memantau perkembangan jumlah anak yatim khusus di wilayah kecamatannya.<br>🖨️ Mengunduh laporan berkala per kecamatan.                     |
| 4   | **Pendamping (Kelurahan)**       | Tingkat Kelurahan | 📝 Melakukan input data awal anak yatim langsung dari lapangan.<br>📸 Mengunggah berkas pendukung (Foto, KK, Akta Kelahiran).<br>🔄 Melakukan pembaruan (update) jika ada perubahan status anak (misal: usia melewati batas, pindah domisili). |

---

## 🗄️ Rancangan Struktur Tabel Database

Berikut adalah pembaruan struktur tabel basis data relasional yang dirancang sesuai dengan skema terbaru beserta penjelasannya:

### 1. Tabel `provinsi`

Menyimpan data wilayah administratif tingkat provinsi.

- `id` (BIGINT, Primary Key)
- `nama_provinsi` (VARCHAR)

### 2. Tabel `kabupaten`

Menyimpan data wilayah administratif tingkat kabupaten/kota.

- `id` (BIGINT, Primary Key)
- `provinsi_id` (BIGINT, Foreign Key -> `provinsi.id`)
- `nama_kabupaten` (VARCHAR)

### 3. Tabel `kecamatan`

Menyimpan data wilayah administratif tingkat kecamatan.

- `id` (BIGINT, Primary Key)
- `kabupaten_id` (BIGINT, Foreign Key -> `kabupaten.id`)
- `nama_kecamatan` (VARCHAR)

### 4. Tabel `kelurahan`

Menyimpan data wilayah administratif tingkat kelurahan/desa.

- `id` (BIGINT, Primary Key)
- `kecamatan_id` (BIGINT, Foreign Key -> `kecamatan.id`)
- `nama_kelurahan` (VARCHAR)
- `kode_pos` (CHAR(5))

### 5. Tabel `users`

Menyimpan informasi akun pengguna sistem beserta perannya (Superadmin, Kesra, Kecamatan, atau Pendamping).

- `id` (BIGINT, Primary Key)
- `name` (VARCHAR)
- `email` (VARCHAR, Unique)
- `password` (VARCHAR)
- `role` (ENUM)
- `kelurahan_id` (BIGINT, Foreign Key -> `kelurahan.id`)

### 6. Tabel `alamat`

Menyimpan data detail alamat yang dapat digunakan secara fleksibel untuk anak, orang tua, maupun wali.

- `id` (BIGINT, Primary Key)
- `alamat_lengkap` (TEXT)
- `rt` (CHAR(3))
- `rw` (CHAR(3))
- `kelurahan_id` (BIGINT, Foreign Key -> `kelurahan.id`)

### 7. Tabel `anak`

Tabel utama untuk menyimpan data profil anak yatim.

- `id` (BIGINT, Primary Key)
- `no_registrasi` (VARCHAR, Unique)
- `nama_lengkap` (VARCHAR)
- `no_kk` (VARCHAR)
- `nik` (CHAR(16), Unique)
- `tempat_lahir` (VARCHAR)
- `tanggal_lahir` (DATE)
- `jenis_kelamin` (ENUM)
- `status_anak` (VARCHAR)
- `no_rekening` (VARCHAR)
- `status_data` (VARCHAR)
- `alamat_domisili_id` (BIGINT, Foreign Key -> `alamat.id`)
- `kelurahan_id` (BIGINT, Foreign Key -> `kelurahan.id`)
- `created_by` (BIGINT, Foreign Key -> `users.id`)

### 8. Tabel `orang_tua`

Menyimpan data orang tua kandung dari anak.

- `id` (BIGINT, Primary Key)
- `anak_id` (BIGINT, Foreign Key -> `anak.id`)
- `jenis_orang_tua` (ENUM)
- `nama` (VARCHAR)
- `nik` (CHAR(16))
- `status_hidup` (ENUM)
- `pekerjaan` (VARCHAR)
- `alamat_id` (BIGINT, Foreign Key -> `alamat.id`)

### 9. Tabel `wali`

Menyimpan data wali pengasuh jika anak tidak tinggal bersama orang tua kandung.

- `id` (BIGINT, Primary Key)
- `anak_id` (BIGINT, Foreign Key -> `anak.id`)
- `nama` (VARCHAR)
- `nik` (CHAR(16))
- `hubungan_dengan_anak` (VARCHAR)
- `pekerjaan` (VARCHAR)
- `alamat_id` (BIGINT, Foreign Key -> `alamat.id`)

### 10. Tabel `kategori_dokumen`

Menyimpan referensi jenis-jenis dokumen persyaratan (misal: Kartu Keluarga, Akta Kelahiran, Surat Kematian).

- `id` (BIGINT, Primary Key)
- `nama_dokumen` (VARCHAR)
- `is_wajib` (BOOLEAN)

### 11. Tabel `dokumen_anak`

Menyimpan riwayat berkas digital yang diunggah sebagai persyaratan untuk masing-masing anak.

- `id` (BIGINT, Primary Key)
- `anak_id` (BIGINT, Foreign Key -> `anak.id`)
- `kategori_dok_id` (BIGINT, Foreign Key -> `kategori_dokumen.id`)
- `file_path` (VARCHAR)
- `status_verifikasi` (VARCHAR)

### 12. Tabel `status_histori`

Mencatat rekam jejak (_history_) perubahan status verifikasi data anak dari waktu ke waktu.

- `id` (BIGINT, Primary Key)
- `anak_id` (BIGINT, Foreign Key -> `anak.id`)
- `status_anak` (VARCHAR)
- `tanggal` (DATE)
- `keterangan` (TEXT)
- `created_by` (BIGINT, Foreign Key -> `users.id`)

### 13. Tabel `audit_logs`

Mencatat aktivitas log pengguna di dalam sistem untuk kebutuhan pemantauan dan keamanan.

- `id` (BIGINT, Primary Key)
- `user_id` (BIGINT, Foreign Key -> `users.id`)
- `action` (VARCHAR)
- `description` (TEXT)
- `ip_address` (VARCHAR)

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
