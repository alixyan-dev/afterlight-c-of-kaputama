<?php

namespace App\Policies;

use App\Models\StudentProfile;
use App\Models\User;

class StudentProfilePolicy
{
    public function manage(User $user): bool
    {
        return $user->can('students.manage');
    }

    public function viewAny(User $user): bool
    {
        return $user->can('students.view');
    }

    public function view(User $user, StudentProfile $profile): bool
    {
        return $user->can('students.view');
    }

    public function create(User $user): bool
    {
        return $user->can('students.manage');
    }

    public function update(User $user, StudentProfile $profile): bool
    {
        return $user->can('students.manage');
    }

    public function delete(User $user, StudentProfile $profile): bool
    {
        return $user->can('students.manage');
    }
}
