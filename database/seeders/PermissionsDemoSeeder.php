<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'access_admin']);
        Permission::create(['name' => 'access_leader']);
        Permission::create(['name' => 'access_department']);
        Permission::create(['name' => 'access_user']);
        $role = Role::create(['name' => 'admin'])
            ->givePermissionTo(['access_admin', 'access_leader','access_department', 'access_user']);
        $role = Role::create(['name' => 'leader'])
            ->givePermissionTo(['access_leader','access_user', 'access_department']);
        $role = Role::create(['name' => 'department'])
            ->givePermissionTo(['access_department', 'access_user']);
        $role = Role::create(['name' => 'user'])
            ->givePermissionTo(['access_user']);

        $admin = User::create([
            'name' => "admin",
            'email' => "admin@gmail.com",
            'password' => Hash::make('123456'),
        ]);
        $admin->assignRole('admin');

        $leader = User::create([
            'name' => "leader",
            'email' => "leader@gmail.com",
            'password' => Hash::make('123456'),
        ]);
        $leader->assignRole('leader');

        $leader = User::create([
            'name' => "department",
            'email' => "department@gmail.com",
            'password' => Hash::make('123456'),
        ]);
        $leader->assignRole('department');

        $user = User::create([
            'name' => "user",
            'email' => "user@gmail.com",
            'password' => Hash::make('123456'),
        ]);
        $user->assignRole('user');
    }
}
