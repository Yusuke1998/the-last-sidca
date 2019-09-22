<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $user = App\User::create([
            'username'		=> 'admin', 
            'email'         => 'admin@admin.com', 
            'password'      => bcrypt('admin'),
        ]);
    }
}
