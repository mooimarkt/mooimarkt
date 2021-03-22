<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'userRole' => 'admin',
            'isSocial' => 'false',
            'password' => bcrypt('admin@admin.com'),
        ]);

        User::create([
            'name' => 'User',
            'email' => 'user@user.com',
            'userRole' => 'unset',
            'isSocial' => 'false',
            'password' => bcrypt('user@user.com'),
        ]);
    }
}
