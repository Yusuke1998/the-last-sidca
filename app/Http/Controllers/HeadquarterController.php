<?php

namespace App\Http\Controllers;

use App\Headquarter;
use Illuminate\Http\Request;

class HeadquarterController extends Controller
{
    public function index()
    {
        return view('preload.headquarters');
    }

    public function headquarterDataTable(Request $request)
    {
        $headquarters = $this->filterHeadDataTable($request);
        return [
            'pagination' => [
                'total'         => $headquarters->total(),
                'current_page'  => $headquarters->currentPage(),
                'per_page'      => $headquarters->perPage(),
                'last_page'     => $headquarters->lastPage(),
                'from'          => $headquarters->firstItem(),
                'to'            => $headquarters->lastItem(),
            ],
            'table' => $headquarters
        ];
    }

    public function filterHeadDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $headquarters = Headquarter::with('areas');

        if (!is_null($search) && !empty($search)) {
            $headquarters
            ->where('name','like','%'.$search.'%')
            ->orWhereHas('areas',function ($query) use ($search) {
                $query->where('name','like','%'.$search.'%');
            });
        }
        return $headquarters->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate(['name'=>'required|min:3|max:50|string']);
        
        if ($request->id == 0) {
            Headquarter::create(['name'=>$request->name]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate(['name'=>'required|min:3|max:50|string']);

        if ($request->id > 0) {
            Headquarter::findOrFail($request->id)
                ->update(['name'=>$request->name]);
        }
        return;
    }

    public function destroy(Request $request)
    {
        $headquarter = Headquarter::findOrFail($request->id);
        $headquarter->delete();
        return;
    }
}
