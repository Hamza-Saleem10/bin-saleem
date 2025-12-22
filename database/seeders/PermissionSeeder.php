<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // return true;

        $permissions = [
            'Dashboard',
            'Users List',
            'Create User',
            'Edit User',
            'Update User',
            'Delete User', 

            'Roles List',
            'Permissions List',
        ];

        foreach($permissions as $permission) {
            Permission::updateOrCreate([
                'name' => $permission
            ]);
        }

        $role = Role::findByName('Super Admin');
        $role->givePermissionTo(Permission::all());
    }
}
