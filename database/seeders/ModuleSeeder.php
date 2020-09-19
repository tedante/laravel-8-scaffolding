<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('modules')->insert([
            [
                'name' => 'role',
                'icon' => 'web',
                'path' => 'roles',
                'table_name' => 'roles',
                'controller' => 'RoleController',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'menu',
                'icon' => 'web',
                'path' => 'menus',
                'table_name' => 'menus',
                'controller' => 'MenuController',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'user',
                'icon' => 'web',
                'path' => 'users',
                'table_name' => 'users',
                'controller' => 'UserController',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
            [
                'name' => 'permission',
                'icon' => 'web',
                'path' => 'permissions',
                'table_name' => 'permissions',
                'controller' => 'PermissionController',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]
        ]);
    }
}
