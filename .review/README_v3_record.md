# 批阅记录

- **源文件**：README.md
- **源文件路径**：c:/Project-semester-4/pendataan-anak-yatim/README.md
- **源文件版本**：未知
- **批阅时间**：20260721_1330
- **批阅版本**：v3
- **批注数量**：0
  - 评论：0
  - 删除：0
  - 后插：0
  - 前插：0

---

## 操作指令

> 指令已按**从后往前**排列（倒序），请严格按照顺序从上到下逐条执行。
> 每条指令提供了「文本锚点」用于精确定位，请优先通过锚点文本匹配来确认目标位置，blockIndex 仅作辅助参考。

---

## 原始数据（JSON）

> 如需精确操作，可使用以下 JSON 数据。其中 `blockIndex` 是基于空行分割的块索引（从0开始），`startOffset` 是目标文本在块内的字符偏移量（从0开始），可用于区分同一块内的重复文本。

```json
{
  "fileName": "README.md",
  "docVersion": "未知",
  "reviewVersion": 3,
  "annotationCount": 0,
  "rawMarkdown": "# BAB 1: Pendahuluan\n\n## 1.1 Latar Belakang\nSebelumnya, pendataan anak yatim penerima bantuan di Kabupaten Pelalawan masih dilakukan secara manual atau menggunakan data yang tersebar di berbagai instansi. Hal ini sering kali menimbulkan berbagai kendala, seperti keterlambatan proses verifikasi berjenjang, sulitnya melakukan *monitoring* secara *real-time*, hingga kendala dalam penyusunan laporan rekapitulasi.\n\nUntuk menyelesaikan permasalahan tersebut, dibangunlah SAHABAT (Sistem Administrasi Hibah Bantuan Anak Yatim). SAHABAT merupakan aplikasi berbasis web yang dirancang khusus sebagai solusi digital untuk menyederhanakan dan mengintegrasikan proses pendataan, pengelolaan dokumen, verifikasi, hingga pelaporan administrasi anak yatim secara terpusat.\n\n## 1.2 Dasar Hukum\nPelaksanaan sistem SAHABAT dilandasi oleh peraturan-peraturan berikut:\n* [Peraturan Daerah Kabupaten Pelalawan Nomor ... Tahun ...]\n* [Peraturan Bupati Pelalawan Nomor ... Tahun ...]\n* [Surat Keputusan Bupati Nomor ...]\n* [Peraturan terkait lainnya]\n\n## 1.3 Tujuan Sistem\nPenggunaan aplikasi SAHABAT ditujukan untuk:\n* Meningkatkan akurasi dan validitas data penerima bantuan.\n* Mengurangi risiko duplikasi data anak yatim antar wilayah.\n* Meningkatkan transparansi dan akuntabilitas proses pengajuan.\n* Menyediakan rekam jejak (*histori*) perubahan data untuk mendukung proses audit.\n* Mendukung proses *monitoring* secara lintas wilayah dari tingkat Kelurahan hingga Kabupaten.\n\n## 1.4 Ruang Lingkup Sistem\nAplikasi SAHABAT mencakup modul dan fitur operasional berikut:\n1. Pendataan Anak (Identitas, Orang Tua, Wali, Pendidikan).\n2. Pengelolaan Dokumen Persyaratan Digital.\n3. Verifikasi Data Berjenjang (Alur Persetujuan/Revisi/Penolakan).\n4. Pelaporan dan Rekapitulasi Data.\n5. Manajemen Pengguna dan Wilayah.\n6. Pencatatan Log Aktivitas (*Audit Log*).\n\n**Batasan Sistem:**\nAplikasi SAHABAT **bukan** merupakan sistem pengelolaan keuangan daerah dan **tidak digunakan** untuk proses pencairan dana hibah secara langsung. Sistem ini berfokus murni pada administrasi pendataan, verifikasi syarat, pengelolaan dokumen, dan pelaporan status anak penerima bantuan.\n\n## 1.5 Sasaran Pengguna\nSistem ini beroperasi dengan batasan hak akses yang ketat. Setiap pengguna hanya dapat mengakses modul dan data sesuai dengan kewenangannya:\n1. **Superadmin:** Mengelola konfigurasi sistem, memantau *audit log*, serta mengatur manajemen pengguna (*User, Role, Permission*) dan data wilayah.\n2. **Admin Bupati:** Memiliki kewenangan untuk melakukan ulasan (*review*), memverifikasi data (menyetujui, menolak, atau meminta revisi), serta memantau laporan di tingkat Kabupaten.\n3. **Admin Kecamatan:** Memiliki hak akses untuk melakukan *monitoring* dan melihat statistik data seluruh kelurahan yang berada di bawah wilayah administrasinya.\n4. **Admin Kelurahan:** Bertindak sebagai operator lapangan yang bertugas menginput data anak, mengunggah dokumen, dan memantau status pengajuan di wilayah kelurahannya.\n\n## 1.6 Persyaratan Penggunaan Sistem\nUntuk dapat menggunakan sistem SAHABAT, pengguna harus memastikan hal-hal berikut:\n* Memiliki koneksi jaringan internet yang stabil.\n* Memiliki akun pengguna yang berstatus aktif.\n* Menggunakan *Username/Email* dan *Password* yang sah.\n* Memiliki hak akses (*Role*) dan pembagian wilayah yang telah ditetapkan oleh Superadmin.\n* Menggunakan peramban web (*browser*) modern (seperti Google Chrome, Mozilla Firefox, atau Microsoft Edge) yang diperbarui untuk kenyamanan akses antarmuka.\n\n## 1.7 Istilah dan Singkatan\n* **SAHABAT:** Sistem Administrasi Hibah Bantuan Anak Yatim.\n* **Draf:** Status awal data anak yang sedang diisi oleh Kelurahan dan belum diajukan.\n* **Verifikasi:** Proses pengecekan keabsahan data dan dokumen oleh Admin Bupati.\n* **Audit Log:** Catatan riwayat aktivitas yang merekam setiap tindakan (tambah, ubah, hapus) di dalam sistem.\n\n\n# BAB 2: Pengenalan Sistem\n\n## 2.1 Gambaran Umum Sistem\nSAHABAT dirancang sebagai platform terpadu yang memusatkan seluruh aktivitas pengelolaan bantuan hibah anak yatim. Sistem ini menghubungkan berbagai tingkat pemerintahan (Kelurahan, Kecamatan, dan Kabupaten) ke dalam satu lingkungan digital yang sama. Dengan konsep ini, setiap pemangku kepentingan dapat bekerja pada data yang sama secara *real-time* sesuai dengan kewenangan masing-masing, meminimalisir redudansi, dan mempercepat proses birokrasi.\n\n## 2.2 Alur Bisnis\nProses pendataan di dalam aplikasi SAHABAT mengikuti alur birokrasi yang berjenjang. Proses dimulai oleh Admin Kelurahan melalui menu Data Anak. Setelah seluruh identitas dan dokumen persyaratan dilengkapi, data tersebut diajukan untuk proses verifikasi. \n\nDi tingkat selanjutnya, Admin Kecamatan memiliki hak untuk melakukan pemantauan terhadap seluruh data yang diajukan pada wilayah administrasinya tanpa dapat mengubah isi data. Terakhir, Admin Bupati melakukan pemeriksaan administrasi tingkat kabupaten dan memberikan keputusan akhir, yaitu berupa persetujuan, permintaan revisi kembali ke kelurahan, atau penolakan. Seluruh aktivitas perubahan status ini dicatat secara otomatis ke dalam *Audit Log* sehingga dapat ditelusuri kembali apabila diperlukan.\n\n## 2.3 Diagram Alur Bisnis\nVisualisasi di bawah ini menggambarkan perjalanan data dari tahap input hingga keputusan akhir:\n\n```mermaid\nflowchart LR\n    A[Admin Kelurahan] --> B[Input Data Anak]\n    B --> C[Upload Dokumen]\n    C --> D[Submit Verifikasi]\n    D --> E[Monitoring Kecamatan]\n    E --> F[Verifikasi Admin Bupati]\n    F --> G([Disetujui])\n    F --> H([Ditolak])\n\n    style A fill:#f9f9f9,stroke:#333,stroke-width:2px\n    style G fill:#d4edda,stroke:#28a745\n    style H fill:#fff3cd,stroke:#ffc107\n    \n```\n",
  "annotations": []
}
```