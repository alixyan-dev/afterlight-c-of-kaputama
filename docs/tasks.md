# Tasks

## Fase 0: Setup Proyek dan Dokumentasi

Tasks:
- [ ] Setup koneksi Supabase PostgreSQL.
- [ ] Setup `.env` dan `.env.example`.

Acceptance:
- Laravel dapat berjalan.
- Frontend React dapat tampil.
- Database Supabase terhubung.
- Dokumen proyek lengkap.

## Fase 1: Konvensi UUID

Tasks:
- [ ] Tentukan semua tabel domain memakai UUID.
- [ ] Buat BaseModel dengan `HasUuids` jika diperlukan.
- [ ] Buat contoh migration UUID.
- [ ] Pastikan foreign key menggunakan `foreignUuid`.
- [ ] Siapkan strategi UUID untuk package permission.
- [ ] Siapkan strategi UUID untuk activity log.
- [ ] Uji insert dan relasi UUID.

Acceptance:
- Semua tabel domain menggunakan UUID.
- Relasi foreign key UUID berfungsi.
- Model Laravel dapat menyimpan UUID dengan benar.

## Fase 2: Authentication & Role

Tasks:
- [ ] Setup authentication Laravel.
- [ ] Setup login.
- [ ] Setup logout.
- [ ] Setup password hashing.
- [ ] Setup session secure.
- [ ] Install spatie/laravel-permission.
- [ ] Publish migration permission.
- [ ] Sesuaikan migration permission untuk UUID.
- [ ] Buat role: komting, wakil_komting, sekretaris, bendahara, mahasiswa.
- [ ] Buat permission sesuai design.
- [ ] Mapping permission ke role.
- [ ] Buat seeder user awal.
- [ ] Buat halaman manajemen role untuk komting.
- [ ] Buat activity log untuk perubahan role.

Acceptance:
- User dapat login.
- Role dan permission berfungsi.
- Komting dapat mengubah role user.
- Perubahan role tercatat di activity log.

## Fase 3: Data Mahasiswa

Tasks:
- [ ] Buat model User.
- [ ] Buat model StudentProfile.
- [ ] Buat migration UUID untuk users dan student_profiles.
- [ ] Buat relasi user-profile.
- [ ] Buat CRUD mahasiswa.
- [ ] Buat Form Request untuk validasi.
- [ ] Buat Policy Student.
- [ ] Validasi NPM unik.
- [ ] Tambahkan status aktif/nonaktif.
- [ ] Tambahkan pagination dan search.

Acceptance:
- Komting dapat mengelola mahasiswa.
- NPM unik.
- Data mahasiswa terhubung ke user.

## Fase 4: Semester & Mata Kuliah

Tasks:
- [ ] Buat model Semester.
- [ ] Buat model Course.
- [ ] Buat migration UUID.
- [ ] Buat CRUD semester.
- [ ] Buat CRUD mata kuliah.
- [ ] Field mata kuliah: kode, nama, dosen, hari, jam mulai, jam selesai.
- [ ] Buat halaman jadwal perkuliahan.
- [ ] Buat policy untuk course.
- [ ] Tambahkan filter per semester dan hari.

Acceptance:
- Semester aktif dapat dipilih.
- Jadwal mata kuliah tampil.
- Role berwenang dapat manage mata kuliah.

## Fase 5: Pertemuan

Tasks:
- [ ] Buat model Meeting.
- [ ] Buat migration UUID.
- [ ] Buat form create meeting.
- [ ] Hubungkan meeting dengan course.
- [ ] Hubungkan meeting dengan semester.
- [ ] Buat status meeting.
- [ ] Buat list pertemuan.
- [ ] Buat detail pertemuan.
- [ ] Buat policy meeting.
- [ ] Izinkan sekretaris dan wakil membuat pertemuan.

Acceptance:
- Pertemuan dapat dibuat.
- Status pertemuan tersimpan.
- Hanya role berwenang yang dapat mengakses fitur pertemuan.

## Fase 6: Absensi

Tasks:
- [ ] Buat model Attendance.
- [ ] Buat migration UUID.
- [ ] Buat unique constraint meeting_id + user_id.
- [ ] Buat halaman absensi per pertemuan.
- [ ] Sekretaris dapat mengisi status absensi.
- [ ] Sekretaris dapat submit absensi.
- [ ] Wakil dapat validasi absensi.
- [ ] Wakil dapat reject absensi.
- [ ] Kunci absensi setelah validated.
- [ ] Mahasiswa dapat melihat absensi sendiri.
- [ ] Buat activity log validasi absensi.

Acceptance:
- Absensi dapat dicatat.
- Absensi dapat divalidasi.
- Setelah validasi, data terkunci.

## Fase 7: Materi

Tasks:
- [ ] Buat model Material.
- [ ] Buat model MaterialFile.
- [ ] Buat migration UUID.
- [ ] Buat CRUD materi.
- [ ] Upload file materi.
- [ ] Simpan file ke storage private.
- [ ] Buat endpoint download.
- [ ] Buat policy material file.
- [ ] Buat fitur arsip materi.
- [ ] Filter materi per mata kuliah.

Acceptance:
- Materi dapat diupload.
- Materi dapat diarsipkan.
- File hanya bisa diakses user berwenang.

## Fase 8: Struktur Keuangan

Tasks:
- [ ] Buat model CashSetting.
- [ ] Buat model CashObligation.
- [ ] Buat model Payment.
- [ ] Buat model PaymentAllocation.
- [ ] Buat model FinanceTransaction.
- [ ] Buat migration UUID.
- [ ] Buat pengaturan nominal kas per semester.
- [ ] Buat generator tagihan per bulan atau per periode.
- [ ] Buat logic hitung tunggakan.
- [ ] Buat service allocation payment.

Acceptance:
- Sistem memiliki tagihan kas.
- Tunggakan dapat dihitung.
- Struktur keuangan siap untuk payment.

## Fase 9: Pembayaran Manual

Tasks:
- [ ] Buat halaman bendahara untuk mencatat pembayaran manual.
- [ ] Pilih mahasiswa.
- [ ] Pilih periode tagihan.
- [ ] Input nominal.
- [ ] Simpan payment method manual.
- [ ] Payment langsung approved.
- [ ] Generate receipt number.
- [ ] Generate invoice PDF.
- [ ] Kirim email invoice.
- [ ] Catat activity log.

Acceptance:
- Pembayaran manual tercatat.
- Invoice dibuat.
- Email terkirim.

## Fase 10: Pembayaran QRIS

Tasks:
- [ ] Buat pengaturan upload gambar QRIS.
- [ ] Mahasiswa melihat QRIS.
- [ ] Mahasiswa memilih tagihan.
- [ ] Mahasiswa upload bukti pembayaran.
- [ ] Payment berstatus pending.
- [ ] Bendahara melihat daftar pembayaran pending.
- [ ] Bendahara melihat bukti.
- [ ] Bendahara approve atau reject.
- [ ] Gunakan DB transaction saat approve.
- [ ] Generate invoice setelah approve.
- [ ] Kirim email setelah approve.
- [ ] Mahasiswa dapat melihat riwayat pembayaran.

Acceptance:
- Mahasiswa dapat upload bukti.
- Bendahara dapat approve/reject.
- Invoice terkirim setelah approve.

## Fase 11: Manajemen Keuangan

Tasks:
- [ ] Buat dashboard bendahara.
- [ ] Tampilkan pembayaran pending.
- [ ] Tampilkan total kas bulan ini.
- [ ] Tampilkan total kas per semester.
- [ ] Tampilkan total kas keseluruhan.
- [ ] Tampilkan daftar tunggakan.
- [ ] Buat CRUD pemasukan.
- [ ] Buat CRUD pengeluaran.
- [ ] Buat laporan bulanan.
- [ ] Buat laporan semester.
- [ ] Buat grafik keuangan.

Acceptance:
- Bendahara dapat melihat laporan kas secara lengkap.
- Data total dan tunggakan akurat.

## Fase 12: Dashboard Role

Tasks:
- [ ] Buat dashboard komting.
- [ ] Buat dashboard wakil.
- [ ] Buat dashboard sekretaris.
- [ ] Buat dashboard bendahara.
- [ ] Buat dashboard mahasiswa.
- [ ] Tampilkan widget sesuai role.
- [ ] Pastikan menu navigasi berbasis role.

Acceptance:
- Setiap role melihat dashboard berbeda.
- Menu hanya menampilkan fitur yang diizinkan.

## Fase 13: Security Hardening

Tasks:
- [ ] Pastikan semua route memakai middleware auth.
- [ ] Pastikan semua route sensitif memakai permission.
- [ ] Pastikan semua resource memakai policy.
- [ ] Tambahkan rate limiting login.
- [ ] Tambahkan rate limiting upload bukti.
- [ ] Validasi semua file upload.
- [ ] Pastikan file private tidak public.
- [ ] Gunakan signed URL atau controller stream untuk file.
- [ ] Tambahkan security headers.
- [ ] Pastikan CSRF aktif.
- [ ] Pastikan tidak ada raw query rawan injection.
- [ ] Audit log untuk semua aksi sensitif.
- [ ] Cek dependency vulnerabilities.

Acceptance:
- Tidak ada direct object access tanpa authorization.
- File private aman.
- Login dan upload memiliki rate limit.

## Fase 14: Testing

Tasks:
- [ ] Test login.
- [ ] Test logout.
- [ ] Test akses role.
- [ ] Test komting mengubah role.
- [ ] Test mahasiswa tidak bisa akses halaman bendahara.
- [ ] Test sekretaris submit absensi.
- [ ] Test wakil validasi absensi.
- [ ] Test absensi terkunci setelah validasi.
- [ ] Test pembayaran manual.
- [ ] Test pembayaran QRIS.
- [ ] Test approve payment mengubah tunggakan.
- [ ] Test invoice dibuat setelah approve.
- [ ] Test invoice tidak bisa diakses mahasiswa lain.
- [ ] Test download materi.
- [ ] Test bukti bayar tidak bisa diakses user lain.

Acceptance:
- Flow kritis memiliki test hijau.
- RBAC terbukti melalui test.

## Fase 15: Production Preparation

Tasks:
- [ ] Set APP_ENV=production.
- [ ] Set APP_DEBUG=false.
- [ ] Gunakan HTTPS.
- [ ] Setup queue worker.
- [ ] Setup scheduler.
- [ ] Setup mail production.
- [ ] Setup Supabase backup.
- [ ] Setup error monitoring.
- [ ] Cek log.
- [ ] Cek permission default.
- [ ] Buat akun admin awal dengan aman.

Acceptance:
- Aplikasi siap production.
- Email invoice terkirim.
- Queue berjalan.
- Backup database tersedia.