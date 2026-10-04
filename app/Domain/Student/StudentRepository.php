<?php

namespace App\Domain\Student;

use App\Models\User;
use Illuminate\Pagination\LengthAwarePaginator;

class StudentRepository
{
    public function findAllWithFilters(
        ?string $search = null,
        ?string $status = null,
        ?string $sort = 'name',
        ?string $direction = 'asc',
        int $perPage = 10
    ): LengthAwarePaginator {
        $query = User::with('roles')
            ->whereHas('roles', fn ($q) => $q->where('name', 'mahasiswa'));

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'ilike', "%{$search}%")
                    ->orWhere('email', 'ilike', "%{$search}%");
            });
        }

        if ($status === 'active') {
            $query->where('is_active', true);
        } elseif ($status === 'inactive') {
            $query->where('is_active', false);
        }

        $allowedSorts = ['name', 'email', 'is_active', 'created_at'];
        $sort = in_array($sort, $allowedSorts, true) ? $sort : 'name';
        $direction = strtolower($direction) === 'desc' ? 'desc' : 'asc';

        $query->orderBy($sort, $direction);

        return $query->paginate($perPage)->withQueryString();
    }

    public function findById(string $id): ?User
    {
        return User::with('roles', 'studentProfile')->find($id);
    }

    public function create(array $data): User
    {
        return User::create($data);
    }

    public function update(User $user, array $data): User
    {
        $user->update($data);

        return $user;
    }

    public function delete(User $user): bool
    {
        return $user->delete();
    }

    public function resetPassword(User $user, string $plainPassword): User
    {
        $user->update(['password' => $plainPassword]);

        return $user;
    }

    public function assignRoleMahasiswa(User $user): void
    {
        $user->assignRole('mahasiswa');
    }
}
