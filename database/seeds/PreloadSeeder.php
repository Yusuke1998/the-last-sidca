<?php

use Illuminate\Database\Seeder;
use App\Headquarter;
use App\Core;
use App\Area;
use App\Program;
use App\University;
use App\Title;
use App\Extension;
use App\Territorial_Classroom;

class PreloadSeeder extends Seeder
{
    /**
     * Aqui van todos los datos que se van a pre-cargar al sistema.
     */
    public function run()
    {
        $sedes = ['San Juan de los Morros'];
        foreach ($sedes as $key => $sede) {
        	Headquarter::create(['name'=>$sede]);
        }

        $sede = Headquarter::first();
        $areas = ['Sistemas','Agronomia','Medicina'];
        foreach ($areas as $key => $area) {
            Area::create(['name'=>$area,'headquarter_id'=>$sede->id]);
        }
        
        $area = Area::first();
        $programa = ['Ingenieria en Informatica','Ingenieria Agronomica','Ingenieria en Hidrocarburos'];
        foreach ($programa as $key => $programa) {
            Program::create(['name'=>$programa,'area_id'=>$area->id]);
        }

        $programa = Program::first();
        $nucleos = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $nucleo) {
            Core::create(['name'=>$nucleo,'area_id'=>$area->id,'program_id'=>$programa->id]);
        }

        $aulas_territoriales = ['Mellado','Calabozo','Ortiz'];
        foreach ($aulas_territoriales as $key => $aulas) {
            Territorial_Classroom::create(['name'=>$aulas,'area_id'=>$area->id,'program_id'=>$programa->id]);
        }

        $extensiones = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $extension) {
            Extension::create(['name'=>$extension,'area_id'=>$area->id,'program_id'=>$programa->id]);
        }

        $universidades = 
        [
            [
                'name'=>'Universidad Nacional Experimental de los Llanos Centrales Rómulo Gallegos',
                'acronym'=>'UNERG'
            ],
            [
                'name'=>'Universidad Nacional Experimental Simón Rodríguez',
                'acronym'=>'UNESR'
            ]
        ];
        foreach ($universidades as $key => $universidad) {
            University::create([
                'name'=>$universidad['name'],
                'acronym'=>$universidad['acronym'],
            ]);
        }

        $titulos = 
        [
            [
                'title'=>'Ingenieria X',
                'level'=>'Licenciado'
            ],
            [
                'title'=>'Ingenieria Y',
                'level'=>'Licenciado'
            ]
        ];
        foreach ($titulos as $key => $titulo) {
            Title::create([
                'title'=>$titulo['title'],
                'level'=>$titulo['level'],
            ]);
        }
    }
}
