<?php

namespace App\Http\Controllers;

use App\Core;
use Illuminate\Http\Request;

class CoreController extends Controller
{
    public function index()
    {
        return view('preload.cores');
    }

    public function getAll($area,$program)
    {
        $nucleos = Core::where('area_id',$area)->where('program_id',$program)->get();
        return $nucleos;
    }

    public function coreDataTable(Request $request)
    {
        $cores = $this->filterCoreDataTable($request);
        return [
            'pagination' => [
                'total'         => $cores->total(),
                'current_page'  => $cores->currentPage(),
                'per_page'      => $cores->perPage(),
                'last_page'     => $cores->lastPage(),
                'from'          => $cores->firstItem(),
                'to'            => $cores->lastItem(),
            ],
            'table' => $cores
        ];
    }

    public function filterCoreDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $cores = Core::with('area','program','headquarter');

        if (!is_null($search) && !empty($search)) {
            $cores
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('headquarter',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            })
            ->orWhereHas('area',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            })
            ->orWhereHas('program',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            });
        }
        return $cores->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'headquarter'=>'required',
            'area'=>'required',
            'program'=>'required'
        ]);
        
        if ($request->id == 0) {
            Core::create([
                'name'=>$request->name,
                'headquarter_id'=>$request->headquarter['id'],
                'area_id'=>$request->area['id'],
                'program_id'=>$request->program['id']
            ]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'headquarter'=>'required',
            'area'=>'required',
            'program'=>'required'
        ]);

        if ($request->id > 0) {
            Core::findOrFail($request->id)
            ->update([
                'name'=>$request->name,
                'headquarter_id'=>$request->headquarter['id'],
                'area_id'=>$request->area['id'],
                'program_id'=>$request->program['id']
            ]);
        }
        return;
    }

    public function destroy(Request $request)
    {
        $core = Core::findOrFail($request->id);
        $core->delete();
        return;
    }
}
