<?php

namespace App\Http\Controllers;

use App\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        return view('preload.subjects');
    }

    public function getAll()
    {
        $asignaturas = Subject::all();
        return $asignaturas;
    }

    public function subjectDataTable(Request $request)
    {
        $subjects = $this->filterSubjectDataTable($request);
        return [
            'pagination' => [
                'total'         => $subjects->total(),
                'current_page'  => $subjects->currentPage(),
                'per_page'      => $subjects->perPage(),
                'last_page'     => $subjects->lastPage(),
                'from'          => $subjects->firstItem(),
                'to'            => $subjects->lastItem(),
            ],
            'table' => $subjects
        ];
    }

    public function filterSubjectDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $subjects = Subject::with('programs');

        if (!is_null($search) && !empty($search)) {
            $subjects
            ->where('name','like','%'.$search.'%')
            ->orWhere('practical_hour','like','%'.$search.'%')
            ->orWhere('theoretical_hour','like','%'.$search.'%')
            ->orWhereHas('programs',function ($query) use ($search) {
                $query
                ->where('name','like','%'.$search.'%');
            });
        }
        return $subjects->orderBy('updated_at','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:100|string',
            'theoretical_hour'=>'required',
            'practical_hour'=>'required',
            'programs'=>'required'
        ]);
        $programs = collect($request->programs);
        $ids = $programs->pluck('id');
        if ($request->id == 0) {
            $subject = Subject::create([
                'name'=>$request->name,
                'theoretical_hour'=>$request->theoretical_hour,
                'practical_hour'=>$request->practical_hour,
            ]);
            $subject->programs()->sync($ids);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'name'=>'required|min:3|max:100|string',
            'theoretical_hour'=>'required',
            'practical_hour'=>'required',
            'programs'=>'required'
        ]);
        $programs = collect($request->programs);
        $ids = $programs->pluck('id');
        if ($request->id > 0) {
            $subject = Subject::findOrFail($request->id);
            $subject->update([
                'name'=>$request->name,
                'theoretical_hour'=>$request->theoretical_hour,
                'practical_hour'=>$request->practical_hour,
            ]);
            $subject->programs()->sync($ids);
        }
    }

    public function destroy(Request $request)
    {
        $subject = Subject::findOrFail($request->id);
        $subject->delete();
        return;
    }
}
