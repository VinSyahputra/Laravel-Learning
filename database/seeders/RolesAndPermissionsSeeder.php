<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            ['name' => 'master.dashboard'],
        ];

        Permission::upsert($permissions, ['name']);

        $permissionNames = collect($permissions)->pluck('name');

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($permissionNames);

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo(['master.dashboard']);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo(['master.dashboard']);
    }
}
