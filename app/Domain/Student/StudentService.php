<?php

namespace App\Domain\Student;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;
use Spatie\Activitylog\Facades\Activity;

class StudentService
{
    public function __construct(
        protected StudentRepository $repository,
    ) {}

    public function listStudents(
        ?string $search = null,
        ?string $status = null,
        ?string $sort = 'name',
        ?string $direction = 'asc',
        int $perPage = 10,
    ): LengthAwarePaginator {
        return $this->repository->findAllWithFilters(
            $search, $status, $sort, $direction, $perPage
        );
    }

    public function createStudent(array $data): User
    {
        $user = $this->repository->create($data);
        $this->repository->assignRoleMahasiswa($user);

        Activity::causedBy(auth()->user())
            ->performedOn($user)
            ->log('Akun mahasiswa dibuat');

        return $user;
    }

    public function updateStudent(User $user, array $data): User
    {
        $updated = $this->repository->update($user, $data);

        Activity::causedBy(auth()->user())
            ->performedOn($updated)
            ->log('Data akun mahasiswa diperbarui');

        return $updated;
    }

    public function deleteStudent(User $user): bool
    {
        Activity::causedBy(auth()->user())
            ->performedOn($user)
            ->log('Akun mahasiswa dihapus');

        return $this->repository->delete($user);
    }

    public function resetPassword(User $user): string
    {
        $plainPassword = Str::random(4).'-'.Str::random(4).'-'.Str::random(4);

        $this->repository->resetPassword($user, $plainPassword);

        Activity::causedBy(auth()->user())
            ->performedOn($user)
            ->log('Password direset');

        return $plainPassword;
    }

    public function findById(string $id): ?User
    {
        return $this->repository->findById($id);
    }
}
