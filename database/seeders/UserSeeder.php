<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create(['username' => 'super_admin', 'name' => 'Super Admin', 'email' => 'admin@binsaleem.com', 'password' => Hash::make('Admin@p!t6')]);
        $user->syncRoles(['Super Admin']);
    }
}
