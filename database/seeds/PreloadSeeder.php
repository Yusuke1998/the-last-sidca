<?php

use Illuminate\Database\Seeder;
use App\Headquarter;
use App\Core;
use App\Area;
use App\Career;

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

        $nucleos = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $nucleo) {
            Core::create(['name'=>$nucleo,'headquarter_id'=>$sede->id]);
        }

        $areas = ['Sistemas','Agronomia','Medicina'];
        foreach ($areas as $key => $area) {
            Area::create(['name'=>$area]);
        }

        $carreras = ['Ingenieria en Informatica','Ingenieria Agronomica','Ingenieria en Hidrocarburos'];
        foreach ($carreras as $key => $carrera) {
            Career::create(['name'=>$carrera]);
        }
    }
}
