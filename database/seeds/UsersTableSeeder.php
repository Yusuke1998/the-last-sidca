<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
    	$document = App\Document::first();

        // Administrador
    	$person = App\Person::create([
            'firstname'		=>	'Jhonny Jose',
            'lastname'		=>	'Pérez Martinez',
            'document_id'	=>	$document->id,
            'nro_document'	=>	'26039408',
            'birthday'		=>	'1998-02-27',
            'direction'		=>	'villa de cura, las mercedes',
            'local_phone'	=>	'02443864361',
            'movil_phone'	=>	'04161428973',
            'mail_contact'	=>	'jhonnyjose1998@gmail.com'
        ]);
        $type = App\Type::where('name','root')->first();
        $person->types()->attach($type->id);
        $user = App\User::create([
            'username'		=> 'admin', 
            'email'         => 'admin@admin.com', 
            'password'      => bcrypt('admin'),
            'person_id'		=> $person->id,
        ]);
        // Fin Administrador

        $sede = App\Headquarter::first();
        $area = App\Area::first();
        $prog = App\Program::first();
        $cond = App\Condition::where('contract','contratado')->first();
        // Profesor
        $person = App\Person::create([
            'firstname'     =>  'Edith',
            'lastname'      =>  'Hernandez',
            'document_id'   =>  $document->id,
            'nro_document'  =>  '10101010',
            'birthday'      =>  '1992-01-10',
            'direction'     =>  'San Juan',
        ]);
        $teacher = App\teacher::create([
            'person_id'         =>  $person->id,
            'contract'          =>  'contratado',
            'headquarter_id'    =>  $sede->id,
            'area_id'           =>  $area->id,
            'program_id'        =>  $prog->id,
            'condition_id'      =>  $cond->id
        ]);
        $type = App\Type::where('name','teacher')->first();
        $person->types()->attach($type->id);
        // Fin Profesor
    }
}
