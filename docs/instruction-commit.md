# User Instruction — Commit & Push Protocol

## Source
Recorded from user command session (Plan mode exit, Fase 2 finalization + Fase 3 start).

## Requirement
- Setiap perubahan kode (fitur baru, perbaikan bug, penambahan file, edit file) WAJIB:
  1. Di-commit dengan pesan dalam bahasa Inggris.
  2. Menggunakan format standar (clear, deskriptif).
  3. Di-push ke repo remote: `https://github.com/alixyan-dev/afterlight-c-of-kaputama.git`

## Standard Commit Message Format
```
<type>: <short description in English>

<optional longer description>
```

Allowed `<type>` values (konvensional):
- `feat`: fitur baru
- `fix`: perbaikan bug
- `docs`: dokumentasi
- `test`: test baru/perbaikan
- `refactor`: refaktor kode (tanpa perubahan perilaku)
- `chore`: konfigurasi, dependency, build
- `style`: format (Pint)
- `perf`: peningkatan kinerja

Contoh:
```
feat: add UUID-compatible role management controller and Inertia page
fix: correct InitialKomtingUserSeederTest environment override
chore: configure Supabase PostgreSQL pgsql driver
```

## Before Every Change (mandatory check per .opencode/instructions.md)
Sebelum menulis/mengubah kode:
1. Baca `docs/tasks.md` untuk memastikan fase yang sedang dikerjakan.
2. Periksa `docs/design.md` (UUID, DDD, authorization, security).
3. Gunakan MCP `laravel-boost` untuk memeriksa struktur DB/model/route yang sudah ada.
4. Pastikan semua tabel domain menggunakan UUID (`HasUuids`, `foreignUuid`).
5. Pastikan authorization menggunakan `spatie/laravel-permission` + Policy.
6. Semua transaksi keuangan menggunakan `DB::transaction`.
7. Semua aksi sensitif dicatat dengan `activity()` (audit log).
8. Gunakan Pest untuk test; jalankan `php artisan test` sebelum push.
9. Gunakan `vendor/bin/pint --format agent` untuk format.
10. Jalankan `vendor/bin/phpstan analyse --no-interaction` (level 7, 0 error).
11. Tidak ada secret yang disimpan dalam kode (`.env` saja).
12. Tidak ada file private yang dapat diakses publik.

## Remote Repository
```
https://github.com/alixyan-dev/afterlight-c-of-kaputama.git
```

## Fase Tracking (berdasarkan docs/tasks.md)
- Fase 0: Setup Proyek → ✅
- Fase 1: Konvensi UUID → ✅
- Fase 2: Authentication & Role → ✅ (core: auth, permission UUID, role seeder, dummy user, role controller/page, audit log)
- Fase 3: Data Mahasiswa → ⬜ (belum)
- Fase 4–15: Belum
