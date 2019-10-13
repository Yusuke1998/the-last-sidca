<?php

namespace App\Http\Controllers;

use App\Extension;
use Illuminate\Http\Request;

class ExtensionController extends Controller
{
    public function index()
    {
        return view('preload.extensions');
    }

    public function getAll($area,$program)
    {
        $extensiones = Extension::where('area_id',$area)->where('program_id',$program)->get();
        return $extensiones;
    }

    public function extensionDataTable(Request $request)
    {
        $extensions = $this->filterExtensionDataTable($request);
        return [
            'pagination' => [
                'total'         => $extensions->total(),
                'current_page'  => $extensions->currentPage(),
                'per_page'      => $extensions->perPage(),
                'last_page'     => $extensions->lastPage(),
                'from'          => $extensions->firstItem(),
                'to'            => $extensions->lastItem(),
            ],
            'table' => $extensions
        ];
    }

    public function filterExtensionDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $extensions = Extension::with('area','program');

        if (!is_null($search) && !empty($search)) {
            $extensions
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('area',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            })
            ->orWhereHas('program',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            });
        }
        return $extensions->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:50|string',
            'area'=>'required',
            'program'=>'required'
        ]);
        
        if ($request->id == 0) {
            Extension::create([
                'name'=>$request->name,
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
            'area'=>'required',
            'program'=>'required'
        ]);

        if ($request->id > 0) {
            Extension::findOrFail($request->id)
            ->update([
                'name'=>$request->name,
                'area_id'=>$request->area['id'],
                'program_id'=>$request->program['id']
            ]);
        }
        return;
    }

    public function destroy(Request $request)
    {
        $extension = Extension::findOrFail($request->id);
        $extension->delete();
        return;
    }
}
