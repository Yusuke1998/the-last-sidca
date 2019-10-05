<?php

namespace App\Http\Controllers;

use App\Type;
use App\Person;
use App\Authority;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class AuthorityController extends Controller
{
    public function index()
    {
        return view('preload.authorities');
    }

    public function getAll()
    {
        $autoridades = Authority::all();
        return $autoridades;
    }

    public function authorityDataTable(Request $request)
    {
        $autoridades = $this->filterAuthoryDataTable($request);
        return [
            'pagination' => [
                'total'         => $autoridades->total(),
                'current_page'  => $autoridades->currentPage(),
                'per_page'      => $autoridades->perPage(),
                'last_page'     => $autoridades->lastPage(),
                'from'          => $autoridades->firstItem(),
                'to'            => $autoridades->lastItem(),
            ],
            'table' => $autoridades
        ];
    }

    public function filterAuthoryDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $authorities = Authority::with('person.user','person.document');

        if (!is_null($search) && !empty($search)) {
            $authorities
            ->where('type','like','%'.$search.'%')
            ->orWhereHas('person',function ($query) use ($search) {
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
        return $authorities->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        if ($request->authorityData['id_authority'] == 0 && $request->authorityData['person']['id'] == 0) {
            $persona = Person::create([
                'firstname'     => $request->authorityData['person']['firstname'],
                'lastname'      => $request->authorityData['person']['lastname'], 
                'document_id'   => $request->authorityData['person']['document']['id'],
                'nro_document'  => $request->authorityData['person']['nro_document'],
                'local_phone'   => $request->authorityData['person']['local_phone'],
                'movil_phone'   => $request->authorityData['person']['movil_phone'],
                'direction'     => mb_strtolower($request->authorityData['person']['direction'],'UTF-8'),
                'mail_contact'  => mb_strtolower($request->authorityData['person']['mail_contact'],'UTF-8'),
                'birthday'      => Carbon::parse($request->authorityData['person']['birthday'])->toDateString(),
            ]);
            if (is_null($persona->types()->where('name','authority')->first())) {
                $type = Type::where('name','authority')->first();
                $persona->types()->attach($type->id);
            }
            $profesor = Authority::create(
                ['person_id'=>$persona->id,'type'=>$request->authorityData['type']]
            );

        }elseif ($request->authorityData['id_authority'] == 0 && $request->authorityData['person']['id'] > 0) {
            $persona = Person::findOrFail($request->authorityData['person']['id']);
            if (is_null($persona->types()->where('name','authority')->first())) {
                $type = Type::where('name','authority')->first();
                $persona->types()->attach($type->id);
            }
            $profesor = Authority::create(['person_id'=>$persona->id,'type'=>$request->authorityData['type']]);
        }
    }

    public function update(Request $request)
    {
        $authority = Authority::findOrFail($request->authorityData['id_authority']);
        $authority->update(['type'=>$request->authorityData['type']]);
        $authority->person->update([
            'firstname'     => $request->authorityData['person']['firstname'],
            'lastname'      => $request->authorityData['person']['lastname'], 
            'document_id'   => $request->authorityData['person']['document']['id'],
            'nro_document'  => $request->authorityData['person']['nro_document'],
            'local_phone'   => $request->authorityData['person']['local_phone'],
            'movil_phone'   => $request->authorityData['person']['movil_phone'],
            'direction'     => mb_strtolower($request->authorityData['person']['direction'],'UTF-8'),
            'mail_contact'  => mb_strtolower($request->authorityData['person']['mail_contact'],'UTF-8'),
            'birthday'      => Carbon::parse($request->authorityData['person']['birthday'])->toDateString(),
        ]);
        return;
    }

    public function destroy(Request $request)
    {
        $authority = Authority::findOrFail($request->id);
        $authority->delete();
        return;
    }
}
