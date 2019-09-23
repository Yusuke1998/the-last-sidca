<?php

use Illuminate\Database\Seeder;

class DocumentsTableSeeder extends Seeder
{
    public function run()
    {
        $document = App\Document::create([
            'name'	=> 'cedula'
        ]);

        $document = App\Document::create([
            'name'	=> 'pasaporte'
        ]);
    }
}
