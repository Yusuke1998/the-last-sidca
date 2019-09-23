<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
    	$document = App\Document::first();

    	$person = App\Person::create([
            'firstname'		=>	'Jhonny Jose',
            'lastname'		=>	'Pérez Martinez',
            'document_id'	=>	$document->id,
            'nro_document'	=>	'26039408',
            'birthday'		=>	'1998-02-27',
            'direction'		=>	'Villa de Cura, Las Mercedes',
            'local_phone'	=>	'02443864361',
            'movil_phone'	=>	'04161428973',
            'mail_contact'	=>	'jhonnyjose1998@gmail.com'
        ]);

        $type = App\Type::first();
        $person->types()->attach($type->id);

        $user = App\User::create([
            'username'		=> 'admin', 
            'email'         => 'admin@admin.com', 
            'password'      => bcrypt('admin'),
            'person_id'		=> $person->id,
        ]);
    }
}
