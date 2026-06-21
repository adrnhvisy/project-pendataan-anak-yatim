# Architecture Guide

> Dokumentasi arsitektur proyek **Sistem Pendataan Anak Yatim** menggunakan Laravel 13.

---

# Tujuan Arsitektur

Project ini tidak dirancang hanya untuk memenuhi kebutuhan CRUD sederhana, tetapi untuk aplikasi pemerintahan yang memiliki:

* Role Based Access Control (RBAC)
* Workflow Verifikasi Bertingkat
* Upload Dokumen
* Audit Log
* Histori Status
* Laporan
* Skalabilitas jangka panjang

Karena itu, arsitektur harus menjaga agar business logic tidak menumpuk pada Controller maupun Model.

---

# Prinsip Arsitektur

Project mengikuti prinsip berikut:

* Single Responsibility Principle (SRP)
* Separation of Concern
* Thin Controller
* Fat Service (secukupnya)
* Domain Modular
* Reusable Component
* Maintainable Code

---

# Alur Request

Setiap request idealnya mengikuti alur berikut:

```
Request
      │
      ▼
Controller
      │
      ▼
Form Request
      │
      ▼
DTO
      │
      ▼
Service
      │
      ▼
Action (opsional)
      │
      ▼
Repository
      │
      ▼
Model
      │
      ▼
Observer / Event
```

Setiap layer memiliki tanggung jawab yang berbeda sehingga kode tidak saling bercampur.

---

# Controller

Controller hanya bertugas sebagai penghubung antara HTTP Request dengan Service.

Controller **tidak boleh** berisi:

* Query kompleks
* Validasi manual
* Upload File
* Business Logic
* Perhitungan
* Approval

Controller idealnya hanya:

```php
public function store(StoreAnakRequest $request)
{
    $this->anakService->store(
        CreateAnakDTO::fromRequest($request)
    );

    return redirect()->route('anak.index');
}
```

Target ukuran Controller:

* 20 - 150 baris

Jika melebihi 200 baris, evaluasi kembali tanggung jawabnya.

---

# Form Request

Semua validasi dipindahkan ke Form Request.

Contoh:

```
StoreAnakRequest
UpdateAnakRequest
ApproveAnakRequest
RejectAnakRequest
UploadDokumenRequest
ExportLaporanRequest
```

Controller tidak boleh menggunakan:

```php
$request->validate(...)
```

---

# DTO (Data Transfer Object)

DTO digunakan untuk membawa data dari Controller ke Service.

Contoh:

```
CreateAnakDTO
UpdateAnakDTO
UploadDokumenDTO
```

Service tidak menerima Request secara langsung.

Yang diterima adalah DTO.

Keuntungan:

* Mudah Testing
* Lebih Aman
* Tidak tergantung HTTP Request

---

# Service

Service berisi Business Logic.

Contoh:

```
AnakService

store()

update()

delete()
```

Service tidak boleh menangani HTTP.

Service juga tidak menghasilkan Response.

---

# Repository

Repository bertugas mengelola Query Database.

Contoh:

```
AnakRepository

paginate()

find()

search()

approved()

pending()

findByWilayah()
```

Semua query panjang dipindahkan ke Repository.

Service tidak boleh dipenuhi query Eloquent yang sangat panjang.

---

# Action

Action digunakan apabila terdapat satu proses bisnis yang cukup kompleks.

Misalnya:

```
ApproveAnakAction

RejectAnakAction

CreateAnakAction

UploadDokumenAction
```

Satu Action hanya memiliki satu pekerjaan.

---

# Observer

Observer digunakan untuk proses otomatis setelah Model berubah.

Contoh:

```
AnakObserver

created()

updated()

deleted()
```

Misalnya:

Saat Anak dibuat

* membuat audit log
* membuat histori
* mengirim notifikasi

Semuanya tidak ditulis di Controller.

---

# Service yang Direkomendasikan

```
Services

AnakService

DokumenService

VerifikasiService

LaporanService

UserService

WilayahService

AuditService

DashboardService
```

Jangan hanya memiliki satu Service.

Pisahkan berdasarkan domain bisnis.

---

# Struktur Controller

Disarankan menggunakan folder.

```
Controllers

Anak

    AnakController

    DokumenController

    VerifikasiController

User

Dashboard

Laporan
```

Daripada satu Controller berisi puluhan method.

---

# Struktur Views

Pisahkan component Blade.

```
views

anak

    index

    create

    edit

    show

    components

        form

        biodata

        dokumen

        timeline

        verifikasi
```

Blade menjadi reusable.

---

# Enum

Semua status sebaiknya menggunakan Enum.

Contoh:

```
Role

StatusVerifikasi

JenisKelamin

StatusOrangTua
```

Jangan menggunakan string secara langsung.

Contoh yang buruk:

```
Pending

Approved

Rejected
```

Lebih baik:

```
StatusVerifikasi::Pending
```

---

# Authorization

Jika tidak menggunakan Policy,

buat satu Service khusus.

Misalnya:

```
AuthorizationService
```

Hindari:

```
if(auth()->user()->hasRole(...))
```

yang tersebar di seluruh Controller.

---

# Dashboard

Jangan membuat DashboardController dengan banyak percabangan Role.

Gunakan Strategy Pattern.

```
DashboardService

↓

SuperadminDashboard

KesraDashboard

KecamatanDashboard

PendampingDashboard
```

Masing-masing bertanggung jawab pada dashboard miliknya sendiri.

---

# Upload Dokumen

Dokumen adalah domain tersendiri.

Pisahkan menjadi:

```
DokumenController

DokumenService

DokumenRepository
```

Karena kemungkinan berkembang:

* Preview
* Download
* Replace
* Versioning
* Watermark
* Kompresi

---

# Audit Log

Jangan memanggil

```
AuditLog::create()
```

di banyak tempat.

Gunakan:

```
AuditService

log()
```

atau

```
ActivityLogger
```

---

# Struktur Folder yang Direkomendasikan

```
app/
├── Domain/
│   ├── Anak/
│   │   ├── Actions/       # Menyimpan proses bisnis spesifik (misal: CreateAnakAction)
│   │   ├── DTO/           # Data Transfer Object pembawa request dari Controller ke Service
│   │   ├── Enums/         # Enum khusus domain anak (misal: StatusAnak, JenisKelamin)
│   │   ├── Models/        # Model Eloquent untuk Anak, OrangTua, Wali, StatusHistori
│   │   ├── Observers/     # Menangani event otomatis setelah Model Anak berubah
│   │   ├── Repositories/  # Tempat menyimpan kueri kompleks (database logic) untuk Anak
│   │   └── Services/      # Business logic utama untuk manajemen anak yatim
│   │
│   ├── Dokumen/
│   │   ├── Actions/       # Proses bisnis khusus dokumen (misal: UploadDokumenAction)
│   │   ├── DTO/           # Objek transfer data untuk upload/update dokumen
│   │   ├── Models/        # Model DokumenAnak, KategoriDokumen
│   │   ├── Repositories/  # Kueri pencarian, filter, dan status dokumen
│   │   └── Services/      # Logika kompresi, penyimpanan, validasi, dan watermark
│   │
│   ├── Verifikasi/
│   │   ├── Actions/       # Action untuk Approve/Reject persetujuan bertingkat
│   │   ├── Enums/         # Enum status verifikasi (Draft, Pending, Disetujui, Ditolak)
│   │   └── Services/      # Logika persetujuan bertingkat dari Kecamatan hingga Kesra
│   │
│   ├── Wilayah/
│   │   ├── Models/        # Model Provinsi, Kabupaten, Kecamatan, Kelurahan, Alamat
│   │   ├── Repositories/  # Kueri pemetaan dan hierarki wilayah
│   │   └── Services/      # Layanan penyedia data wilayah untuk dropdown & relasi
│   │
│   ├── User/
│   │   ├── Models/        # Model User (Admin, Kesra, Kecamatan, Pendamping)
│   │   ├── Repositories/  # Kueri pengelolaan akun
│   │   └── Services/      # Layanan manajemen pengguna dan profil
│   │
│   ├── Bantuan/           # (Untuk pengembangan ke depan terkait Anggaran/Penyaluran)
│   │   ├── Models/        
│   │   └── Services/      
│   │
│   ├── Dashboard/
│   │   ├── Contracts/     # Interface untuk memisahkan logika dashboard per Role
│   │   └── Services/      # Strategy pattern (SuperadminDashboard, KesraDashboard, dll)
│   │
│   └── Audit/
│       ├── Models/        # Model AuditLog
│       └── Services/      # Layanan perekaman log aktivitas pengguna
│
├── Http/
│   ├── Controllers/
│   │   ├── Anak/          # Controller HTTP khusus fitur Anak
│   │   ├── Dokumen/       # Controller HTTP khusus dokumen
│   │   ├── Verifikasi/    # Controller HTTP untuk persetujuan
│   │   ├── Laporan/       # Controller HTTP untuk export/import
│   │   ├── User/          # Controller HTTP manajemen pengguna
│   │   └── Dashboard/     # Controller perantara untuk menampilkan halaman dashboard
│   ├── Requests/          # Form Request untuk seluruh validasi input dari user
│   └── Middleware/        # Middleware custom (seperti filter akses role)
│
├── Enums/                 # Enum global yang dipakai lintas domain (misal: Role)
├── Helpers/               # Fungsi bantuan global (opsional)
├── Policies/              # Aturan otorisasi yang terikat dengan model (Gate)
└── Traits/                # Kode yang dapat digunakan ulang lintas class (Reusable components)
```

---

# Target Ukuran File

Sebagai pedoman:

| Komponen   | Target         |
| ---------- | -------------- |
| Controller | < 150 baris    |
| Service    | < 300 baris    |
| Repository | < 300 baris    |
| Model      | < 200 baris    |
| Observer   | < 150 baris    |
| Action     | 30 - 100 baris |

Jika file mulai melebihi ukuran tersebut, evaluasi apakah tanggung jawabnya sudah terlalu banyak.

---

# Prinsip Pengembangan

Saat menambahkan fitur baru, tanyakan terlebih dahulu:

1. Apakah ini Business Logic?
   → Masuk Service.

2. Apakah ini Query Database?
   → Masuk Repository.

3. Apakah ini Validasi?
   → Masuk Form Request.

4. Apakah ini hanya satu proses khusus?
   → Jadikan Action.

5. Apakah ini otomatis setelah Model berubah?
   → Gunakan Observer.

6. Apakah ini Status?
   → Gunakan Enum.

---

# Kesimpulan

Tujuan utama arsitektur ini adalah menjaga agar project tetap mudah dipelihara ketika ukuran sistem semakin besar.

Controller tetap tipis.

Business Logic tetap terpisah.

Query tetap terorganisir.

Kode lebih mudah diuji, dikembangkan, dan dipahami oleh developer lain.
