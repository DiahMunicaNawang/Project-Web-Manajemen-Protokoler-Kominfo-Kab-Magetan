<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Persons;
use App\Models\User;
use Illuminate\Database\Seeder;
use Database\Seeders\MenusSeeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MenusSeeder::class);
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo(Permission::all());

        $roles = ['role1', 'role2', 'role3', 'role4', 'role5'];

        foreach ($roles as $roleName) {
            $role = Role::create(['name' => $roleName]);
            $role->givePermissionTo(['Dashboard', 'Dashboard-read', 'Dashboard-create']);
        }

        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@demo.com',
            'password' => bcrypt('demo'),
        ]);
        $user->assignRole('admin');

        Persons::create([
            'user_id' => $user->id,
            'name' => 'Admin User',
            'email' => $user->email,
            'nip' => '1234567890',
        ]);

        $this->call([
            UserSeeder::class,
            EventsSeeder::class,
        ]);
    }
}
