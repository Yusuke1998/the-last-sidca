<?php

use Illuminate\Database\Seeder;
use App\Headquarter;
use App\Core;
use App\Area;
use App\Career;
use App\University;
use App\Title;

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

        $areas = ['Sistemas','Agronomia','Medicina'];
        foreach ($areas as $key => $area) {
            Area::create(['name'=>$area]);
        }
        
        $area = Area::first();
        $nucleos = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $nucleo) {
            Core::create(['name'=>$nucleo,'area_id'=>$area->id]);
        }

        $carreras = ['Ingenieria en Informatica','Ingenieria Agronomica','Ingenieria en Hidrocarburos'];
        foreach ($carreras as $key => $carrera) {
            Career::create(['name'=>$carrera,'area_id'=>$area->id]);
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
