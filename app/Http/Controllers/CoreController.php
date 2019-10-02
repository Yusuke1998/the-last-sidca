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

    public function getAll()
    {
        $nucleos = Core::all();
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
        $cores = Core::with('area');

        if (!is_null($search) && !empty($search)) {
            $cores
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('area',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            });
        }
        return $cores->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'area'=>'required'
        ]);
        
        if ($request->id == 0) {
            Core::create([
                'name'=>$request->name,
                'area_id'=>$request->area['id']
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
            Core::findOrFail($request->id)
                ->update([
                    'name'=>$request->name,
                    'area_id'=>$request->area['id']
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
