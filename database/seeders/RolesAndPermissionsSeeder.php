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
            ['name' => 'master.information'],

            ['name' => 'teacher.my-class.view'],
            ['name' => 'teacher.my-class.create'],
            ['name' => 'teacher.my-class.edit'],
            ['name' => 'teacher.my-class.delete'],

            ['name' => 'teacher.class.view'],
            ['name' => 'teacher.class.create'],
            ['name' => 'teacher.class.edit'],
            ['name' => 'teacher.class.delete'],

            ['name' => 'teacher.quiz.view'],
            ['name' => 'teacher.quiz.create'],
            ['name' => 'teacher.quiz.edit'],
            ['name' => 'teacher.quiz.delete'],

            ['name' => 'teacher.question.view'],
            ['name' => 'teacher.question.create'],
            ['name' => 'teacher.question.edit'],
            ['name' => 'teacher.question.delete'],

            ['name' => 'teacher.report.view'],
            ['name' => 'teacher.report.create'],
            ['name' => 'teacher.report.edit'],
            ['name' => 'teacher.report.delete'],

            ['name' => 'student.my-class.view'],
            ['name' => 'student.my-class.create'],
            ['name' => 'student.my-class.edit'],
            ['name' => 'student.my-class.delete'],

            ['name' => 'student.class.view'],
            ['name' => 'student.class.create'],
            ['name' => 'student.class.edit'],
            ['name' => 'student.class.delete'],

            ['name' => 'student.certificate.view'],
            ['name' => 'student.certificate.create'],
            ['name' => 'student.certificate.edit'],
            ['name' => 'student.certificate.delete'],

            ['name' => 'student.report.view'],
            ['name' => 'student.report.create'],
            ['name' => 'student.report.edit'],
            ['name' => 'student.report.delete'],

            ['name' => 'admin.tool.general'],
            ['name' => 'admin.tool.log'],
            ['name' => 'admin.tool.queue'],
            ['name' => 'admin.tool.email-tester'],

            ['name' => 'admin.user.view'],
            ['name' => 'admin.user.create'],
            ['name' => 'admin.user.edit'],
            ['name' => 'admin.user.delete'],

            ['name' => 'admin.role.view'],
            ['name' => 'admin.role.create'],
            ['name' => 'admin.role.edit'],
            ['name' => 'admin.role.delete'],

            ['name' => 'admin.permission.view'],
            ['name' => 'admin.permission.create'],
            ['name' => 'admin.permission.edit'],
            ['name' => 'admin.permission.delete'],
        ];

        Permission::upsert($permissions, ['name']);

        $permissionNames = collect($permissions)->pluck('name');

    
        $adminPermissions = $permissionNames->filter(fn ($name) => str_starts_with($name, 'admin.'))->toArray();
        $adminPermissions = array_merge($adminPermissions, $permissionNames->filter(fn ($name) => str_starts_with($name, 'master.'))->toArray());

        // Create roles and assign permissions
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->givePermissionTo($adminPermissions);
        
        $teacherPermissions = $permissionNames->filter(fn ($name) => str_starts_with($name, 'teacher.'))->toArray();
        $teacherPermissions = array_merge($teacherPermissions, $permissionNames->filter(fn ($name) => str_starts_with($name, 'master.'))->toArray());

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo($teacherPermissions);

        $studentPermissions = $permissionNames->filter(fn ($name) => str_starts_with($name, 'student.'))->toArray();
        $studentPermissions = array_merge($studentPermissions, $permissionNames->filter(fn ($name) => str_starts_with($name, 'master.'))->toArray());

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo($studentPermissions);
    }
}
