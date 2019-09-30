<?php

namespace App\Http\Controllers;

use App\Type;
use App\Person;
use App\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TeacherController extends Controller
{
    public function index()
    {
        return view('teachers.index');
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
        $teachers = Teacher::with('person.user','person.document');

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
            $profesor = Teacher::create(['person_id'=>$persona->id]);

        }elseif ($request->teacherData['id_teacher'] == 0 && $request->teacherData['person']['id'] > 0) {
            $persona = Person::findOrFail($request->teacherData['person']['id']);
            if (is_null($persona->types()->where('name','teacher')->first())) {
                $type = Type::where('name','teacher')->first();
                $persona->types()->attach($type->id);
            }
            $profesor = Teacher::create(['person_id'=>$persona->id]);
        }
    }

    public function update(Request $request)
    {
        $teacher = Teacher::findOrFail($request->teacherData['id_teacher']);
        $teacher->person->update([
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
        return;
    }

    public function destroy(Request $request)
    {
        $teacher = Teacher::findOrFail($request->id);
        $teacher->delete();
        return;
    }
}
