<?php

namespace App\Http\Controllers;

use App\Type;
use App\Memo;
use App\Scale;
use App\Ascent;
use App\Person;
use App\Teacher;
use App\Movement;
use App\Category;
use App\Condition;
use App\Postgraduate;
use App\Undergraduate;
use App\AcademicTraining;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;
use Alphametric\Validation\Rules\EncodedPDF;

class MovementController extends Controller
{
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
            'teacherData.person.nro_document' => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
            'ascent.modality'				  => 'required',
            'ascent.category'				  => 'required',
            'ascent.status'				  	  => 'required',
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
            'memo.area.code' 				  => 'nullable',
            'memo.area.date' 				  => 'required_with:memo.area.code',
            'memo.vrac.code' 				  => 'nullable',
            'memo.vrac.date' 				  => 'required_with:memo.vrac.code',
            'memo.cu.code'	 				  => 'nullable',
            'memo.cu.date'	 				  => 'required_with:memo.cu.code',
        ]);

        switch ($request->ascent['modality']) {
        	case 'art. 61':
        		$this->multPublic($request);
        		break;
        	case 'art. 62':
        		$this->multPublic($request);
        		break;
        	case 'art. 64':
        		$this->singFile($request);
        		break;
        	case 'ubicacion':
        		$this->singFileLoc($request);
        		break;
        }
    }

    private function multPublic($request)
    {
    	request()->validate([
            'publications.*.title'			=> 'required',
            'publications.*.rev' 			=> 'required',
            'publications.*.code_issn'		=> 'required',
            'publications.*.nro_isbn'		=> 'required',
            'publications.*.nro_edit'		=> 'required',
            'publications.*.vol'			=> 'required',
            'publications.*.date'			=> 'required|date',
            'publications.*.url'			=> 'required|url',
            'publications.*.postgraduate'	=> 'required',
        ]);

        $profesor = Teacher::find($request->teacherData['id']);
        $profesor->update(['category_id'=>$this->categories($request)['catA']]);
        $ascenso = Ascent::create([
        	'modality'				=>	$request->ascent['modality'],
        	'current_category_id'	=>	$this->categories($request)['catA'],
        	'date'					=>	$this->categories($request)['datA'],
        	'next_category_id'		=>	$this->categories($request)['catS'],
        	'date_next'				=>	$this->categories($request)['datS'],
        	'teacher_id'			=>	$profesor->id,
        ]);

    	foreach ($request->publications as $publication) {
    		$ascenso->publications()->create([
    			'teacher_id'		=>	$profesor->id,
    			'rev'				=>	$publication['rev'],
    			'vol'				=>	$publication['vol'],
    			'url'				=>	$publication['url'],
    			'title'				=>	$publication['title'],
    			'nro_isbn'			=>	$publication['nro_isbn'],
    			'nro_edit'			=>	$publication['nro_edit'],
    			'code_issn'			=>	$publication['code_issn'],
    			'postgraduate_id'	=>	$publication['postgraduate']['id'],
    			'date'				=>	Carbon::parse($publication['date'])->toDateString(),
    		]);
    	}

        $this->memos($request,$ascenso,$profesor);
    }

    private function singFile($request)
    {
    	request()->validate([
            'job.title' 					=> 'required',
            'job.url'						=> 'nullable|min:10|url',
            'job.file'						=> ['nullable', new EncodedPDF('pdf')],
            'job.date'						=> 'required|date',
            'teacherData.postgraduate'		=> 'required',
            'job.presentation.date'			=> 'required|date',
            'job.presentation.location'		=> 'required|min:10|max:300',
            'job.presentation.hour'			=> 'required',
            'job.jury.coordinator'			=> 'required|min:10|max:100',
            'job.jury.principal1'			=> 'required|min:10|max:100',
            'job.jury.principal2'			=> 'required|min:10|max:100',
            'job.jury.alternate1'			=> 'required|min:10|max:100',
            'job.jury.alternate2'			=> 'required|min:10|max:100',
            'job.jury.alternate3'			=> 'required|min:10|max:100',
        ]);

        $profesor = Teacher::find($request->teacherData['id']);
        $profesor->update(['category_id'=>$this->categories($request)['catA']]);
        $ascenso = Ascent::create([
        	'modality'				=>	$request->ascent['modality'],
        	'current_category_id'	=>	$this->categories($request)['catA'],
        	'date'					=>	$this->categories($request)['datA'],
        	'next_category_id'		=>	$this->categories($request)['catS'],
        	'date_next'				=>	$this->categories($request)['datS'],
        	'teacher_id'			=>	$profesor->id,
        ]);

    	$exploded = explode(',', $request->job['file']);
        $decoded = base64_decode($exploded[1]);
        $exploded2 = explode('/',$exploded[0]);
        $exploded3 = explode(';',$exploded2[1]);
        $extension = $exploded3[0];
        $document = $request->teacherData['person']['nro_document'];
        $ascent = $ascenso->id;
        $filename = 'jobs/'.$document.'-'.$ascent.'.'.$extension;
        $path = Storage::put("public/".$filename, $decoded);

        $ascenso->job()->create([
        	'title'				=>	$request->job['title'],
	        'date'				=>	Carbon::parse($request->job['date'])->toDateString(),
	        'url'				=>	$request->job['url'],
	        'file'				=>	$filename,
        	'postgraduate_id'	=>	$request->teacherData['postgraduate']['id'],
	        'teacher_id'		=>	$profesor->id,
	        'coordinator'		=>	$request->job['jury']['coordinator'],
	        'principal1'		=>	$request->job['jury']['principal1'],
	        'principal2'		=>	$request->job['jury']['principal2'],
	        'alternate1'		=>	$request->job['jury']['alternate1'],
	        'alternate2'		=>	$request->job['jury']['alternate2'],
	        'alternate3'		=>	$request->job['jury']['alternate3'],
	        'location'			=>	$request->job['presentation']['location'],
	        'datep'				=>	Carbon::parse($request->job['presentation']['hour'])->toDateString(),
	        'hourp'				=>	Carbon::parse($request->job['presentation']['hour']),
        ]);

        $this->memos($request,$ascenso,$profesor);
    }

    private function singFileLoc($request)
    {
        request()->validate([
            'teacherData.postgraduate'		=> 'required',
            'scale.date'					=> 'required|date',
            'scale.file'					=> ['required', new EncodedPDF('pdf')],
            'scale.description' 			=> 'nullable|min:10|max:100',
        ]);

        $profesor = Teacher::find($request->teacherData['id']);
        $profesor->update(['category_id'=>$this->categories($request)['catA']]);
        $ascenso = Ascent::create([
        	'modality'				=>	$request->ascent['modality'],
        	'current_category_id'	=>	$this->categories($request)['catA'],
        	'date'					=>	$this->categories($request)['datA'],
        	'next_category_id'		=>	$this->categories($request)['catS'],
        	'date_next'				=>	$this->categories($request)['datS'],
        	'teacher_id'			=>	$profesor->id,
        ]);

    	$exploded = explode(',', $request->job['file']);
        $decoded = base64_decode($exploded[1]);
        $exploded2 = explode('/',$exploded[0]);
        $exploded3 = explode(';',$exploded2[1]);
        $extension = $exploded3[0];
        $document = $request->teacherData['person']['nro_document'];
        $ascent = $ascenso->id;
        $filename = 'scales/'.$document.'-'.$ascent.'.'.$extension;
        $path = Storage::put("public/".$filename, $decoded);

        $ascenso->scale()->create([
	        'date'				=>	Carbon::parse($request->scale['date'])->toDateString(),
	        'file'				=>	$filename,
        	'postgraduate_id'	=>	$request->teacherData['postgraduate']['id'],
	        'teacher_id'		=>	$profesor->id,
	        'description'		=>	$request->scale['description']
        ]);

        $this->memos($request,$ascenso,$profesor);
    }

    private function categories($request)
    {
    	$dc = Carbon::parse($request->ascent['date'])->toDateString();
        $dn = Carbon::parse($request->ascent['date']);
        if ($request->ascent['category']['name'] == 'instructor'){
            $cc_id = $request->ascent['category']['id'];
            $nc_id = Category::where('name','asistente')->first()->id;
            $dn->addYears(2)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->ascent['category']['name'] == 'asistente') {
            $cc_id = $request->ascent['category']['id'];
            $nc_id = Category::where('name','agregado')->first()->id;
            $dn->addYears(4)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->ascent['category']['name'] == 'agregado') {
            $cc_id = $request->ascent['category']['id'];
            $nc_id = Category::where('name','asociado')->first()->id;
            $dn->addYears(4)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->ascent['category']['name'] == 'asociado') {
            $cc_id = $request->ascent['category']['id'];
            $nc_id = Category::where('name','titular')->first()->id;
            $dn->addYears(5)->toDateString();
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }elseif ($request->ascent['category']['name'] == 'titular') {
            $cc_id = $request->ascent['category']['id'];
            $dn = null;
            $nc_id = null;
            return ["catA"=>$cc_id,"datA"=>$dc,"catS"=>$nc_id,"datS"=>$dn];
        }
    }

    private function memos($request,$ascent,$teacher)
    {
    	if (!empty($request->memo['area']['code']) && !empty($request->memo['vrac']['code']) && !empty($request->memo['cu']['code'])) {
	    	$ascent->memo()->create([
	    		'area_code'		=>	$request->memo['area']['code'],
	    		'area_date'		=>	Carbon::parse($request->memo['area']['date'])->toDateString(),
	    		'vrac_code'		=>	$request->memo['vrac']['code'],
	    		'vrac_date'		=>	Carbon::parse($request->memo['vrac']['date'])->toDateString(),
	    		'cu_code'		=>	$request->memo['cu']['code'],
	    		'cu_date'		=>	Carbon::parse($request->memo['cu']['date'])->toDateString(),
	    	]);
	    	$ascent->update(['status'=>'aprobado']);
    	}
    }
	// Ascenso

	// Concurso de Oposicion
	public function ocontest_index()
    {
        return view('movement.ocontest');
    }

    public function ocontest_store(Request $request)
    {
    	request()->validate([
            'teacherData.person.firstname'    => 'required',
            'teacherData.person.lastname'     => 'required', 
            'teacherData.person.nro_document' => 'required', 
            'teacherData.person.document.id'  => 'required',
            'teacherData.person.birthday'     => 'required|date',
            'teacherData.dedication'          => 'required',
            'teacherData.condition'           => 'required',
            'teacherData.category'            => 'required',
            'ascent.modality'				  => 'required',
            'ascent.category'				  => 'required',
            'ascent.status'				  	  => 'required',
            'teacherData.headquarter.name'    => 'required',
            'teacherData.area.name'           => 'required',
            'teacherData.program.name'        => 'required',
        ]);
    }
	// Concurso de Oposicion
}
