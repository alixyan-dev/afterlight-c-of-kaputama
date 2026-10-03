# Requirements

## Informasi Umum

### Nama Sistem
Afterlight C of Kaputama

### Platform
Web application

### Teknologi Utama
- Laravel 13
- React
- TypeScript
- shadcn/ui
- Inertia.js
- Supabase PostgreSQL
- Supabase Storage
- OpenCode / Laravel Boost AI agent

## Tujuan Sistem
Sistem ini dibuat untuk memperkenalkan kelas dan menyediakan manajemen informasi kelas yang mencakup jadwal perkuliahan, absensi, mata kuliah, materi, data mahasiswa, role-based access, pembayaran uang kas, dan laporan keuangan.

## Role Pengguna

### 1. Komting
Role dengan hak akses penuh.

Tanggung jawab:
- Mengelola sistem secara keseluruhan.
- Mengubah role pengguna.
- Mengelola data mahasiswa.
- Mengakses semua fitur.
- Melihat laporan dan audit.

### 2. Wakil Komting
Tanggung jawab:
- Membuat pertemuan perkuliahan.
- Memeriksa pertemuan.
- Memvalidasi absensi setelah diajukan sekretaris.
- Melihat data akademik yang relevan.

### 3. Sekretaris
Tanggung jawab:
- Membuat pertemuan perkuliahan.
- Mengisi absensi kehadiran.
- Mengajukan absensi untuk divalidasi.
- Melihat jadwal dan data pendukung yang relevan.

### 4. Bendahara
Tanggung jawab:
- Mencatat pembayaran manual.
- Memvalidasi pembayaran QRIS.
- Menolak pembayaran yang tidak sesuai.
- Mengelola pemasukan dan pengeluaran kas.
- Melihat laporan keuangan.
- Melihat tunggakan mahasiswa.

### 5. Mahasiswa Biasa
Hak akses:
- Melihat jadwal.
- Melihat absensi pribadi.
- Mengunduh materi.
- Melakukan pembayaran QRIS.
- Upload bukti pembayaran.
- Melihat riwayat pembayaran.
- Melihat invoice pribadi.

## Functional Requirements

### FR-01 Authentication
Sistem harus menyediakan:
- Login.
- Logout.
- Register opsional.
- Reset password opsional.
- Session authentication.
- Password hashing.
- Proteksi route berdasarkan login.

### FR-02 Role-Based Access Control
Sistem harus memiliki role:
- `komting`
- `wakil_komting`
- `sekretaris`
- `bendahara`
- `mahasiswa`

Aturan:
- Komting dapat mengubah role pengguna.
- Setiap role memiliki dashboard berbeda.
- Setiap route sensitif harus dicek di backend.
- Frontend tidak boleh menjadi satu-satunya sumber authorization.

### FR-03 Data Mahasiswa
Sistem harus dapat mengelola data mahasiswa.

Field minimal:
- Nama.
- Email.
- NPM.
- Kelas.
- Nomor telepon opsional.
- Status aktif.

Aturan:
- NPM unik.
- Satu user dapat memiliki satu student profile.
- Data mahasiswa hanya dapat dikelola oleh role berwenang.

### FR-04 Semester
Sistem harus mendukung data semester.

Field minimal:
- Nama semester.
- Tahun ajaran.
- Tanggal mulai.
- Tanggal selesai.
- Status aktif.

### FR-05 Mata Kuliah
Sistem harus dapat menginput mata kuliah.

Field minimal:
- Kode mata kuliah.
- Nama mata kuliah.
- Dosen pengampu.
- Hari.
- Jam mulai.
- Jam selesai.
- Semester opsional.
- Ruangan opsional.

Fitur:
- Daftar mata kuliah.
- Jadwal per hari.
- Jadwal per semester.
- Manage mata kuliah oleh role berwenang.

### FR-06 Pertemuan Perkuliahan
Sistem harus dapat membuat pertemuan.

Field minimal:
- Mata kuliah.
- Semester.
- Nomor pertemuan.
- Judul.
- Agenda.
- Tanggal.
- Jam mulai.
- Jam selesai.
- Lokasi.
- Status.
- Pembuat.
- Validator.

Status pertemuan:
- draft
- submitted
- validated
- rejected
- cancelled

Aturan:
- Sekretaris dapat membuat pertemuan.
- Wakil komting dapat membuat pertemuan.
- Komting dapat membuat pertemuan.
- Pertemuan harus terhubung ke mata kuliah.

### FR-07 Absensi
Sistem harus mendukung pencatatan absensi per pertemuan.

Field minimal:
- Pertemuan.
- Mahasiswa.
- Status absensi.
- Catatan.
- Pencatat.
- Validator.
- Waktu validasi.

Status absensi:
- hadir
- izin
- sakit
- alpha

Aturan:
- Sekretaris dapat mengisi absensi.
- Sekretaris dapat mengajukan absensi.
- Wakil komting dapat memvalidasi absensi.
- Setelah divalidasi, absensi terkunci.
- Mahasiswa dapat melihat riwayat absensi sendiri.
- Satu mahasiswa hanya memiliki satu record absensi per pertemuan.

### FR-08 Materi Mata Kuliah
Sistem harus dapat mengelola materi.

Field minimal:
- Judul.
- Deskripsi.
- Mata kuliah.
- Semester opsional.
- Status arsip.
- Pembuat.

Fitur:
- Upload file.
- Download file.
- Arsip materi.
- Filter per mata kuliah.
- Akses file private.

### FR-09 Pembayaran Uang Kas
Sistem harus mendukung dua metode pembayaran.

#### Metode Manual
Aturan:
- Bendahara mencatat pembayaran.
- Pembayaran langsung berstatus approved.
- Sistem membuat invoice.
- Invoice dikirim ke email mahasiswa.

#### Metode QRIS Manual
Aturan:
- Mahasiswa melihat QRIS.
- Mahasiswa upload bukti pembayaran.
- Pembayaran berstatus pending.
- Bendahara memeriksa bukti dan mutasi.
- Bendahara approve atau reject.
- Invoice dikirim setelah approve.

### FR-10 Tagihan Kas
Sistem harus dapat menyimpan tagihan kas mahasiswa.

Field minimal:
- Mahasiswa.
- Semester.
- Bulan periode.
- Tahun periode.
- Nominal tagihan.
- Nominal terbayar.
- Status.
- Jatuh tempo.
- Catatan.

Status tagihan:
- unpaid
- partial
- paid
- exempted

### FR-11 Invoice
Invoice harus dibuat setelah pembayaran disetujui.

Field invoice:
- Kode struk pembayaran.
- Nama mahasiswa.
- NPM.
- Hari, tanggal, bulan, dan tahun validasi.
- Nominal pembayaran.
- Periode pembayaran.
- Sisa tunggakan.
- Nama bendahara.
- Jabatan bendahara.
- Pernyataan validasi.

### FR-12 Manajemen Keuangan
Bendahara harus dapat:
- Melihat total kas per semester.
- Melihat total kas keseluruhan.
- Melihat daftar tunggakan.
- Mencatat pemasukan.
- Mencatat pengeluaran.
- Melihat laporan bulanan.
- Melihat riwayat pembayaran.

### FR-13 Dashboard
Sistem harus menampilkan dashboard berbeda per role.

Dashboard komting:
- Ringkasan pengguna.
- Ringkasan pertemuan.
- Ringkasan absensi.
- Ringkasan kas.
- Manajemen role.

Dashboard wakil:
- Pertemuan yang perlu diperiksa.
- Absensi menunggu validasi.

Dashboard sekretaris:
- Pertemuan mendatang.
- Absensi yang perlu diisi.
- Absensi yang perlu diajukan.

Dashboard bendahara:
- Pembayaran pending.
- Total kas bulan ini.
- Total kas semester.
- Total kas keseluruhan.
- Daftar tunggakan.

Dashboard mahasiswa:
- Jadwal hari ini.
- Status absensi.
- Tagihan kas aktif.
- Riwayat pembayaran.
- Materi terbaru.

### FR-14 Audit Log
Sistem harus mencatat aksi penting:
- Perubahan role.
- Approve payment.
- Reject payment.
- Validasi absensi.
- Perubahan data mahasiswa.
- Perubahan transaksi keuangan.
- Perubahan pengaturan kas.

## Non-Functional Requirements

### NFR-01 UUID
Semua tabel domain harus menggunakan UUID sebagai primary key.

Tabel domain yang wajib UUID:
- users
- student_profiles
- semesters
- courses
- meetings
- attendances
- materials
- material_files
- cash_settings
- cash_obligations
- payments
- payment_allocations
- finance_transactions

Tabel infrastruktur Laravel seperti session, cache, queue jobs, dan password reset token dapat mengikuti kebutuhan framework, namun jika ingin seragam dapat diubah menjadi UUID.

### NFR-02 Security
- Authorization wajib di backend.
- File upload divalidasi.
- File private tidak boleh diakses publik.
- Bukti pembayaran hanya dapat diakses pemilik, bendahara, dan komting.
- Invoice hanya dapat diakses pemilik dan role berwenang.
- Rate limiting untuk login dan upload.
- CSRF protection.
- XSS protection.
- SQL injection protection melalui query builder/Eloquent.

### NFR-03 Performance
- Gunakan eager loading.
- Hindari N+1 query.
- Gunakan pagination untuk list panjang.
- File disimpan di storage, bukan database.

### NFR-04 Maintainability
- Menggunakan DDD ringan.
- Controller tipis.
- Business logic berada di action/service.
- Model tetap di `app/Models`.

### NFR-05 Reliability
- Approve payment memakai DB transaction.
- Invoice dibuat setelah payment approved.
- Email dikirim melalui queue.
- Data finansial tidak boleh dihapus sembarangan.

### NFR-06 Backup
- Database Supabase harus memiliki backup.
- File penting sebaiknya memiliki strategi backup/lifecycle.

### NFR-07 Usability
- UI menggunakan shadcn/ui.
- Navigasi berbasis role.
- Form menggunakan validasi yang jelas.
- Status proses pembayaran dan absensi harus mudah dipahami.