<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateInitialAdminAccount extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::unguard();
        User::create([
            'first_name' => 'Admin',
            'last_name' => 'Account',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'is_active' => true,
            'is_admin' => true,
            'user_name' => 'admin-account',
        ]);
    }
}
