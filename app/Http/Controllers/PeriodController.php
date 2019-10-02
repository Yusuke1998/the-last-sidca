<?php

namespace App\Http\Controllers;

use App\Period;
use Illuminate\Http\Request;

class PeriodController extends Controller
{
    public function index()
    {
        return view('preload.periods');
    }

    public function getAll()
    {
        $titulos = Period::all();
        return $titulos;
    }

    public function periodsDataTable(Request $request)
    {
        $periods = $this->filterPeriodDataTable($request);
        return [
            'pagination' => [
                'total'         => $periods->total(),
                'current_page'  => $periods->currentPage(),
                'per_page'      => $periods->perPage(),
                'last_page'     => $periods->lastPage(),
                'from'          => $periods->firstItem(),
                'to'            => $periods->lastItem(),
            ],
            'table' => $periods
        ];
    }

    public function filterPeriodDataTable($request)
    {
        $search = mb_strtolower($request->search,'UTF-8');
        $periods = Period::where('id','!=','0');

        if (!is_null($search) && !empty($search)) {
            $periods
            ->where('period','like','%'.$search.'%');
        }
        return $periods->orderBy('period','DESC')->paginate($request->sort);
    }

    public function store(Request $request)
    {
        $data = request()->validate([
            'period'=>'required|min:4|max:6|string|unique:periods',
        ]);
        if ($request->id == 0) {
            $period = Period::create([
                'period'=>$request->period,
            ]);
        }
        return;
    }

    public function update(Request $request)
    {
        $data = request()->validate([
            'period'=>'required|min:4|max:6|string|unique:periods',
        ]);
        if ($request->id > 0) {
            $period = Period::findOrFail($request->id);
            $period->update([
                'period'=>$request->period,
            ]);
        }
    }

    public function destroy(Request $request)
    {
        $period = Period::findOrFail($request->id);
        $period->delete();
        return;
    }
}
