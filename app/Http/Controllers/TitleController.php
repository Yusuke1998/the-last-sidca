<?php

namespace App\Http\Controllers;

use App\Title;
use Illuminate\Http\Request;

class TitleController extends Controller
{
    public function index()
    {
        return view('preload.titles');
    }

    public function getAll()
    {
        $titulos = Title::all();
        return $titulos;
    }

    public function titlesDataTable(Request $request)
    {
        $titles = $this->filterTitleDataTable($request);
        return [
            'pagination' => [
                'total'         => $titles->total(),
                'current_page'  => $titles->currentPage(),
                'per_page'      => $titles->perPage(),
                'last_page'     => $titles->lastPage(),
                'from'          => $titles->firstItem(),
                'to'            => $titles->lastItem(),
            ],
            'table' => $titles
        ];
    }

    public function filterTitleDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $titles = Title::with('universities');

        if (!is_null($search) && !empty($search)) {
            $titles
            ->where('title','like','%'.$search.'%')
            ->orWhere('level','like','%'.$search.'%')
            ->orWhereHas('universities',function ($query) use ($search) {
                $query
                ->where('name','like','%'.$search.'%')
                ->orWhere('acronym','like','%'.$search.'%');
            });
        }
        return $titles->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'title'=>'required|min:3|max:100|string',
            'level'=>'required|min:3|max:20|string',
            'universities'=>'required'
        ]);
        $universities = collect($request->universities);
        $ids = $universities->pluck('id');
        if ($request->id == 0) {
            $title = Title::create([
                'title'=>$request->title,
                'level'=>$request->level,
            ]);
            $title->universities()->sync($ids);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'title'=>'required|min:3|max:100|string',
            'level'=>'required|min:3|max:20|string',
            'universities'=>'required'
        ]);
        $universities = collect($request->universities);
        $ids = $universities->pluck('id');
        if ($request->id > 0) {
            $title = Title::findOrFail($request->id);
            $title->update([
                'title'=>$request->title,
                'level'=>$request->level,
            ]);
            $title->universities()->sync($ids);
        }
    }

    public function destroy(Request $request)
    {
        $title = Title::findOrFail($request->id);
        $title->delete();
        return;
    }
}
