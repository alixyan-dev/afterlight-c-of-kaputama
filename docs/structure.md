# Structure

## Prinsip Struktur

1. Model Eloquent tetap berada di `app/Models`.
2. Logic bisnis dipisahkan ke `app/Domain`.
3. Controller hanya mengatur HTTP flow.
4. Validasi input menggunakan Form Request.
5. Authorization menggunakan Policy dan permission.
6. Aksi kompleks menggunakan Action/Service.
7. Job dan Mail digunakan untuk proses async seperti invoice.
8. Semua tabel domain menggunakan UUID.

## Struktur Dokumen

```text
docs/
├── product.md
├── requirements.md
├── design.md
├── tasks.md
├── structure.md
├── security.md
└── ai-agent.md
```

## Struktur Backend

```text
app/
├── Console/
├── Domain/
│   ├── Auth/
│   │   ├── Actions/
│   │   ├── DTOs/
│   │   └── Enums/
│   ├── Student/
│   │   ├── Actions/
│   │   ├── DTOs/
│   │   └── Enums/
│   ├── Academic/
│   │   ├── Actions/
│   │   ├── DTOs/
│   │   └── Enums/
│   ├── Attendance/
│   │   ├── Actions/
│   │   ├── DTOs/
│   │   ├── Services/
│   │   └── Enums/
│   ├── Material/
│   │   ├── Actions/
│   │   ├── DTOs/
│   │   └── Enums/
│   └── Finance/
│       ├── Actions/
│       ├── DTOs/
│       ├── Services/
│       └── Enums/
├── Events/
├── Exceptions/
├── Http/
│   ├── Controllers/
│   ├── Middleware/
│   ├── Requests/
│   └── Resources/
├── Jobs/
│   └── SendPaymentInvoiceJob.php
├── Listeners/
├── Mail/
│   └── PaymentApprovedMail.php
├── Models/
│   ├── BaseModel.php
│   ├── User.php
│   ├── StudentProfile.php
│   ├── Semester.php
│   ├── Course.php
│   ├── Meeting.php
│   ├── Attendance.php
│   ├── Material.php
│   ├── MaterialFile.php
│   ├── CashSetting.php
│   ├── CashObligation.php
│   ├── Payment.php
│   ├── PaymentAllocation.php
│   └── FinanceTransaction.php
├── Notifications/
├── Policies/
└── Providers/
```

## Struktur Frontend

```text
resources/js/
├── Components/
│   ├── ui/
│   ├── layouts/
│   ├── navigation/
│   ├── tables/
│   ├── forms/
│   ├── cards/
│   └── modals/
├── Pages/
│   ├── Auth/
│   ├── Dashboard/
│   ├── Students/
│   ├── Courses/
│   ├── Semesters/
│   ├── Meetings/
│   ├── Attendance/
│   ├── Materials/
│   ├── Finance/
│   ├── Payments/
│   └── Settings/
├── hooks/
├── lib/
├── types/
└── app.tsx
```

## Struktur Halaman Frontend

```text
resources/js/Pages/
├── Auth/
│   ├── Login.tsx
│   ├── Register.tsx
│   └── ForgotPassword.tsx
├── Dashboard/
│   ├── KomtingDashboard.tsx
│   ├── WakilDashboard.tsx
│   ├── SekretarisDashboard.tsx
│   ├── BendaharaDashboard.tsx
│   └── MahasiswaDashboard.tsx
├── Students/
│   ├── Index.tsx
│   ├── Create.tsx
│   ├── Edit.tsx
│   └── Show.tsx
├── Courses/
│   ├── Index.tsx
│   ├── Create.tsx
│   ├── Edit.tsx
│   └── Show.tsx
├── Semesters/
│   ├── Index.tsx
│   ├── Create.tsx
│   └── Edit.tsx
├── Meetings/
│   ├── Index.tsx
│   ├── Create.tsx
│   ├── Edit.tsx
│   ├── Show.tsx
│   ├── AttendanceSheet.tsx
│   └── Validation.tsx
├── Materials/
│   ├── Index.tsx
│   ├── Show.tsx
│   └── Upload.tsx
├── Finance/
│   ├── Dashboard.tsx
│   ├── Payments/
│   │   ├── Index.tsx
│   │   ├── Review.tsx
│   │   └── ManualCreate.tsx
│   ├── Transactions/
│   │   ├── Index.tsx
│   │   ├── Create.tsx
│   │   └── Edit.tsx
│   └── Reports/
│       ├── Monthly.tsx
│       ├── Semester.tsx
│       └── Arrears.tsx
├── Payments/
│   ├── MyPayments.tsx
│   ├── QrisPayment.tsx
│   └── History.tsx
├── Settings/
│   ├── SemesterSettings.tsx
│   ├── CashSettings.tsx
│   └── QrisSettings.tsx
└── Users/
    ├── Index.tsx
    └── RoleManagement.tsx
```

## Konvensi Controller

Gunakan resource controller bila memungkinkan.

Contoh:
- StudentController
- CourseController
- SemesterController
- MeetingController
- AttendanceController
- MaterialController
- PaymentController
- FinancePaymentController
- FinanceTransactionController
- RoleController
- SettingController

## Konvensi Form Request

Contoh:

```text
StoreStudentRequest
UpdateStudentRequest
StoreSemesterRequest
UpdateSemesterRequest
StoreCourseRequest
UpdateCourseRequest
StoreMeetingRequest
UpdateMeetingRequest
SubmitMeetingRequest
ValidateMeetingRequest
StoreAttendanceRequest
SubmitAttendanceRequest
ValidateAttendanceRequest
StoreMaterialRequest
UploadMaterialFileRequest
UploadQrisProofRequest
RecordManualPaymentRequest
ApprovePaymentRequest
RejectPaymentRequest
StoreFinanceTransactionRequest
UpdateFinanceTransactionRequest
UpdateCashSettingRequest
```

## Konvensi Domain Action

Contoh:

```text
AssignRoleToUserAction
CreateStudentAction
UpdateStudentAction
CreateCourseAction
CreateMeetingAction
SubmitAttendanceAction
ValidateAttendanceAction
RejectAttendanceAction
UploadMaterialFileAction
ArchiveMaterialAction
RecordManualPaymentAction
SubmitQrisPaymentProofAction
ApprovePaymentAction
RejectPaymentAction
CancelPaymentAction
GenerateInvoiceAction
CalculateRemainingArrearsAction
AllocatePaymentToObligationsAction
CreateFinanceTransactionAction
UpdateFinanceTransactionAction
```

## Konvensi Policy

Contoh:

```text
UserPolicy
StudentPolicy
SemesterPolicy
CoursePolicy
MeetingPolicy
AttendancePolicy
MaterialPolicy
MaterialFilePolicy
PaymentPolicy
CashObligationPolicy
FinanceTransactionPolicy
SettingPolicy
```

## Konvensi UUID

### Migration
Gunakan:

```php
$table->uuid('id')->primary();
```

Gunakan foreign key:

```php
$table->foreignUuid('user_id')->constrained('users')->cascadeOnDelete();
```

### Model
Gunakan:

```php
use HasUuids;
```

atau gunakan BaseModel:

```php
class User extends Authenticatable
{
    use HasUuids;
}
```

## Aturan Penting

1. Jangan letakkan business logic besar di controller.
2. Jangan percaya authorization dari frontend.
3. Semua route sensitif harus memakai middleware dan policy.
4. Semua file private harus melalui storage disk yang aman.
5. Semua transaksi finansial memakai DB transaction.
6. Semua perubahan role, approve payment, dan validasi absensi dicatat di activity log.
7. Semua primary key domain menggunakan UUID.
8. Jangan menampilkan file bukti atau invoice tanpa policy.