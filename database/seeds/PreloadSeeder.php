<?php

use Illuminate\Database\Seeder;
use App\Headquarter;
use App\Core;
use App\Condition;
use App\Dedication;
use App\Category;
use App\Area;
use App\Program;
use App\University;
use App\Title;
use App\Extension;
use App\TerritorialClassroom;

class PreloadSeeder extends Seeder
{
    /**
     * Aqui van todos los datos que se van a pre-cargar al sistema.
     */
    public function run()
    {
        $condiciones = ['fijo','contratado','honorario profesional','auxiliar docente'];

        foreach ($condiciones as $condicion) {
            Condition::create(['name'   =>  $condicion]);
        }

        $dedicaciones = ['exclusiva','tiempo completo','medio tiempo','tiempo convencional'];

        foreach ($dedicaciones as $dedicacion) {
            Dedication::create(['name'   =>  $dedicacion]);
        }

        $categorias = ['instructor','asistente','agregado','asociado','titular'];

        foreach ($categorias as $categoria) {
            Category::create(['name'   =>  $categoria]);
        }

        $sedes = ['San Juan de los Morros'];
        foreach ($sedes as $key => $sede) {
        	Headquarter::create(['name'=>$sede]);
        }

        $sede = Headquarter::first();
        $areas = [
            [
                'name'      =>  'CIENCIAS DE LA SALUD',
                'acronym'   =>  'ACS'
            ],
            [
                'name'      =>  'CIENCIAS ECONOMICAS',
                'acronym'   =>  'ACES'
            ],
            [
                'name'      =>  'INGENIERIA DE SISTEMAS',
                'acronym'   =>  'AIS'
            ],
            [
                'name'      =>  'INGENIERIA, ARQUITECTURA Y TECNOLOGIA',
                'acronym'   =>  'AIAT'
            ],
            [
                'name'      =>  'INGENIERIA AGRONOMICA',
                'acronym'   =>  'AIA'
            ],
            [
                'name'      =>  'CIENCIAS POLITICAS Y JURIDICAS',
                'acronym'   =>  'ACP'
            ],
            [
                'name'      =>  'AREA DE MEDICINA VETERINARIA',
                'acronym'   =>  'AMV'
            ],
            [
                'name'      =>  'HUMANIDADES, LETRAS Y ARTE',
                'acronym'   =>  'AHLA'
            ],
            [
                'name'      =>  'CIENCIAS ODONTOLOGICAS',
                'acronym'   =>  'ACO'
            ],
            [
                'name'      =>  'CIENCIAS DE LA EDUCACION',
                'acronym'   =>  'ACE'
            ],
            [
                'name'      =>  'PROGRAMA NACIONAL DE FORMACION',
                'acronym'   =>  'PNF'
            ],
            [
                'name'      =>  'FISIOTERAPIA',
                'acronym'   =>  'PNF-FI'
            ],
            [
                'name'      =>  'TERAPIA OCUPACIONAL',
                'acronym'   =>  'PNF-TE'
            ],
            [
                'name'      =>  'HISTORIA',
                'acronym'   =>  'PNF-HI'
            ],
            [
                'name'      =>  'NUTRICION Y DIETETICA',
                'acronym'   =>  'PNF-NU'
            ],
            [
                'name'      =>  'HISTOCITOTECNOLOA',
                'acronym'   =>  'PNF-HT'
            ],
            [
                'name'      =>  'OPTOMETRIA Y OPTICA',
                'acronym'   =>  'PNF-OP'
            ],
            [
                'name'      =>  'EDUCACION CONTINUA',
                'acronym'   =>  'DEC'
            ]
        ];
        foreach ($areas as $key => $area) {
            Area::create([
                'name'          =>  $area['name'],
                'acronym'       =>  $area['acronym'],
                'headquarter_id'=>  $sede->id
            ]);
        }
        
        $area = Area::first();
        $sede = $area->headquarter;
        $programa = ['Ingenieria en Informatica','Ingenieria Agronomica','Ingenieria en Hidrocarburos'];
        foreach ($programa as $programa) {
            Program::create([
                'name'          =>$programa,
                'area_id'       =>$area->id,
                'headquarter_id'=>$sede->id,
            ]);
        }

        $programa = Program::first();
        $sede = $programa->headquarter;
        $nucleos = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $nucleo) {
            Core::create([
                'name'=>$nucleo,
                'headquarter_id'=>$sede->id,
                'area_id'=>$area->id,
                'program_id'=>$programa->id
            ]);
        }

        $aulas_territoriales = ['Mellado','Calabozo','Ortiz'];
        foreach ($aulas_territoriales as $key => $aulas) {
            TerritorialClassroom::create([
                'name'=>$aulas,
                'headquarter_id'=>  $sede->id,
                'area_id'=>$area->id,
                'program_id'=>$programa->id
            ]);
        }

        $extensiones = ['Mellado','Calabozo','Ortiz'];
        foreach ($nucleos as $key => $extension) {
            Extension::create([
                'name'=>$extension,
                'headquarter_id'=>  $sede->id,
                'area_id'=>$area->id,
                'program_id'=>$programa->id
            ]);
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
                'level'=>'doctorado'
            ],
            [
                'title'=>'Ingenieria Y',
                'level'=>'especializacion'
            ],
            [
                'title'=>'Ingenieria Z',
                'level'=>'maestria'
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
