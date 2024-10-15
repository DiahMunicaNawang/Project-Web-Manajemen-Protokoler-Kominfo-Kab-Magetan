<?php

namespace Database\Seeders;

use App\Models\AccessModel;
use App\Models\MenusModel;
use Illuminate\Database\Seeder;

class MenusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $json = file_get_contents(public_path('seeds/Menus.json'));
        $menus = json_decode($json, true);
        $actions = ['create', 'read', 'update', 'delete', 'export', 'search'];

        foreach ($menus as $menu) {
            $createdMenu = MenusModel::create([
                'name' => $menu['name'],
                'module' => $menu['module'],
                'slug' => $menu['slug'],
                'icon' => $menu['icon'],
                'url' => $menu['url'],
                'parent_id' => $menu['parent_id'],
                'order' => $menu['order'],
                'status' => $menu['status'],
            ]);
        }
    }
}
