<?php

namespace App\Http\Controllers;

use App\Http\Requests\AssignRoleRequest;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;
use Inertia\Response;

class RoleController extends Controller
{
    /**
     * List users with roles — only komting can access.
     */
    public function index(): Response
    {
        $this->authorize('manageRoles');

        $users = User::with('roles')->paginate(10);

        return Inertia::render('Users/RoleManagement', [
            'users' => $users,
            'roles' => Role::all(['name', 'id']),
        ]);
    }

    /**
     * Assign or change a user's role (transactional + audit log).
     */
    public function assign(AssignRoleRequest $request, User $user): RedirectResponse
    {
        $validated = $request->validated();

        DB::transaction(function () use ($user, $validated) {
            $user->syncRoles($validated['role_name']);

            activity()
                ->causedBy(auth()->user())
                ->performedOn($user)
                ->event('role.changed')
                ->withProperty('new_role', $validated['role_name'])
                ->log('Role changed to '.$validated['role_name']);
        });

        return back()->with('success', 'Role updated.');
    }
}
