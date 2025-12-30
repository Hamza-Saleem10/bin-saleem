<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\PermissionGroup;
use App\Models\Role;
use Illuminate\Database\Seeder;

class AclSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $roles = [
            ['name' => 'Super Admin', 'guard_name' => 'web', 'is_active' => 1],
            ['name' => 'Admin', 'guard_name' => 'web', 'is_active' => 1],
            
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['name' => $role['name']], $role);
        }


        $permissionGroups = [
            ['name' => 'Dashboard', 'order' => 1],
            ['name' => 'Users', 'order' => 2],
            ['name' => 'Bookings', 'order' => 3],
            ['name' => 'Vehicles', 'order' => 4],
            ['name' => 'Reviews', 'order' => 5],
            ['name' => 'Roles', 'order' => 6],
            ['name' => 'Permission Groups', 'order' => 7],
            ['name' => 'Permissions', 'order' => 8],
        ];

        foreach ($permissionGroups as $group) {
            PermissionGroup::updateOrCreate(['name' => $group['name']], $group);
        }

        $permissions = [
            ['name' => 'Users List', 'permission_group_id' => 2, 'guard_name' => 'web'],
            ['name' => 'Create User', 'permission_group_id' => 2, 'guard_name' => 'web'],
            ['name' => 'View User', 'permission_group_id' => 2, 'guard_name' => 'web'],
            ['name' => 'Update User', 'permission_group_id' => 2, 'guard_name' => 'web'],
            ['name' => 'Delete User', 'permission_group_id' => 2, 'guard_name' => 'web'],

            ['name' => 'Bookings List', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'Create Booking', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'View Booking', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'Update Booking', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'Delete Booking', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'Update Booking Status', 'permission_group_id' => 3, 'guard_name' => 'web'],
            ['name' => 'View Booking Voucher', 'permission_group_id' => 3, 'guard_name' => 'web'],

            ['name' => 'Vehicles List', 'permission_group_id' => 4, 'guard_name' => 'web'],
            ['name' => 'Create Vehicle', 'permission_group_id' => 4, 'guard_name' => 'web'],
            ['name' => 'View Vehicle', 'permission_group_id' => 4, 'guard_name' => 'web'],
            ['name' => 'Update Vehicle', 'permission_group_id' => 4, 'guard_name' => 'web'],
            ['name' => 'Delete Vehicle', 'permission_group_id' => 4, 'guard_name' => 'web'],
            ['name' => 'Update Vehicle Status', 'permission_group_id' => 4, 'guard_name' => 'web'],

            ['name' => 'Reviews List', 'permission_group_id' => 5, 'guard_name' => 'web'],
            ['name' => 'Create Review', 'permission_group_id' => 5, 'guard_name' => 'web'],
            ['name' => 'View Review', 'permission_group_id' => 5, 'guard_name' => 'web'],
            ['name' => 'Update Review', 'permission_group_id' => 5, 'guard_name' => 'web'],
            ['name' => 'Delete Review', 'permission_group_id' => 5, 'guard_name' => 'web'],

            ['name' => 'Roles List', 'permission_group_id' => 6, 'guard_name' => 'web'],
            ['name' => 'Create Role', 'permission_group_id' => 6, 'guard_name' => 'web'],
            ['name' => 'View Role', 'permission_group_id' => 6, 'guard_name' => 'web'],
            ['name' => 'Update Role', 'permission_group_id' => 6, 'guard_name' => 'web'],
            ['name' => 'Delete Role', 'permission_group_id' => 6, 'guard_name' => 'web'],

            ['name' => 'Permission Groups List', 'permission_group_id' => 7, 'guard_name' => 'web'],
            ['name' => 'Create Permission Group', 'permission_group_id' => 7, 'guard_name' => 'web'],
            ['name' => 'View Permission Group', 'permission_group_id' => 7, 'guard_name' => 'web'],
            ['name' => 'Update Permission Group', 'permission_group_id' => 7, 'guard_name' => 'web'],
            ['name' => 'Delete Permission Group', 'permission_group_id' => 7, 'guard_name' => 'web'],

            ['name' => 'Permissions List', 'permission_group_id' => 8, 'guard_name' => 'web'],
            ['name' => 'Create Permission', 'permission_group_id' => 8, 'guard_name' => 'web'],
            ['name' => 'View Permission', 'permission_group_id' => 8, 'guard_name' => 'web'],
            ['name' => 'Update Permission', 'permission_group_id' => 8, 'guard_name' => 'web'],
            ['name' => 'Delete Permission', 'permission_group_id' => 8, 'guard_name' => 'web'],

            // ['name' => 'Institutions List', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Create Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'View Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Review Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Update Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Delete Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Update Institution Status', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'View Institution Status', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Institution Challan', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Institution Challan Mark Paid', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Institution Certificate', 'permission_group_id' => 11, 'guard_name' => 'web'],
            // ['name' => 'Renew Institution', 'permission_group_id' => 11, 'guard_name' => 'web'],


        ];

        foreach ($permissions as $permission) {
            Permission::updateOrCreate(['name' => $permission['name']], $permission);
        }

        ### Admin Permissions
        $role = Role::find(2);
        $role->syncPermissions([
            'Users List',
            'Create User',
            'View User',
            'Update User',
            'Delete User',

        ]);

        ### Institution Permissions
        // $role = Role::find(3);
        // $role->syncPermissions([
            // 'Users List', 
        // ]);

    }
}
