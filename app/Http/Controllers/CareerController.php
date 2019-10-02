<?php

namespace App\Http\Controllers;

use App\Career;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        return view('preload.careers');
    }

    public function getAll()
    {
        $carreras = Career::all();
        return $carreras;
    }

    public function careerDataTable(Request $request)
    {
        $carreras = $this->filterCareerDataTable($request);
        return [
            'pagination' => [
                'total'         => $carreras->total(),
                'current_page'  => $carreras->currentPage(),
                'per_page'      => $carreras->perPage(),
                'last_page'     => $carreras->lastPage(),
                'from'          => $carreras->firstItem(),
                'to'            => $carreras->lastItem(),
            ],
            'table' => $carreras
        ];
    }

    public function filterCareerDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $carreras = Career::with('area');

        if (!is_null($search) && !empty($search)) {
            $carreras
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('area',function ($query) use ($search) {
                $query
                ->where('name','like','%'.$search.'%')
                ->orWhereHas('cores',function ($sudQuery) use ($search) {
                    $sudQuery->where('name','like','%'.$search.'%');
                });
            });
        }
        return $carreras->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'area'=>'required'
        ]);
        if ($request->id == 0) {
            $carrera = Career::create([
                'name'=>$request->name,
                'area_id'=>$request->area['id'],
            ]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'area'=>'required'
        ]);
        if ($request->id > 0) {
            $carrera = Career::findOrFail($request->id);
            $carrera->update([
                'name'=>$request->name,
                'area_id'=>$request->area['id'],
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $carrera = Career::findOrFail($request->id);
        $carrera->delete();
        return;
    }
}
