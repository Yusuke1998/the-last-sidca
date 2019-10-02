<?php

namespace App\Http\Controllers;

use App\Area;
use Illuminate\Http\Request;

class AreaController extends Controller
{
    public function index()
    {
        return view('preload.areas');
    }

    public function getAll()
    {
        $areas = Area::all();
        return $areas;
    }

    public function areaDataTable(Request $request)
    {
        $areas = $this->filterAreaDataTable($request);
        return [
            'pagination' => [
                'total'         => $areas->total(),
                'current_page'  => $areas->currentPage(),
                'per_page'      => $areas->perPage(),
                'last_page'     => $areas->lastPage(),
                'from'          => $areas->firstItem(),
                'to'            => $areas->lastItem(),
            ],
            'table' => $areas
        ];
    }

    public function filterAreaDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $areas = Area::with('careers','cores');

        if (!is_null($search) && !empty($search)) {
            $areas
            ->where('name','like','%'.$search.'%')
            ->orWhere('acronym','like','%'.$search.'%')
            ->orWhereHas('careers',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            })
            ->orWhereHas('cores',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            });
        }
        return $areas->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
        ]);
        if ($request->id == 0) {
            $area = Area::create([
                'name'=>$request->name,
                'acronym'=>$request->acronym,
            ]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
        ]);
        if ($request->id > 0) {
            $area = Area::findOrFail($request->id);
            $area->update([
                'name'=>$request->name,
                'acronym'=>$request->acronym,
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $area = Area::findOrFail($request->id);
        $area->delete();
        return;
    }
}
