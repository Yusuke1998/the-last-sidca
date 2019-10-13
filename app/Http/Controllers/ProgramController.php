<?php

namespace App\Http\Controllers;
use Validator;
use App\Program;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProgramController extends Controller
{
    public function index()
    {
        return view('preload.programs');
    }

    public function getAll($id)
    {
        $programas = Program::where('area_id',$id)->get();
        return $programas;
    }

    public function getMany()
    {
        $programas = Program::all();
        return $programas;
    }

    public function programDataTable(Request $request)
    {
        $programas = $this->filterProgramDataTable($request);
        return [
            'pagination' => [
                'total'         => $programas->total(),
                'current_page'  => $programas->currentPage(),
                'per_page'      => $programas->perPage(),
                'last_page'     => $programas->lastPage(),
                'from'          => $programas->firstItem(),
                'to'            => $programas->lastItem(),
            ],
            'table' => $programas
        ];
    }

    public function filterProgramDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $programas = Program::with('area','headquarter');

        if (!is_null($search) && !empty($search)) {
            $programas
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('area',function ($query) use ($search) {
                $query
                ->where('name','like','%'.$search.'%')
                ->orWhereHas('cores',function ($sudQuery) use ($search) {
                    $sudQuery->where('name','like','%'.$search.'%');
                });
            });
        }
        return $programas->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'              =>'required|min:3|max:50|string',
            'area.id'           =>'required',
            'area.name'         =>'required',
            'headquarter.id'    =>'required',
            'headquarter.name'  =>'required'
        ]);

        if ($request->id == 0) {
            $programa = Program::create([
                'name'          =>$request->name,
                'area_id'       =>$request->area['id'],
                'headquarter_id'=>$request->headquarter['id'],
            ]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'          =>'required|min:3|max:50|string',
            'area'          =>'required',
            'headquarter'   =>'required'
        ]);
        if ($request->id > 0) {
            $programa = Program::findOrFail($request->id);
            $programa->update([
                'name'          =>$request->name,
                'area_id'       =>$request->area['id'],
                'headquarter_id'=>$request->headquarter['id'],
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $programa = Program::findOrFail($request->id);
        $programa->delete();
        return;
    }
}
