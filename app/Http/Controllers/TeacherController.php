<?php

namespace App\Http\Controllers;

use App\Type;
use App\Person;
use App\Teacher;
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
        $type = mb_strtolower($request->type,'UTF-8');
        $teachers = Teacher::with('person.user','person.document','headquarter','area','core','program','extension','TerritorialClassroom','condition');

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

    public function store(Request $request)
    {
        request()->validate([
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date'
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
                'person_id'         =>$persona->id, 
                'contract'          =>$request->type,
                'headquarter_id'    => $request->teacherData['headquarter']['id'],
                'area_id'           => $request->teacherData['area']['id'],
                'program_id'        => $request->teacherData['program']['id']
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
                'person_id'         =>$persona->id, 
                'contract'          =>$request->type,
                'headquarter_id'    => $request->teacherData['headquarter']['id'],
                'area_id'           => $request->teacherData['area']['id'],
                'program_id'        => $request->teacherData['program']['id']
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
            'teacherData.person.birthday'     => 'required|date'
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
        return;
    }

    public function destroy(Request $request)
    {
        $teacher = Teacher::findOrFail($request->id);
        $teacher->delete();
        return;
    }
}
