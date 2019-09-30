<?php

use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    public function run()
    {
    	$types = ['root','teacher'];

    	foreach ($types as $type) {
	        App\Type::create([
	            'name'	=> $type, 
	        ]);
    	}
    }
}
