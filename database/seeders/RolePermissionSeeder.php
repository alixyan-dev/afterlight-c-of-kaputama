<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Seed the roles and permissions defined in docs/design.md.
     *
     * Safe to run multiple times: permissions and roles are created
     * only when they do not exist yet, and permission mapping is
     * attached without detaching existing rows.
     */
    public function run(): void
    {
        $permissions = [
            'users.manage',
            'roles.assign',

            'students.view',
            'students.manage',

            'courses.view',
            'courses.manage',

            'meetings.view',
            'meetings.create',
            'meetings.update',
            'meetings.delete',
            'meetings.submit',
            'meetings.validate',

            'attendance.view',
            'attendance.manage',
            'attendance.validate',

            'materials.view',
            'materials.manage',
            'materials.download',

            'payments.view-own',
            'payments.submit-proof',
            'payments.record-manual',
            'payments.review',
            'payments.approve',
            'payments.reject',

            'finance.view',
            'finance.manage',
            'finance.reports.view',

            'settings.manage',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $rolePermissions = [
            'komting' => $permissions,

            'wakil_komting' => [
                'meetings.view',
                'meetings.create',
                'meetings.validate',
                'attendance.view',
                'attendance.validate',
                'courses.view',
                'materials.view',
            ],

            'sekretaris' => [
                'meetings.view',
                'meetings.create',
                'attendance.view',
                'attendance.manage',
                'courses.view',
                'materials.view',
            ],

            'bendahara' => [
                'payments.view-own',
                'payments.review',
                'payments.approve',
                'payments.reject',
                'payments.record-manual',
                'finance.view',
                'finance.manage',
                'finance.reports.view',
                'students.view',
            ],

            'mahasiswa' => [
                'payments.view-own',
                'payments.submit-proof',
                'courses.view',
                'materials.view',
                'materials.download',
            ],
        ];

        foreach ($rolePermissions as $roleName => $rolePermissionsForRole) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->givePermissionTo($rolePermissionsForRole);
        }
    }
}
