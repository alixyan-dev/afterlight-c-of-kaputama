<?php

namespace App\Policies;

use App\Models\Course;
use App\Models\User;

class CoursePolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('courses.view') || $user->can('courses.manage');
    }

    public function view(User $user, Course $course): bool
    {
        return $user->can('courses.view') || $user->can('courses.manage');
    }

    public function create(User $user): bool
    {
        return $user->can('courses.manage');
    }

    public function update(User $user, Course $course): bool
    {
        return $user->can('courses.manage');
    }

    public function delete(User $user, Course $course): bool
    {
        return $user->can('courses.manage');
    }
}
