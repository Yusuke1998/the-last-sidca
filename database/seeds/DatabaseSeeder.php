<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(DocumentsTableSeeder::class);
        $this->call(TypesTableSeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
