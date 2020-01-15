<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Administrador
    	$document = App\Document::first();
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
        $cond = App\Condition::where('name','fijo')->first();
        $cate = App\Category::where('name','instructor')->first();
        $caii = App\Category::where('name','asistente')->first();
        $dedi = App\Dedication::where('name','exclusiva')->first();
        $univ = App\University::where('id','1')->first();
        $titl = App\Title::where('id','1')->first();
        
        // Profesor
        $person = App\Person::create([
            'firstname'     =>  'Edith',
            'lastname'      =>  'Hernandez',
            'document_id'   =>  $document->id,
            'nro_document'  =>  '10101010',
            'birthday'      =>  '1992-01-10',
            'direction'     =>  'San Juan',
        ]);
        $teacher = App\Teacher::create([
            'person_id'         =>  $person->id,
            'contract'          =>  'ordinario',
            'headquarter_id'    =>  $sede->id,
            'area_id'           =>  $area->id,
            'program_id'        =>  $prog->id,
            'condition_id'      =>  $cond->id,
            'category_id'       =>  $cate->id,
            'dedication_id'     =>  $dedi->id
        ]);
        $date = Carbon::now();
        $daii = Carbon::now()->addYear(2);
        $teacher->postgraduates()->create([
            'date'              =>  $date->format('Y'),
            'university_id'     =>  $univ->id,
            'title_id'          =>  $titl->id,
        ]);
        $teacher->undergraduates()->create([
            'date'              =>  $date->format('Y'),
            'university_id'     =>  $univ->id,
            'title_id'          =>  $titl->id,
        ]);
        $asce = App\Ascent::create([
            'current_category_id'   =>  $cate->id,
            'date'                  =>  $date,
            'next_category_id'      =>  $caii->id,
            'date_next'             =>  $daii,
            'teacher_id'            =>  $teacher->id,
            'modality'              =>  'Art. 61',
            'status'                =>  'aprobado'
        ]);
        $type = App\Type::where('name','teacher')->first();
        $person->types()->attach($type->id);    
        // Fin Profesor
    }
}
