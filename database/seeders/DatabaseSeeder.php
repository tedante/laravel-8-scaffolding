<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            ModuleSeeder::class,
            MenuSeeder::class,
            PermissionSeeder::class,
        ]);
        // User::factory(10)->create();
    }
}
