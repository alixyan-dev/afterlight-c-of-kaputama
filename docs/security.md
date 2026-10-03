# Security

## Prinsip Keamanan Utama

1. Semua akses harus melalui authentication.
2. Semua aksi sensitif harus melalui authorization.
3. Validasi semua input dari user.
4. Jangan percaya frontend sebagai sumber keamanan.
5. File private tidak boleh diakses publik.
6. Transaksi finansial harus konsisten.
7. Semua aksi penting harus dapat diaudit.
8. UUID tidak boleh menjadi satu-satunya mekanisme keamanan.

## Authentication

### Password
Gunakan hashing bawaan Laravel:

```text
bcrypt / argon2id
```

### Session
Konfigurasi session harus aman:

```env
SESSION_SECURE_COOKIE=true
```

Cookie session harus:
- HttpOnly
- Secure di production
- SameSite lax atau strict sesuai kebutuhan

### Login
- Rate limiting login.
- Hindari user enumeration jika memungkinkan.
- Logout harus menghapus session.
- Remember me opsional dan harus aman.

### Rekomendasi Tambahan
- Email verification.
- Reset password.
- Two-factor authentication untuk role officer jika memungkinkan.

## Authorization

Gunakan tiga lapis:

```text
Middleware auth
+
Permission
+
Policy
```

### Middleware Auth
Semua route kecuali auth publik harus memakai:

```php
middleware('auth')
```

### Permission
Gunakan permission untuk fitur.

Contoh:

```text
payments.approve
attendance.validate
roles.assign
finance.manage
```

### Policy
Gunakan policy untuk akses resource spesifik.

Contoh:
- Mahasiswa hanya bisa melihat invoice miliknya.
- Bendahara bisa melihat bukti pembayaran semua mahasiswa.
- Mahasiswa tidak bisa melihat bukti pembayaran mahasiswa lain.
- Komting bisa mengakses hampir semua resource.

## UUID Security

Keuntungan UUID:
- ID tidak berurutan.
- ID lebih sulit ditebak.
- Cocok untuk resource URL.

Namun:
- UUID bukan pengganti authorization.
- Tetap gunakan policy.
- Jangan menganggap resource aman hanya karena ID UUID.

Contoh buruk:

```text
/payments/{uuid}
```

tanpa policy.

Contoh benar:

```text
/payments/{payment}/invoice
```

dengan policy:

```php
$this->authorize('viewInvoice', $payment);
```

## Input Validation

Semua input wajib menggunakan Form Request.

Validasi minimal:
- required
- string
- email
- unique
- exists
- date
- integer
- max
- mimes
- file
- in untuk enum/status

Contoh validasi file bukti:

```php
'proof' => [
    'required',
    'file',
    'max:5120',
    'mimes:jpg,jpeg,png,webp,pdf',
],
```

Contoh validasi materi:

```php
'file' => [
    'required',
    'file',
    'max:20480',
    'mimes:pdf,doc,docx,ppt,pptx,xls,xlsx,zip,txt,png,jpg,jpeg',
],
```

## File Upload Security

Aturan:
- Nama file harus di-random.
- File tidak boleh disimpan di folder public.
- Simpan ke disk private.
- Validasi mime type dan ukuran.
- Akses file melalui controller atau signed URL.
- Bukti pembayaran hanya dapat dilihat pemilik, bendahara, dan komting.
- Invoice hanya dapat dilihat pemilik dan role berwenang.
- Materi hanya dapat diakses oleh user yang memiliki hak.

## Storage Access

Gunakan bucket private untuk:
- materials
- payment-proofs
- invoices
- qris

Jika QRIS ingin public, risikonya lebih kecil karena hanya gambar QRIS. Namun lebih aman tetap private dan diberikan melalui signed URL.

## XSS Protection

- React melakukan escaping default.
- Jangan render HTML dari input user tanpa sanitization.
- Hindari `dangerouslySetInnerHTML` kecuali benar-benar diperlukan.
- Gunakan CSP jika memungkinkan.

## CSRF Protection

- Semua POST, PUT, PATCH, DELETE harus memakai CSRF token.
- Gunakan Inertia form helper agar token otomatis.

## SQL Injection Protection

- Gunakan Eloquent.
- Gunakan query builder dengan binding.
- Hindari raw query dengan input user.
- Jangan menyusun raw SQL dari request.

## Rate Limiting

Rate limit yang disarankan:

### Login

```text
5 percobaan per menit per IP
```

### Upload Bukti Pembayaran

```text
10 request per menit per user
```

### Submit Payment

```text
10 request per menit per user
```

### Reset Password

```text
3 request per menit per email/IP
```

## Financial Integrity

Aturan keuangan:
- Payment approved tidak boleh dihapus.
- Jika salah, gunakan status cancelled atau transaksi koreksi.
- Approve payment wajib DB transaction.
- Simpan `approved_by` dan `approved_at`.
- Simpan `rejected_by`, `rejected_at`, dan `rejection_reason`.
- Simpan receipt_number setelah approve.
- Jangan ubah nominal payment approved tanpa audit dan mekanisme koreksi.
- Gunakan integer untuk nominal rupiah.

## Audit Log

Aksi yang wajib dicatat:

```text
role.changed
student.created
student.updated
student.deleted
meeting.submitted
attendance.validated
attendance.rejected
payment.approved
payment.rejected
payment.cancelled
finance-transaction.created
finance-transaction.updated
cash-setting.updated
qris-setting.updated
```

Data audit minimal:
- siapa actor
- aksi apa
- resource apa
- kapan
- data lama/baru jika penting

## Security Headers

Tambahkan middleware security headers.

Header minimal:

```text
X-Content-Type-Options: nosniff
X-Frame-Options: DENY
Referrer-Policy: strict-origin-when-cross-origin
```

Production:

```text
Strict-Transport-Security: max-age=31536000; includeSubDomains
```

Opsional:

```text
Content-Security-Policy
Permissions-Policy
```

## Production Checklist

```text
APP_ENV=production
APP_DEBUG=false
APP_URL menggunakan HTTPS
SESSION_SECURE_COOKIE=true
Mail production aktif
Queue worker aktif
Scheduler aktif
Backup database aktif
Error monitoring aktif
Dependency audit dilakukan
Secret tidak ada di repository
File storage private
Rate limiting aktif
Audit log aktif
```

## Threat Model Singkat

### Ancaman
1. Mahasiswa mengakses invoice mahasiswa lain.
2. Mahasiswa mengakses bukti bayar mahasiswa lain.
3. Sekretaris mengubah role.
4. Bendahara palsu approve payment.
5. File upload berbahaya.
6. SQL injection melalui filter/search.
7. XSS melalui input teks.
8. Brute force login.
9. ID enumeration.
10. Payment diubah setelah approved.

### Mitigasi
1. Policy payment.
2. Policy proof.
3. Permission roles.assign hanya komting.
4. Permission payments.approve hanya bendahara/komting.
5. Validasi file dan private storage.
6. Eloquent/query binding.
7. Escaping React dan CSP.
8. Rate limiting.
9. UUID + policy.
10. DB transaction + status lock + audit log.