# AI Agent Guidelines

## Tujuan
Dokumen ini menjadi panduan untuk AI agent OpenCode / Laravel Boost agar menghasilkan code yang sesuai dengan arsitektur, kebutuhan produk, dan standar keamanan proyek.

## Dokumen Utama yang Harus Dibaca AI

Sebelum menulis code, AI wajib membaca:

```text
docs/product.md
docs/requirements.md
docs/design.md
docs/tasks.md
docs/structure.md
docs/security.md
AGENTS.md
```

## Aturan Utama AI

1. Jangan mengubah dokumen di folder `docs/` kecuali diminta.
2. Ikuti struktur folder yang sudah ditetapkan.
3. Model Eloquent tetap berada di `app/Models`.
4. Business logic berada di `app/Domain`.
5. Controller harus tipis.
6. Validasi input menggunakan Form Request.
7. Authorization menggunakan permission dan policy.
8. Semua tabel domain menggunakan UUID.
9. Foreign key menggunakan `foreignUuid`.
10. Gunakan `HasUuids` pada model domain.
11. Jangan membuat ID auto increment untuk tabel domain.
12. Semua transaksi finansial menggunakan DB transaction.
13. Semua aksi sensitif menggunakan activity log.
14. Jangan menyimpan secret di code.
15. Jangan membuat file private menjadi public.
16. Jangan mengandalkan frontend untuk authorization.
17. Gunakan Pest untuk test.
18. Gunakan Laravel Pint untuk formatting.
19. Gunakan PHPStan/Larastan untuk static analysis.
20. Frontend menggunakan React + TypeScript + shadcn/ui + Inertia.

## Teknologi yang Digunakan

```text
Laravel 13
React
TypeScript
Inertia.js
shadcn/ui
Tailwind CSS
Supabase PostgreSQL
Supabase Storage
spatie/laravel-permission
spatie/laravel-activitylog
bensampo/laravel-enum
barryvdh/laravel-dompdf
Pest
Laravel Pint
PHPStan/Larastan
```

## Konvensi UUID

AI harus memastikan:

```php
$table->uuid('id')->primary();
```

untuk primary key tabel domain.

AI harus menggunakan:

```php
$table->foreignUuid('user_id')
    ->constrained('users')
    ->cascadeOnDelete();
```

untuk foreign key.

AI harus memastikan model memakai:

```php
use HasUuids;
```

## Konvensi Domain Action

AI lebih dulu membuat action ketika ada business logic kompleks.

Contoh action:

```text
AssignRoleToUserAction
ApprovePaymentAction
RejectPaymentAction
ValidateAttendanceAction
GenerateInvoiceAction
CalculateRemainingArrearsAction
```

Controller seharusnya memanggil action, bukan menumpuk logic.

## Konvensi Frontend

AI harus:
- Menggunakan TypeScript strict.
- Menggunakan komponen shadcn/ui.
- Menggunakan Inertia form.
- Tidak membuat fetch manual jika Inertia router cukup.
- Menggunakan zod jika membutuhkan validasi frontend tambahan.
- Tidak menyembunyikan fitur sensitif hanya dengan UI.

## Konvensi Testing

AI harus membuat test untuk flow kritis:

```text
authentication
role access
permission access
attendance validation
payment approval
invoice access
file access
```

## Model AI OpenRouter

Gunakan model gratis OpenRouter dengan suffix `:free`.

Daftar model gratis dapat berubah. Cek model tersedia:

```bash
curl -H "Authorization: Bearer $OPENROUTER_API_KEY" \
  https://openrouter.ai/api/v1/models \
  | jq '.data[] | select(.id | endswith(":free")) | .id'
```

Kandidat model gratis untuk coding:

```text
qwen/qwen3-coder:free
deepseek/deepseek-r1:free
meta-llama/llama-3.3-70b-instruct:free
qwen/qwen-2.5-coder-32b-instruct:free
google/gemini-2.0-flash-exp:free
```

Gunakan fallback jika model utama rate limit.

## Contoh Konfigurasi OpenCode

Simpan sebagai file konfigurasi OpenCode jika tool Anda mendukung, misalnya `opencode.json` atau konfigurasi equivalent.

```json
{
  "$schema": "https://opencode.ai/config.json",
  "provider": "openrouter",
  "apiKeyEnv": "OPENROUTER_API_KEY",
  "model": "qwen/qwen3-coder:free",
  "fallbackModels": [
    "deepseek/deepseek-r1:free",
    "meta-llama/llama-3.3-70b-instruct:free",
    "qwen/qwen-2.5-coder-32b-instruct:free"
  ],
  "temperature": 0.2,
  "maxTokens": 8192,
  "contextFiles": [
    "docs/product.md",
    "docs/requirements.md",
    "docs/design.md",
    "docs/tasks.md",
    "docs/structure.md",
    "docs/security.md",
    "AGENTS.md"
  ]
}
```

Jika OpenCode menggunakan skema berbeda, pastikan prinsip berikut:

```text
provider = openrouter
model = model gratis dengan suffix :free
temperature = rendah
context = dokumen docs dan AGENTS.md
```

## Workflow AI yang Disarankan

### 1. Analisis
AI membaca dokumen dan membuat rencana.

Prompt contoh:

```text
Baca docs/product.md, docs/requirements.md, docs/design.md, docs/tasks.md, docs/structure.md, dan docs/security.md.

Jangan menulis code dulu.
Buat rencana implementasi untuk Fase 1: Authentication & Role.

Tampilkan:
1. file yang akan dibuat
2. migration UUID yang dibutuhkan
3. permission yang dibutuhkan
4. controller/request/policy yang dibutuhkan
5. test yang dibutuhkan
6. risiko security
```

### 2. Implementasi Bertahap
Prompt contoh:

```text
Implementasikan Fase 1: Authentication & Role berdasarkan docs/tasks.md.

Gunakan UUID untuk tabel domain.
Gunakan struktur dari docs/structure.md.
Jangan ubah docs.
Buat code Laravel 13 yang production-ready.
```

### 3. Review Security
Prompt contoh:

```text
Review code yang baru dibuat berdasarkan docs/security.md.

Cari masalah:
- authorization
- validasi input
- file upload
- rate limiting
- SQL injection
- UUID exposure
- policy missing

Jangan tambah fitur baru.
Hanya perbaiki masalah security dan bug.
```

### 4. Testing
Prompt contoh:

```text
Buat Pest test untuk:
1. login
2. komting mengubah role
3. mahasiswa tidak bisa akses halaman bendahara
4. wakil validasi absensi
5. bendahara approve payment
6. invoice tidak bisa diakses mahasiswa lain
```

## Definition of Done

Fitur dianggap selesai jika:
- Migration UUID dibuat.
- Model memakai HasUuids.
- Form request dibuat.
- Policy dibuat.
- Route memakai middleware yang benar.
- UI React menggunakan shadcn/ui.
- Activity log ditambahkan untuk aksi sensitif.
- Test penting dibuat.
- Tidak ada secret bocor.
- Tidak ada file private public.
- Tidak ada direct object access tanpa policy.