<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            [
            'name' => 'developer',
            'email' => 'developer@yopmail.com',
            'is_active' => 1,
            'avatar_link' => null,
            'password' => '$2y$10$.Fqy2UeFm4Rzcwuw3xcN9OPCxzYoa7NfYF1QU0IQdvoC9i1B2EYVS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ],
            [
            'name' => 'superadmin',
            'email' => 'superadmin@yopmail.com',
            'is_active' => 1,
            'avatar_link' => null,
            'password' => '$2y$10$.Fqy2UeFm4Rzcwuw3xcN9OPCxzYoa7NfYF1QU0IQdvoC9i1B2EYVS',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            ],
        ]);
        DB::table('model_has_roles')->insert([
            [
            'role_id' => 1,
            'model_type' => 'App\Models\User',
            'model_id' => 1
            ],
            [
            'role_id' => 2,
            'model_type' => 'App\Models\User',
            'model_id' => 2
            ],
        ]);
    }
}
