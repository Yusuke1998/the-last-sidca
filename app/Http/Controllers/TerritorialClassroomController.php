<?php

namespace App\Http\Controllers;

use App\TerritorialClassroom;
use Illuminate\Http\Request;

class TerritorialClassroomController extends Controller
{
    public function index()
    {
        return view('preload.tclassroom');
    }

    public function getAll()
    {
        $tclassroom = TerritorialClassroom::with('headquarter','area','program')->get();
        return $tclassroom;
    }

    public function tclassroomDataTable(Request $request)
    {
        $tClassroom = $this->filterTclassroomDataTable($request);
        return [
            'pagination' => [
                'total'         => $tClassroom->total(),
                'current_page'  => $tClassroom->currentPage(),
                'per_page'      => $tClassroom->perPage(),
                'last_page'     => $tClassroom->lastPage(),
                'from'          => $tClassroom->firstItem(),
                'to'            => $tClassroom->lastItem(),
            ],
            'table' => $tClassroom
        ];
    }

    public function filterTclassroomDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $tClassroom = TerritorialClassroom::with('headquarter','area','program');

        if (!is_null($search) && !empty($search)) {
            $tClassroom
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
        return $tClassroom->orderBy('updated_at','DESC')->paginate($request->sort);
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
            TerritorialClassroom::create([
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
            'headquarter'=>'required',
            'name'=>'required|min:3|max:50|string',
            'area'=>'required',
            'program'=>'required'
        ]);

        if ($request->id > 0) {
            TerritorialClassroom::findOrFail($request->id)
                ->update([
                    'headquarter_id'=>$request->headquarter['id'],
                    'name'=>$request->name,
                    'area_id'=>$request->area['id'],
                    'program_id'=>$request->program['id']
                ]);
        }
        return;
    }

    public function destroy(Request $request)
    {
        $extension = TerritorialClassroom::findOrFail($request->id);
        $extension->delete();
        return;
    }
}
