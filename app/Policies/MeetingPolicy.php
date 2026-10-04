<?php
namespace App\Policies;
use App\Models\Meeting;
use App\Models\User;
class MeetingPolicy
{
    public function viewAny(User $user): bool { return $user->can('meetings.view') || $user->can('meetings.create'); }
    public function view(User $user, Meeting $meeting): bool { return $user->can('meetings.view') || $user->can('meetings.create'); }
    public function create(User $user): bool { return $user->can('meetings.create'); }
    public function update(User $user, Meeting $meeting): bool { return $user->can('meetings.update'); }
    public function delete(User $user, Meeting $meeting): bool { return $user->can('meetings.delete'); }
    public function submit(User $user, Meeting $meeting): bool { return $user->can('meetings.submit'); }
    public function validate(User $user, Meeting $meeting): bool { return $user->can('meetings.validate'); }
}
