<?php

namespace App\Http\Controllers;

use App\Type;
use App\Ascent;
use App\Person;
use App\Teacher;
use App\Category;
use App\Condition;
use App\Postgraduate;
use App\Undergraduate;
use App\AcademicTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TeacherController extends Controller
{
    public function hired()
    {
        return view('teachers.hired');
    }

    public function ordinary()
    {
        return view('teachers.ordinary');
    }

    public function history()
    {
        return view('teachers.history');
    }

    public function getAll()
    {
        $teachers = Teacher::with('person.document','person.user','person.types','titles','undergraduates','postgraduates','condition','category','dedication','headquarter','area','program','core','extension','TerritorialClassroom','ascents')->get();
        return $teachers;
    }

    public function search($dni)
    {
        $teacher = Teacher::with('person.document','person.user','person.types','titles','undergraduates.university','undergraduates.title','postgraduates.university','postgraduates.title','condition','category','dedication','headquarter.areas.programs','headquarter.areas.cores','headquarter.areas.extensions','headquarter.areas.territorial_classrooms','area.programs','area.cores','area.extensions','area.territorial_classrooms','program','core','extension','TerritorialClassroom','ascents.current_category','ascents.next_category');
        $teacher->whereHas('person',function ($query) use ($dni) {
            $query->where('nro_document','=',$dni);
        });
        return $teacher->first();
    }

    public function teacherDataTable(Request $request)
    {
        $teachers = $this->filterTeacherDataTable($request);
        return [
            'pagination' => [
                'total'         => $teachers->total(),
                'current_page'  => $teachers->currentPage(),
                'per_page'      => $teachers->perPage(),
                'last_page'     => $teachers->lastPage(),
                'from'          => $teachers->firstItem(),
                'to'            => $teachers->lastItem(),
            ],
            'table' => $teachers
        ];
    }

    public function filterTeacherDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $type = mb_strtolower($request->type['type'],'UTF-8');
        $teachers = Teacher::with('person.user','person.document','headquarter','area','core','program','extension','TerritorialClassroom','condition','category','dedication','ascents');

        if (!is_null($type) && !empty($type)) {
            $teachers->where('contract',$type);
        }

        if (!is_null($search) && !empty($search)) {
            $teachers
            ->whereHas('person',function ($query) use ($search) {
                $query
                ->where('firstname','like','%'.$search.'%')
                ->orWhere('lastname','like','%'.$search.'%')
                ->orWhere('nro_document','like','%'.$search.'%')
                ->orWhere('birthday','like','%'.$search.'%')
                ->orWhere('local_phone','like','%'.$search.'%')
                ->orWhere('movil_phone','like','%'.$search.'%')
                ->orWhere('mail_contact','like','%'.$search.'%')
                ->orWhereHas('document',function ($subQuery) use ($search) {
                    $subQuery->where('name','like','%'.$search.'%');
                })
                ->orWhereHas('user',function ($subQuery) use ($search) {
                    $subQuery->where('username','like','%'.$search.'%')
                        ->orWhere('email','like','%'.$search.'%');
                });
            });
        }
        return $teachers->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function setCondition($request)
    {
        if ($request->type['type'] == 'ordinario' && is_null($request->type['condition'])) {
            return $condicion = Condition::where('contract','ordinario')->first();
        }elseif ($request->type['type'] == 'contratado' && !is_null($request->type['condition'])) {
            return $condicion = Condition::where('name','like','%'.$request->type['condition'].'%')
                ->where('contract','contratado')->first();
        }
    }

    public function store(Request $request)
    {
        request()->validate([
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
            'teacherData.category.date'       => 'required',
            'teacherData.category.modality'   => 'required',
        ]);

        if ($request->teacherData['id_teacher'] == 0 && $request->teacherData['person']['id'] == 0) {
            $persona = Person::create([
                'firstname'     => $request->teacherData['person']['firstname'],
                'lastname'      => $request->teacherData['person']['lastname'], 
                'document_id'   => $request->teacherData['person']['document']['id'],
                'nro_document'  => $request->teacherData['person']['nro_document'],
                'local_phone'   => $request->teacherData['person']['local_phone'],
                'movil_phone'   => $request->teacherData['person']['movil_phone'],
                'direction'     => mb_strtolower($request->teacherData['person']['direction'],'UTF-8'),
                'mail_contact'  => mb_strtolower($request->teacherData['person']['mail_contact'],'UTF-8'),
                'birthday'      => Carbon::parse($request->teacherData['person']['birthday'])->toDateString(),
            ]);
            if (is_null($persona->types()->where('name','teacher')->first())) {
                $type = Type::where('name','teacher')->first();
                $persona->types()->attach($type->id);
            }

            $profesor = Teacher::create([
                'person_id'         => $persona->id, 
                'contract'          => $request->type['type'],
                'condition_id'      => $request->teacherData['condition']['id'],
                'dedication_id'     => $request->teacherData['dedication']['id'],
                'headquarter_id'    => $request->teacherData['headquarter']['id'],
                'area_id'           => $request->teacherData['area']['id'],
                'program_id'        => $request->teacherData['program']['id'],
            ]);


            if ($request->teacherData['core']['id'] > 0) {
                $profesor->update(['core_id' => $request->teacherData['core']['id']]);
            }
            if ($request->teacherData['extension']['id'] > 0) {
                $profesor->update(['extension_id' => $request->teacherData['extension']['id']]);
            }
            if ($request->teacherData['t_classroom']['id'] > 0) {
                $profesor->update(['territorial_classroom_id' => $request->teacherData['t_classroom']['id']]);
            }

        }elseif ($request->teacherData['id_teacher'] == 0 && $request->teacherData['person']['id'] > 0) {
            $persona = Person::findOrFail($request->teacherData['person']['id']);
            if (is_null($persona->types()->where('name','teacher')->first())) {
                $type = Type::where('name','teacher')->first();
                $persona->types()->attach($type->id);
            }

            $profesor = Teacher::create([
                'person_id'         => $persona->id, 
                'contract'          => $request->type['type'],
                'condition_id'      => $request->teacherData['condition']['id'],
                'category_id'       => $request->teacherData['category']['id'],
                'dedication_id'     => $request->teacherData['dedication']['id'],
                'headquarter_id'    => $request->teacherData['headquarter']['id'],
                'area_id'           => $request->teacherData['area']['id'],
                'program_id'        => $request->teacherData['program']['id'],
            ]);

            if ($request->teacherData['core']['id'] > 0) {
                $profesor->update(['core_id' => $request->teacherData['core']['id']]);
            }
            if ($request->teacherData['extension']['id'] > 0) {
                $profesor->update(['extension_id' => $request->teacherData['extension']['id']]);
            }
            if ($request->teacherData['t_classroom']['id'] > 0) {
                $profesor->update(['territorial_classroom_id' => $request->teacherData['t_classroom']['id']]);
            }
        }

        // Categoria
        $profesor->update([
            'category_id' => $this->categories($request)['catA']
        ]);
        $ascent = new Ascent;
        $ascent->date                   = $this->categories($request)['datA'];
        $ascent->date_next              = $this->categories($request)['datS'];
        $ascent->current_category_id    = $this->categories($request)['catA'];
        $ascent->next_category_id       = $this->categories($request)['catS'];
        $ascent->modality               = $request->teacherData['category']['modality'];
        $ascent->teacher()->associate($profesor);
        $ascent->save();
    }

    public function update(Request $request)
    {
        request()->validate([
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.nro_document' => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
        ]);

        $teacher = Teacher::findOrFail($request->teacherData['id_teacher']);
        $teacher->person->update([
            'firstname'         => $request->teacherData['person']['firstname'],
            'lastname'          => $request->teacherData['person']['lastname'], 
            'document_id'       => $request->teacherData['person']['document']['id'],
            'nro_document'      => $request->teacherData['person']['nro_document'],
            'local_phone'       => $request->teacherData['person']['local_phone'],
            'movil_phone'       => $request->teacherData['person']['movil_phone'],
            'direction'         => mb_strtolower($request->teacherData['person']['direction'],'UTF-8'),
            'mail_contact'      => mb_strtolower($request->teacherData['person']['mail_contact'],'UTF-8'),
            'birthday'          => Carbon::parse($request->teacherData['person']['birthday'])->toDateString(),
        ]);

        $teacher->update([
            'condition_id'   => $request->teacherData['condition']['id'],
            'dedication_id'  => $request->teacherData['dedication']['id'],
            'headquarter_id' => $request->teacherData['headquarter']['id'],
            'area_id'        => $request->teacherData['area']['id'],
            'program_id'     => $request->teacherData['program']['id'],
        ]);

        if ($request->teacherData['core']['id'] > 0) {
            $teacher->update(['core_id' => $request->teacherData['core']['id']]);
        }
        if ($request->teacherData['extension']['id'] > 0) {
            $teacher->update(['extension_id' => $request->teacherData['extension']['id']]);
        }
        if ($request->teacherData['t_classroom']['id'] > 0) {
            $teacher->update(['territorial_classroom_id' => $request->teacherData['t_classroom']['id']]);
        }

        // Categoria
        if (isset($request->teacherData['category']['date'])) {
            if ($teacher->ascents()->count() > 0) {
                $ascent = $teacher->ascents()->first();
            }else{
                $ascent = new Ascent;
            }
            $teacher->update([
                'category_id' => $this->categories($request)['catA']
            ]);
            $ascent->date                   = $this->categories($request)['datA'];
            $ascent->date_next              = $this->categories($request)['datS'];
            $ascent->current_category_id    = $this->categories($request)['catA'];
            $ascent->next_category_id       = $this->categories($request)['catS'];
            $ascent->modality               = $request->teacherData['category']['modality'];
            $ascent->teacher()->associate($teacher);
            $ascent->save();
            return;
        }
    }

    public function savePreG(Request $request){
        $data = request()->validate([
            'preGData.title.title'      =>  'required',
            'preGData.university.name'  =>  'required',
            'preGData.date'             =>  'required',
            'preGData.teacher_id'       =>  'required'
        ]);
        if ($request->preGData['id']==0) {
            $date = Carbon::parse($request->preGData['date'])->format('Y');
            Undergraduate::create([
                'title_id'      =>  $request->preGData['title']['id'],
                'university_id' =>  $request->preGData['university']['id'],
                'teacher_id'    =>  $request->preGData['teacher_id'],
                'date'          =>  $date
            ]);
        }
        return;
    }

    public function savePostG(Request $request){
        $data = request()->validate([
            'postGData.title.title'     =>  'required',
            'postGData.university.name' =>  'required',
            'postGData.date'            =>  'required',
            'postGData.teacher_id'      =>  'required'
        ]);
        if ($request->postGData['id']==0) {
            $date = Carbon::parse($request->postGData['date'])->format('Y');
            Postgraduate::create([
                'title_id'      =>  $request->postGData['title']['id'],
                'university_id' =>  $request->postGData['university']['id'],
                'teacher_id'    =>  $request->postGData['teacher_id'],
                'date'          =>  $date
            ]);
        }
        return;
    }

    public function saveAcaTraining(Request $request)
    {
        $data = request()->validate([
            'academicTraining.type'             =>  'required',
            'academicTraining.description'      =>  'required',
            'academicTraining.start'            =>  'nullable',
            'academicTraining.end'              =>  'nullable',
            'academicTraining.hours'            =>  'nullable',
            'academicTraining.teacher_id'       =>  'required'
        ]);
        $start = Carbon::parse($request->academicTraining['start'])->format('Y-m-d');
        $end = Carbon::parse($request->academicTraining['end'])->format('Y-m-d');
        AcademicTraining::create([
            'teacher_id'    =>  $request->academicTraining['teacher_id'],
            'description'   =>  $request->academicTraining['description'],
            'hours'         =>  $request->academicTraining['hours'],
            'type'          =>  $request->academicTraining['type'],
            'start'         =>  $start,
            'end'           =>  $end
        ]);
        return;
    }

    public function destroy(Request $request)
    {
        $teacher = Teacher::findOrFail($request->id);
        $teacher->delete();
        return;
    }

    private function categories($request)
    {
        $dc = Carbon::parse($request->teacherData['category']['date'])->toDateString();
        $dn = Carbon::parse($request->teacherData['category']['date']);
        if ($request->teacherData['category']['name'] == 'instructor'){
            $cc_id = $request->teacherData['category']['id'];
            $nc_id = Category::where('name','asistente')->first()->id;
            $dn->addYears(2)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->teacherData['category']['name'] == 'asistente') {
            $cc_id = $request->teacherData['category']['id'];
            $nc_id = Category::where('name','agregado')->first()->id;
            $dn->addYears(4)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->teacherData['category']['name'] == 'agregado') {
            $cc_id = $request->teacherData['category']['id'];
            $nc_id = Category::where('name','asociado')->first()->id;
            $dn->addYears(4)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->teacherData['category']['name'] == 'asociado') {
            $cc_id = $request->teacherData['category']['id'];
            $nc_id = Category::where('name','titular')->first()->id;
            $dn->addYears(5)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->teacherData['category']['name'] == 'titular') {
            $cc_id = $request->teacherData['category']['id'];
            $dn = null;
            $nc_id = null;
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }
    }
}
