# Design

## Arsitektur Umum

Sistem menggunakan Laravel sebagai backend, React sebagai frontend, dan Inertia.js sebagai penghubung antara backend dan frontend.

Flow request:

```text
Browser
  ↓
Laravel Route
  ↓
Middleware Auth + Role/Permission
  ↓
Controller
  ↓
FormRequest Validation
  ↓
Policy/Gate
  ↓
Domain Action / Service
  ↓
Eloquent Model / Supabase PostgreSQL
  ↓
Event / Job / Mail / Invoice
```

## Prinsip Desain

1. Controller tipis.
2. Validasi input menggunakan Form Request.
3. Authorization menggunakan permission dan policy.
4. Business logic berada di `app/Domain`.
5. Eloquent model tetap berada di `app/Models`.
6. Semua tabel domain menggunakan UUID.
7. Transaksi finansial menggunakan DB transaction.
8. File private disimpan di storage yang aman.
9. Aksi sensitif dicatat dalam activity log.
10. Email invoice dikirim melalui queue.

## Konvensi UUID

### Primary Key
Semua tabel domain menggunakan UUID sebagai primary key.

Contoh migration:

```php
Schema::create('users', function (Blueprint $table) {
    $table->uuid('id')->primary();
    $table->string('name');
    $table->string('email')->unique();
    $table->timestamp('email_verified_at')->nullable();
    $table->string('password');
    $table->boolean('is_active')->default(true);
    $table->timestamps();
});
```

### Foreign Key
Gunakan `foreignUuid` untuk relasi.

Contoh:

```php
$table->foreignUuid('user_id')
    ->constrained('users')
    ->cascadeOnDelete();
```

### Model
Semua model domain menggunakan trait `HasUuids`.

Contoh:

```php
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;

abstract class BaseModel extends Model
{
    use HasUuids;
}
```

Atau jika tidak memakai BaseModel:

```php
class User extends Authenticatable
{
    use HasUuids;
}
```

### Catatan UUID
- UUID membuat ID tidak mudah ditebak.
- UUID bukan pengganti authorization.
- Resource tetap harus dicek melalui policy.
- Gunakan index pada foreign key dan kolom pencarian.
- Jika memakai package yang membuat tabel sendiri, sesuaikan migration package agar kompatibel dengan UUID.

## Penyesuaian Package untuk UUID

### spatie/laravel-permission
Setelah publish migration permission, ubah kolom morph model menjadi UUID.

Contoh:

```php
$table->uuidMorphs('model');
```

Pastikan tabel `model_has_roles` dan `model_has_permissions` menggunakan kolom:

```text
model_type
model_id (uuid)
```

### spatie/laravel-activitylog
Setelah publish migration activity log, sesuaikan kolom causer dan subject agar mendukung UUID.

Contoh:

```php
$table->nullableUuidMorphs('causer');
$table->nullableUuidMorphs('subject');
```

## Struktur Domain

Bounded context:

1. Auth & Role
2. Student Profile
3. Academic / Mata Kuliah
4. Meeting / Pertemuan
5. Attendance / Absensi
6. Material / Materi
7. Finance / Keuangan
8. Payment / Pembayaran
9. Notification & Invoice

## Entity Relationship Design

### users
Menyimpan akun login.

Field:
- `id` uuid primary key
- `name` string
- `email` string unique
- `password` string
- `email_verified_at` timestamp nullable
- `is_active` boolean default true
- `timestamps`

Relasi:
- Memiliki satu `student_profile`.
- Memiliki banyak `attendances`.
- Memiliki banyak `payments`.
- Memiliki banyak `cash_obligations`.

### student_profiles
Menyimpan profil mahasiswa.

Field:
- `id` uuid primary key
- `user_id` uuid foreign key to users
- `npm` string unique
- `class_name` string nullable
- `phone` string nullable
- `status` string default active
- `timestamps`

Relasi:
- Milik `users`.

### semesters
Menyimpan periode semester.

Field:
- `id` uuid primary key
- `name` string
- `academic_year` string
- `start_date` date
- `end_date` date
- `is_active` boolean default false
- `timestamps`

Relasi:
- Memiliki banyak `courses`.
- Memiliki banyak `meetings`.
- Memiliki banyak `cash_settings`.
- Memiliki banyak `cash_obligations`.
- Memiliki banyak `finance_transactions`.

### courses
Menyimpan mata kuliah.

Field:
- `id` uuid primary key
- `semester_id` uuid nullable foreign key to semesters
- `code` string unique
- `name` string
- `lecturer_name` string
- `day_of_week` string
- `start_time` time
- `end_time` time
- `room` string nullable
- `description` text nullable
- `is_active` boolean default true
- `timestamps`

Relasi:
- Milik `semesters`.
- Memiliki banyak `meetings`.
- Memiliki banyak `materials`.

### meetings
Menyimpan pertemuan perkuliahan.

Field:
- `id` uuid primary key
- `course_id` uuid foreign key to courses
- `semester_id` uuid nullable foreign key to semesters
- `session_number` integer nullable
- `title` string
- `agenda` text nullable
- `location` string nullable
- `meeting_date` date
- `start_time` time
- `end_time` time
- `status` string default draft
- `created_by` uuid nullable foreign key to users
- `submitted_by` uuid nullable foreign key to users
- `submitted_at` timestamp nullable
- `validated_by` uuid nullable foreign key to users
- `validated_at` timestamp nullable
- `notes` text nullable
- `timestamps`

Status:
- draft
- submitted
- validated
- rejected
- cancelled

Relasi:
- Milik `courses`.
- Milik `semesters`.
- Memiliki banyak `attendances`.

### attendances
Menyimpan absensi mahasiswa per pertemuan.

Field:
- `id` uuid primary key
- `meeting_id` uuid foreign key to meetings
- `user_id` uuid foreign key to users
- `status` string
- `note` text nullable
- `recorded_by` uuid nullable foreign key to users
- `validated_by` uuid nullable foreign key to users
- `validated_at` timestamp nullable
- `timestamps`

Status:
- present
- excused
- sick
- absent

Constraint:
- unique `meeting_id` dan `user_id`

Relasi:
- Milik `meetings`.
- Milik `users`.

### materials
Menyimpan materi kuliah.

Field:
- `id` uuid primary key
- `course_id` uuid foreign key to courses
- `semester_id` uuid nullable foreign key to semesters
- `title` string
- `description` text nullable
- `is_archived` boolean default false
- `archived_at` timestamp nullable
- `created_by` uuid nullable foreign key to users
- `timestamps`

Relasi:
- Milik `courses`.
- Milik `semesters`.
- Memiliki banyak `material_files`.

### material_files
Menyimpan file materi.

Field:
- `id` uuid primary key
- `material_id` uuid foreign key to materials
- `original_name` string
- `storage_path` string
- `mime_type` string
- `size_bytes` bigInteger
- `uploaded_by` uuid nullable foreign key to users
- `timestamps`

Relasi:
- Milik `materials`.

### cash_settings
Menyimpan pengaturan kas per semester.

Field:
- `id` uuid primary key
- `semester_id` uuid foreign key to semesters
- `monthly_amount` bigInteger
- `due_day` integer default 10
- `qris_image_path` string nullable
- `qris_note` text nullable
- `is_active` boolean default true
- `timestamps`

Relasi:
- Milik `semesters`.

### cash_obligations
Menyimpan tagihan kas per mahasiswa per periode.

Field:
- `id` uuid primary key
- `user_id` uuid foreign key to users
- `semester_id` uuid foreign key to semesters
- `period_month` integer
- `period_year` integer
- `amount` bigInteger
- `paid_amount` bigInteger default 0
- `status` string default unpaid
- `due_date` date nullable
- `note` text nullable
- `timestamps`

Status:
- unpaid
- partial
- paid
- exempted

Constraint:
- unique `user_id`, `semester_id`, `period_month`, `period_year`

Relasi:
- Milik `users`.
- Milik `semesters`.
- Memiliki banyak `payment_allocations`.

### payments
Menyimpan pembayaran kas.

Field:
- `id` uuid primary key
- `user_id` uuid foreign key to users
- `method` string
- `status` string default pending
- `total_amount` bigInteger
- `proof_path` string nullable
- `proof_note` text nullable
- `qris_reference` string nullable
- `receipt_number` string nullable unique
- `invoice_path` string nullable
- `approved_by` uuid nullable foreign key to users
- `approved_at` timestamp nullable
- `rejected_by` uuid nullable foreign key to users
- `rejected_at` timestamp nullable
- `rejection_reason` text nullable
- `timestamps`

Method:
- manual
- qris

Status:
- pending
- approved
- rejected
- cancelled

Relasi:
- Milik `users`.
- Memiliki banyak `payment_allocations`.

### payment_allocations
Menyimpan alokasi pembayaran ke tagihan.

Field:
- `id` uuid primary key
- `payment_id` uuid foreign key to payments
- `obligation_id` uuid foreign key to cash_obligations
- `allocated_amount` bigInteger
- `timestamps`

Relasi:
- Milik `payments`.
- Milik `cash_obligations`.

### finance_transactions
Menyimpan pemasukan dan pengeluaran kas.

Field:
- `id` uuid primary key
- `semester_id` uuid nullable foreign key to semesters
- `type` string
- `category` string
- `description` text nullable
- `amount` bigInteger
- `occurred_on` date
- `reference` string nullable
- `created_by` uuid nullable foreign key to users
- `timestamps`

Type:
- income
- expense

Relasi:
- Milik `semesters`.

## Role & Permission Matrix

| Fitur | Komting | Wakil | Sekretaris | Bendahara | Mahasiswa |
|---|---|---|---|---|---|
| Login | ✅ | ✅ | ✅ | ✅ | ✅ |
| Dashboard role | ✅ | ✅ | ✅ | ✅ | ✅ |
| Manage role user | ✅ | ❌ | ❌ | ❌ | ❌ |
| Manage mahasiswa | ✅ | ❌ | ❌ | ❌ | ❌ |
| Lihat mahasiswa | ✅ | ✅ | ✅ | ✅ | ❌ |
| Manage mata kuliah | ✅ | ❌ | ✅ opsional | ❌ | ❌ |
| Lihat jadwal | ✅ | ✅ | ✅ | ✅ | ✅ |
| Buat pertemuan | ✅ | ✅ | ✅ | ❌ | ❌ |
| Isi absensi | ✅ | ❌ | ✅ | ❌ | ❌ |
| Validasi absensi | ✅ | ✅ | ❌ | ❌ | ❌ |
| Lihat absensi sendiri | ✅ | ✅ | ✅ | ✅ | ✅ |
| Upload materi | ✅ | ❌ | ✅ opsional | ❌ | ❌ |
| Download materi | ✅ | ✅ | ✅ | ✅ | ✅ |
| Catat pembayaran manual | ✅ | ❌ | ❌ | ✅ | ❌ |
| Approve/reject QRIS | ✅ | ❌ | ❌ | ✅ | ❌ |
| Upload bukti QRIS | ❌ | ❌ | ❌ | ❌ | ✅ |
| Lihat riwayat pembayaran sendiri | ✅ | ✅ | ✅ | ✅ | ✅ |
| Manage pemasukan/pengeluaran | ✅ | ❌ | ❌ | ✅ | ❌ |
| Lihat laporan keuangan | ✅ | ❌ | ❌ | ✅ | ❌ |

## Daftar Permission

```text
users.manage
roles.assign

students.view
students.manage

courses.view
courses.manage

meetings.view
meetings.create
meetings.update
meetings.delete
meetings.submit
meetings.validate

attendance.view
attendance.manage
attendance.validate

materials.view
materials.manage
materials.download

payments.view-own
payments.submit-proof
payments.record-manual
payments.review
payments.approve
payments.reject

finance.view
finance.manage
finance.reports.view

settings.manage
```

## Mapping Role ke Permission

```text
komting:
  semua permission

wakil_komting:
  meetings.view
  meetings.create
  meetings.validate
  attendance.view
  attendance.validate
  courses.view
  materials.view

sekretaris:
  meetings.view
  meetings.create
  attendance.view
  attendance.manage
  courses.view
  materials.view

bendahara:
  payments.view-own
  payments.review
  payments.approve
  payments.reject
  payments.record-manual
  finance.view
  finance.manage
  finance.reports.view
  students.view

mahasiswa:
  payments.view-own
  payments.submit-proof
  courses.view
  materials.view
  materials.download
```

## Workflow Pertemuan & Absensi

### Flow Pertemuan
1. Sekretaris atau wakil membuat pertemuan.
2. Pertemuan berstatus draft.
3. Pertemuan dapat dilengkapi.
4. Saat absensi siap diajukan, status menjadi submitted.
5. Wakil komting memeriksa.
6. Wakil komting approve atau reject.
7. Jika approved, status menjadi validated.

### Flow Absensi
1. Sekretaris membuka pertemuan.
2. Sekretaris mengisi status absensi mahasiswa.
3. Sekretaris submit absensi.
4. Wakil komting memvalidasi.
5. Setelah validasi, absensi terkunci.
6. Mahasiswa dapat melihat hasil absensinya.

### Aturan Absensi
- Absensi hanya dapat diubah sebelum submit.
- Setelah validated, absensi tidak boleh diubah.
- Pengecualian hanya untuk komting melalui aksi khusus dengan audit log.

## Workflow Pembayaran Manual

1. Bendahara memilih mahasiswa.
2. Bendahara memilih periode tagihan.
3. Bendahara input nominal.
4. Sistem membuat payment dengan method `manual`.
5. Payment langsung berstatus approved.
6. Sistem generate receipt number.
7. Sistem generate invoice PDF.
8. Sistem mengirim invoice ke email mahasiswa.

## Workflow Pembayaran QRIS

1. Mahasiswa membuka menu pembayaran QRIS.
2. Sistem menampilkan QRIS dan nominal tagihan.
3. Mahasiswa transfer manual.
4. Mahasiswa upload bukti pembayaran.
5. Payment dibuat dengan status pending.
6. Bendahara memeriksa bukti dan mutasi.
7. Bendahara approve atau reject.
8. Jika approve:
   - payment dikunci,
   - alokasi pembayaran dibuat,
   - tagihan diperbarui,
   - receipt number dibuat,
   - invoice dibuat,
   - email dikirim.
9. Jika reject:
   - payment berstatus rejected,
   - alasan penolakan disimpan,
   - mahasiswa dapat melihat status penolakan.

## Aturan Approval Payment

Approval payment harus transactional.

Urutan ideal:

```text
DB::transaction(function () {
    1. Lock payment.
    2. Pastikan status masih pending.
    3. Update status menjadi approved.
    4. Set approved_by.
    5. Set approved_at.
    6. Generate receipt_number.
    7. Buat payment_allocations.
    8. Update paid_amount pada cash_obligations.
    9. Update status cash_obligations.
    10. Generate invoice PDF.
    11. Simpan invoice_path.
    12. Catat activity log.
    13. Dispatch job kirim email invoice.
});
```

## Invoice

### Format Receipt Number
Contoh:

```text
INV/KAS/2026/06/ABC123
```

atau:

```text
KAS-202606-ABC123
```

### Isi Invoice
- Kode struk pembayaran.
- Nama mahasiswa.
- NPM.
- Hari validasi.
- Tanggal validasi.
- Bulan validasi.
- Tahun validasi.
- Nominal pembayaran.
- Periode pembayaran.
- Sisa tunggakan.
- Nama bendahara.
- Jabatan bendahara.
- Pernyataan validasi.

Contoh teks:

```text
Pembayaran ini telah divalidasi oleh Bendahara Kelas.
```

## Dashboard

### Dashboard Komting
Widget:
- Total mahasiswa aktif.
- Total mata kuliah.
- Pertemuan minggu ini.
- Absensi menunggu validasi.
- Total kas bulan ini.
- Total tunggakan.
- Akses manajemen role.

### Dashboard Wakil
Widget:
- Pertemuan yang perlu diperiksa.
- Absensi menunggu validasi.
- Jadwal minggu ini.

### Dashboard Sekretaris
Widget:
- Pertemuan mendatang.
- Absensi yang perlu diisi.
- Absensi yang perlu diajukan.

### Dashboard Bendahara
Widget:
- Pembayaran QRIS pending.
- Total kas bulan ini.
- Total kas per semester.
- Total kas keseluruhan.
- Daftar tunggakan.
- Grafik pemasukan/pengeluaran.

### Dashboard Mahasiswa
Widget:
- Jadwal hari ini.
- Status absensi.
- Tagihan kas aktif.
- Riwayat pembayaran.
- Materi terbaru.

## Storage Design

Gunakan Supabase Storage.

Bucket:

| Bucket | Akses | Isi |
|---|---|---|
| `materials` | private | File materi |
| `payment-proofs` | private | Bukti pembayaran QRIS |
| `invoices` | private | PDF invoice |
| `qris` | private/public | Gambar QRIS |

Rekomendasi aman:
- Semua bucket private.
- QRIS dapat diakses melalui signed URL atau controller stream.
- File hanya diberikan kepada user yang memiliki policy access.

## Route Design

### Auth

```text
GET  /login
POST /login
POST /logout
```

### Dashboard

```text
GET /dashboard
```

### Mahasiswa

```text
GET    /students
POST   /students
GET    /students/{student}
PUT    /students/{student}
DELETE /students/{student}
PUT    /students/{student}/role
```

### Semester

```text
GET    /semesters
POST   /semesters
PUT    /semesters/{semester}
DELETE /semesters/{semester}
```

### Mata Kuliah

```text
GET    /courses
POST   /courses
GET    /courses/{course}
PUT    /courses/{course}
DELETE /courses/{course}
```

### Pertemuan

```text
GET    /meetings
POST   /meetings
GET    /meetings/{meeting}
PUT    /meetings/{meeting}
DELETE /meetings/{meeting}
POST   /meetings/{meeting}/submit
POST   /meetings/{meeting}/validate
POST   /meetings/{meeting}/reject
```

### Absensi

```text
GET  /meetings/{meeting}/attendance
POST /meetings/{meeting}/attendance
```

### Materi

```text
GET    /materials
POST   /materials
GET    /materials/{material}
PUT    /materials/{material}
DELETE /materials/{material}
POST   /materials/{material}/files
GET    /materials/files/{materialFile}/download
```

### Pembayaran Mahasiswa

```text
GET  /payments/my
GET  /payments/qris
POST /payments/qris/upload
GET  /payments/history
GET  /payments/{payment}/invoice
```

### Bendahara

```text
GET  /finance/dashboard
GET  /finance/payments
POST /finance/payments/manual
POST /finance/payments/{payment}/approve
POST /finance/payments/{payment}/reject
GET  /finance/transactions
POST /finance/transactions
PUT  /finance/transactions/{transaction}
GET  /finance/reports/monthly
GET  /finance/reports/semester
GET  /finance/arrears
```

### Pengaturan

```text
GET  /settings/cash
POST /settings/cash
GET  /settings/qris
POST /settings/qris
GET  /settings/semester
POST /settings/semester
```

## Authorization Design

Gunakan tiga lapis:

```text
Middleware auth
+
Middleware permission
+
Policy
```

Contoh:

```php
Route::middleware(['auth', 'permission:payments.approve'])->group(function () {
    Route::post('/finance/payments/{payment}/approve', [FinancePaymentController::class, 'approve']);
});
```

Policy tetap harus mengecek kepemilikan resource.

Contoh:

```php
if ($payment->user_id !== auth()->id() && !auth()->user()->can('payments.review')) {
    abort(403);
}
```

## Email & Queue

Email invoice dikirim melalui queue.

Job:

```text
SendPaymentInvoiceJob
```

Mail:

```text
PaymentApprovedMail
```

Data mail:
- payment
- student profile
- obligation periods
- remaining arrears
- treasurer name
- invoice PDF path

## Database Transaction Rules

Transaksi DB wajib untuk:
- approve payment
- reject payment jika mengubah state penting
- validasi absensi
- perubahan role
- create/update transaksi keuangan jika melibatkan banyak tabel

## Audit Log

Gunakan activity log untuk:

```text
role.changed
payment.approved
payment.rejected
payment.cancelled
attendance.validated
student.created
student.updated
cash-setting.updated
finance-transaction.created
finance-transaction.updated
```