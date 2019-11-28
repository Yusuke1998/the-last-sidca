<?php

namespace App\Http\Controllers;

use App\Ascent;
use App\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MovementController extends Controller
{
	// Ascenso
    public function ascent_index()
    {
        return view('movement.ascent');
    }

    public function ascent_store(Request $request)
    {
    	return $request->all();
    	
    	request()->validate([
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
        ]);
    }
	// Ascenso
}
