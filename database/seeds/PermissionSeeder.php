<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Roles
        $admin = Role::create(['guard_name' => 'admin', 'name' => 'admin']);
        $departmentAdmin = Role::create(['name' => 'department_admin']);
        $departmentUser = Role::create(['name' => 'department_user']);
        $auditor = Role::create(['name' => 'auditor']);
        $user = Role::create(['name' => 'user']);
    }
}
