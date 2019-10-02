<?php

namespace App\Http\Controllers;

use App\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{
    public function index()
    {
        return view('preload.programs');
    }

    public function getAll()
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
        $programas = Program::with('careers');

        if (!is_null($search) && !empty($search)) {
            $programas
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('careers',function ($query) use ($search) {
                $query
                ->where('name','like','%'.$search.'%');
            });
        }
        return $programas->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'careers'=>'required'
        ]);
        $careers = collect($request->careers);
        $ids = $careers->pluck('id');
        if ($request->id == 0) {
            $program = Program::create([
                'name'=>$request->name,
            ]);
            $program->careers()->sync($ids);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'careers'=>'required'
        ]);
        $careers = collect($request->careers);
        $ids = $careers->pluck('id');
        if ($request->id > 0) {
            $program = Program::findOrFail($request->id);
            $program->update([
                'name'=>$request->name
            ]);
            $program->careers()->sync($ids);
        }
    }

    public function destroy(Request $request)
    {
        $program = Program::findOrFail($request->id);
        $program->delete();
        return;
    }
}
