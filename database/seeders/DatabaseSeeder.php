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
        $super_admin = Role::create(['name' => 'super-admin']);
        $super_admin->givePermissionTo(Permission::all());

        $adminProtokoler = Role::create(['name' => 'admin-protokoler']);
        $adminProtokoler->givePermissionTo(['Dashboard', 'Dashboard-read', 'Dashboard-create', 'Event', 'Event-create', 'Event-read', 'Event-update', 'Event-delete']);

        $adminInstansi = Role::create(['name' => 'admin-instansi']);
        $adminInstansi->givePermissionTo(['Dashboard', 'Dashboard-read', 'Dashboard-create', 'Event']);

        $super_admin = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@demo.com',
            'password' => bcrypt('demo'),
        ]);
        $super_admin->assignRole('super-admin');

        $admin_protokoler = User::create([
            'name' => 'Admin Protokoler',
            'email' => 'adminprotokoler@demo.com',
            'password' => bcrypt('demo'),
        ]);
        $admin_protokoler->assignRole('admin-protokoler');

        $admin_instansi = User::create([
            'name' => 'Admin Instansi',
            'email' => 'admininstansi@demo.com',
            'password' => bcrypt('demo'),
        ]);
        $admin_instansi->assignRole('admin-instansi');

        Persons::create([
            'user_id' => $super_admin->id,
            'name' => 'Super Admin',
            'email' => $super_admin->email,
            'nip' => '1234567890',
        ]);

        Persons::create([
            'user_id' => $admin_protokoler->id,
            'name' => 'Admin Protokoler',
            'email' => $admin_protokoler->email,
            'nip' => '1234567890',
        ]);

        Persons::create([
            'user_id' => $admin_instansi->id,
            'name' => 'Admin Instansi',
            'email' => $admin_instansi->email,
            'nip' => '1234567890',
        ]);

        $this->call([
            UserSeeder::class,
            EventsSeeder::class,
        ]);
    }
}
