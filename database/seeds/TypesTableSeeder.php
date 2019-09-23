<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    public function run()
    {
        $type = App\Type::create([
            'name'	=> 'root', 
        ]);
    }
}
