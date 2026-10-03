# Product Overview

## Nama Produk
Afterlight C of Kaputama

## Latar Belakang
Kelas membutuhkan sebuah sistem terpusat untuk memperkenalkan identitas kelas sekaligus mengelola operasional administrasi kelas. Selama ini informasi seperti jadwal perkuliahan, absensi, materi, data mahasiswa, dan keuangan kas kelas sering tersebar di chat, spreadsheet, atau pencatatan manual. Kondisi ini menimbulkan risiko data hilang, duplikasi informasi, sulitnya audit, dan kurangnya transparansi.

Sistem ini dibuat sebagai platform berbasis web yang menjadi sumber informasi resmi kelas, sekaligus alat bantu manajemen untuk administrasi akademik dan keuangan kelas.

## Tujuan Aplikasi
Aplikasi ini bertujuan untuk:

1. Memperkenalkan kelas secara digital.
2. Menyediakan pusat informasi jadwal perkuliahan.
3. Mengelola absensi pertemuan perkuliahan secara terstruktur.
4. Menyediakan arsip materi perkuliahan.
5. Mengelola data mahasiswa.
6. Membagi hak akses berdasarkan peran: komting, wakil komting, sekretaris, bendahara, dan mahasiswa.
7. Mengelola pembayaran uang kas kelas secara manual dan QRIS manual.
8. Menyediakan laporan keuangan kas yang transparan.
9. Mengirim invoice pembayaran uang kas ke email mahasiswa setelah pembayaran divalidasi.
10. Meningkatkan akuntabilitas, transparansi, dan kerapian administrasi kelas.

## Target Pengguna

### 1. Komting
Pengguna dengan hak akses penuh terhadap sistem kelas. Bertanggung jawab mengelola struktur pengguna, role, dan kebijakan umum sistem.

### 2. Wakil Komting
Pengguna yang membantu komting, terutama dalam validasi pertemuan dan absensi.

### 3. Sekretaris
Pengguna yang mengurus pembuatan pertemuan dan pencatatan absensi kehadiran mahasiswa.

### 4. Bendahara
Pengguna yang bertanggung jawab atas pencatatan uang kas, validasi pembayaran, pengelolaan pemasukan/pengeluaran, dan laporan keuangan.

### 5. Mahasiswa Biasa
Pengguna yang dapat melihat informasi kelas, jadwal, absensi pribadi, materi, serta melakukan pembayaran kas dan melihat riwayat pembayaran.

## Fitur Utama

### 1. Authentication & Authorization
- Login dan logout.
- Pembatasan akses berdasarkan role.
- Dashboard berbeda untuk setiap role.
- Komting dapat menentukan role pengguna.

### 2. Manajemen Data Mahasiswa
- Data profil mahasiswa.
- NPM unik.
- Status aktif/nonaktif.
- Relasi antara akun login dan profil mahasiswa.

### 3. Manajemen Mata Kuliah & Jadwal
- Input mata kuliah.
- Kode mata kuliah.
- Nama mata kuliah.
- Dosen pengampu.
- Hari kuliah.
- Jam mulai dan jam selesai.
- Tampilan jadwal perkuliahan.

### 4. Pertemuan & Absensi
- Pembuatan pertemuan perkuliahan.
- Pencatatan absensi mahasiswa.
- Status absensi: hadir, izin, sakit, alpha.
- Pengajuan absensi oleh sekretaris.
- Validasi absensi oleh wakil komting.
- Penguncian data setelah validasi.

### 5. Manajemen Materi
- Upload materi per mata kuliah.
- Arsip materi.
- Download materi oleh pengguna berwenang.
- Penyimpanan file secara private.

### 6. Pembayaran Uang Kas
Dua metode pembayaran:

#### Metode Manual
- Mahasiswa membayar secara fisik.
- Bendahara mencatat pembayaran di sistem.
- Pembayaran langsung dianggap valid.
- Invoice dikirim ke email mahasiswa.

#### Metode QRIS Manual
- Mahasiswa melihat QRIS di sistem.
- Mahasiswa melakukan transfer manual.
- Mahasiswa upload bukti pembayaran.
- Bendahara memeriksa bukti dan mutasi.
- Bendahara approve atau reject.
- Invoice dikirim setelah pembayaran disetujui.

### 7. Manajemen Keuangan Kas
- Pencatatan pemasukan.
- Pencatatan pengeluaran.
- Total kas per semester.
- Total kas keseluruhan.
- Daftar tunggakan mahasiswa.
- Laporan bulanan.
- Riwayat pembayaran.

### 8. Invoice Digital
Invoice dikirim ke email mahasiswa setelah pembayaran disetujui. Invoice berisi:
- Kode struk pembayaran.
- Nama mahasiswa.
- NPM.
- Waktu validasi bendahara.
- Nominal pembayaran.
- Sisa tunggakan.
- Pernyataan validasi.
- Nama bendahara.
- Jabatan bendahara.

## Tujuan Bisnis / Nilai Proyek

### 1. Transparansi Keuangan
Semua pembayaran dan pengeluaran kas tercatat secara rapi dan dapat dipertanggungjawabkan.

### 2. Akuntabilitas Role
Setiap peran memiliki batas akses yang jelas. Aksi penting dicatat dalam audit log.

### 3. Efisiensi Administrasi
Sekretaris, bendahara, dan komting tidak perlu lagi mencatat manual di banyak tempat.

### 4. Arsip Digital
Materi kuliah dan riwayat pembayaran tersimpan secara digital dan dapat diakses kembali.

### 5. Pengalaman Pengguna yang Terstruktur
Setiap role memiliki dashboard dan menu yang sesuai dengan tanggung jawabnya.

### 6. Kepercayaan Anggota Kelas
Mahasiswa dapat melihat riwayat pembayaran dan invoice mereka sendiri secara mandiri.

## Success Metrics

1. Semua role hanya dapat mengakses fitur yang diizinkan.
2. Komting berhasil mengelola role pengguna.
3. Pertemuan dan absensi dapat dibuat, diajukan, serta divalidasi sesuai workflow.
4. Pembayaran manual dan QRIS dapat dicatat sampai invoice terkirim.
5. Tunggakan kas dapat dihitung secara akurat.
6. Laporan keuangan per bulan dan per semester dapat dilihat bendahara.
7. File materi dan bukti pembayaran tidak dapat diakses oleh pengguna yang tidak berwenang.
8. Tidak ada data penting yang hilang karena pencatatan manual.
9. Sistem dapat diaudit melalui activity log.

## Ruang Lingkup MVP

### Termasuk
- Authentication.
- Role-based access control.
- Manajemen mahasiswa.
- Manajemen mata kuliah.
- Jadwal perkuliahan.
- Pertemuan.
- Absensi.
- Validasi absensi.
- Materi dan arsip materi.
- Pembayaran kas manual.
- Pembayaran kas QRIS manual.
- Invoice email.
- Laporan keuangan sederhana.
- Dashboard per role.
- Audit log untuk aksi penting.

### Tidak Termasuk
- Integrasi payment gateway otomatis.
- QRIS dinamis real-time dari payment gateway.
- Absensi berbasis geolocation.
- Absensi berbasis QR scanning real-time.
- E-learning penuh seperti tugas dan penilaian.
- Sistem akademik kampus resmi.
- Integrasi langsung ke sistem keuangan kampus.

## Prinsip Produk

1. **Aman secara default**: semua akses harus melalui authentication, authorization, dan validasi server-side.
2. **Transparan**: keuangan dan riwayat pembayaran dapat dipertanggungjawabkan.
3. **Mudah digunakan**: antarmuka berbasis role mengurangi kebingungan pengguna.
4. **Audit-friendly**: aksi penting dapat dilacak.
5. **Bertahap**: sistem dibangun modular agar mudah dikembangkan.
6. **Data konsisten**: transaksi finansial dan validasi absensi harus menjaga integritas data.

## Keputusan Teknis yang Dipengaruhi Kebutuhan Produk

### 1. Penggunaan UUID
UUID digunakan sebagai primary key untuk tabel domain agar ID tidak mudah ditebak dan lebih aman untuk resource yang diakses melalui URL.

### 2. Role-Based Access Control
Karena setiap jabatan memiliki tanggung jawab berbeda, sistem menggunakan role, permission, dan policy.

### 3. DDD Ringan
Fitur sistem cukup banyak, sehingga logic bisnis dipisahkan ke domain action/service agar controller tetap tipis dan mudah dirawat.

### 4. Supabase PostgreSQL
Supabase dipilih sebagai database PostgreSQL managed yang cocok untuk aplikasi Laravel.

### 5. Supabase Storage
File materi, bukti pembayaran, dan invoice disimpan secara private menggunakan object storage.

### 6. Invoice Berbasis PDF dan Email
Produk membutuhkan bukti pembayaran resmi yang dapat dikirim otomatis ke mahasiswa.

### 7. Queue untuk Email
Pengiriman invoice tidak boleh menghambat proses approve payment, sehingga email dikirim melalui queue.

### 8. Audit Log
Karena sistem mengelola keuangan dan data akademik, setiap aksi sensitif perlu dicatat.