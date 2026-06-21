# 📋 Sistem Informasi Pendataan Anak Yatim

Sistem Informasi Pendataan Anak Yatim adalah sebuah platform digital yang dirancang untuk mengelola, memvalidasi, dan menyalurkan bantuan kepada anak yatim secara terstruktur. Sistem ini membagi tingkatan akses pengguna mulai dari tingkat Kelurahan, Kecamatan, Dinas Kesejahteraan Rakyat (Kesra), hingga Superadmin untuk memastikan akurasi data yang dilaporkan dari lapangan.

---

## 🛠️ Teknologi, Framework, dan Package yang Digunakan

Proyek ini dibangun menggunakan kombinasi teknologi modern dan beberapa *package* tambahan untuk mempercepat proses pengembangan, mengatur hak akses, dan memastikan keamanan sistem. Berikut adalah rincian alat yang digunakan dan telah terinstal di dalam proyek:

### 1. Core Framework & Database
- **Laravel (Versi 13.x / PHP 8.3)**: Kerangka kerja (*framework*) utama di sisi *backend* yang mengatur alur logika aplikasi, rute (*routing*), dan interaksi dengan *database*.
- **MySQL / MariaDB**: Sistem manajemen basis data relasional (RDBMS) untuk menyimpan seluruh data sistem secara terstruktur.
- **Composer**: Manajer dependensi untuk bahasa pemrograman PHP. *Tool* ini digunakan untuk menginisialisasi proyek Laravel (`composer create-project`) dan mengelola seluruh pustaka pihak ketiga.

### 2. Pustaka (Package) Utama yang Telah Diinstal
Berdasarkan konfigurasi proyek, sistem ini mengandalkan dua *package* utama untuk mengatur pintu masuk dan hak akses pengguna:

- **Laravel Breeze (dengan antarmuka Blade)**: 
  *Package* resmi dari Laravel yang digunakan untuk membangun fondasi autentikasi pengguna secara instan (*login, register, logout, session*). Pemasangan *package* ini (`breeze:install blade`) secara otomatis menyiapkan antarmuka pengguna berbasis **Tailwind CSS** dan struktur *templating* **Blade**.
- **Spatie Laravel Permission**: 
  *Package* pihak ketiga yang khusus diinstal untuk menangani sistem **Role-Based Access Control (RBAC)**. Alat ini memudahkan pengelolaan berbagai peran pengguna (Superadmin, Kesra, Kecamatan, Pendamping) beserta izin akses (hak untuk menambah, memvalidasi, atau menghapus data) langsung melalui *database*.

### 3. Tools Pendukung Lainnya
- **Git & GitHub**: Digunakan untuk manajemen repositori kode (melacak versi dan perubahan file).

### 4. Pustaka Ekspor/Impor Data (Pelaporan)
- **Laravel Excel (Maatwebsite)**: 📊 Pustaka khusus untuk mengekspor data dari *database* ke format `.xlsx` atau `.csv`, serta mengimpor sekumpulan data dari *file* Excel langsung ke dalam sistem.
- **Laravel DomPDF (Barryvdh)**: 📄 Pustaka untuk men-*generate* tampilan halaman web (HTML/Blade) menjadi dokumen PDF yang siap cetak atau diunduh.

### 🚀 Langkah Instalasi Tambahan

Untuk menginstal alat pembuat PDF dan Excel tersebut, jalankan perintah ini di terminal:

```bash
# Menginstal pustaka untuk fitur Excel
composer require maatwebsite/excel

# Menginstal pustaka untuk fitur cetak PDF
composer require barryvdh/laravel-dompdf

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

## 🔐 Hak Akses & Visibilitas Data (Data Scoping)

Sistem ini menerapkan pembatasan visibilitas data (*Row-Level Security*) untuk memastikan setiap pengguna hanya dapat memantau dan memvalidasi data anak yatim sesuai dengan wilayah wewenangnya. Berikut adalah aturan sistemnya:

### 1. Tingkat Kesra (Top Level)
- **Cakupan Akses**: Seluruh data kabupaten/kota.
- **Tampilan Antarmuka**: Terdapat *dropdown filter* pencarian untuk **Kecamatan** dan **Kelurahan**.
- **Logika Kueri (Query)**: Secara *default* dapat membaca semua baris di tabel `anak`. Jika *filter* dipilih, sistem akan memfilter berdasarkan `kecamatan_id` atau `kelurahan_id`.

### 2. Tingkat Kecamatan (Middle Level)
- **Cakupan Akses**: Terkunci khusus untuk data yang berada di kecamatannya saja.
- **Tampilan Antarmuka**: Hanya terdapat *dropdown filter* untuk **Kelurahan** (opsi yang muncul hanya kelurahan yang berada di bawah naungan kecamatan tersebut).
- **Logika Kueri (Query)**: Sistem selalu menyisipkan filter wajib `WHERE kecamatan_id = [ID_Kecamatan_User]` di setiap pencarian atau ekspor data.

### 3. Tingkat Pendamping / Kelurahan (Bottom Level)
- **Cakupan Akses**: Terkunci absolut hanya untuk kelurahannya sendiri.
- **Tampilan Antarmuka**: Tidak ada *filter* pencarian wilayah sama sekali.
- **Logika Kueri (Query)**: Sistem mengunci data secara ketat dengan `WHERE kelurahan_id = [ID_Kelurahan_User]`. Akun pendamping tidak akan bisa mengintip atau mengubah data dari kelurahan tetangga.

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
