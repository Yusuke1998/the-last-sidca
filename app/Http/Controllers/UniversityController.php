<?php

namespace App\Http\Controllers;

use App\University;
use Illuminate\Http\Request;

class UniversityController extends Controller
{
    public function index()
    {
        return view('preload.universities');
    }

    public function getAll()
    {
        $universities = University::all();
        return $universities;
    }

    public function universitiesDataTable(Request $request)
    {
        $universities = $this->filterUnivDataTable($request);
        return [
            'pagination' => [
                'total'         => $universities->total(),
                'current_page'  => $universities->currentPage(),
                'per_page'      => $universities->perPage(),
                'last_page'     => $universities->lastPage(),
                'from'          => $universities->firstItem(),
                'to'            => $universities->lastItem(),
            ],
            'table' => $universities
        ];
    }

    public function filterUnivDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $universities = University::with('titles');

        if (!is_null($search) && !empty($search)) {
            $universities
            ->where('name','like','%'.$search.'%')
            ->orWhere('acronym','like','%'.$search.'%')
            ->orWhereHas('titles',function ($query) use ($search) {
                $query
                ->where('title','like','%'.$search.'%')
                ->orWhere('level','like','%'.$search.'%');
            });
        }
        return $universities->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:100|string',
            'acronym'=>'required|min:3|max:20|string',
            'titles'=>'required'
        ]);
        $titles = collect($request->titles);
        $ids = $titles->pluck('id');
        if ($request->id == 0) {
            $university = University::create([
                'name'=>$request->name,
                'acronym'=>$request->acronym,
            ]);
            $university->titles()->sync($ids);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:100|string',
            'acronym'=>'required|min:3|max:20|string',
            'titles'=>'required'
        ]);
        $titles = collect($request->titles);
        $ids = $titles->pluck('id');
        if ($request->id > 0) {
            $university = University::findOrFail($request->id);
            $university->update([
                'name'=>$request->name,
                'acronym'=>$request->acronym,
            ]);
            $university->titles()->sync($ids);
        }
    }

    public function destroy(Request $request)
    {
        $university = University::findOrFail($request->id);
        $university->delete();
        return;
    }
}
