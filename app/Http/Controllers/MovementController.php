<?php

namespace App\Http\Controllers;

use App\Ascent;
use App\Movement;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Alphametric\Validation\Rules\EncodedPDF;

class MovementController extends Controller
{
	public function dropzone(Request $request)
	{
		if($request->hasFile('file'))
		{
			return $request->file;
		}
	}

	// Ascenso
    public function ascent_index()
    {
        return view('movement.ascent');
    }

    public function ascent_store(Request $request)
    {
    	request()->validate([
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
            'ascent.modality'				  => 'required',
            'ascent.category'				  => 'required',
            'ascent.status'				  	  => 'required',
        ]);

        switch ($request->ascent['modality']) {
        	case 'art. 61':
        		$this->a61($request);
        		break;
        	case 'art. 62':
        		$this->a62($request);
        		break;
        	case 'art. 64':
        		$this->a64($request);
        		break;
        	case 'ubicacion':
        		$this->ubi($request);
        		break;
        }
    }

    private function a61($request)
    {
    	request()->validate([
    		'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'publications.*.title'			=> 'required',
            'publications.*.rev' 			=> 'required',
            'publications.*.code_issn'		=> 'required',
            'publications.*.nro_isbn'		=> 'required',
            'publications.*.nro_edit'		=> 'required',
            'publications.*.vol'			=> 'required',
            'publications.*.date'			=> 'required',
            'publications.*.url'			=> 'required',
            'publications.*.postgraduate'	=> 'required',
        ]);
    }

    private function a62($request)
    {
    	request()->validate([
    		'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'publications.*.title'			=> 'required',
            'publications.*.rev' 			=> 'required',
            'publications.*.code_issn'		=> 'required',
            'publications.*.nro_isbn'		=> 'required',
            'publications.*.nro_edit'		=> 'required',
            'publications.*.vol'			=> 'required',
            'publications.*.date'			=> 'required',
            'publications.*.url'			=> 'required',
            'publications.*.postgraduate'	=> 'required',
        ]);
    }

    private function a64($request)
    {
    	request()->validate([
            'teacherData.postgraduate'	=> 'required',
            'job.title' 				=> 'required',
            'job.url'					=> 'nullable|min:10',
            'job.file'					=> ['nullable', new EncodedPDF('pdf')],
        ]);

    	$exploded = explode(',', $request->job['file']);
        $decoded = base64_decode($exploded[1]);

        dd($exploded[0]);
    }

    private function ubi($request)
    {
    }
	// Ascenso
}
