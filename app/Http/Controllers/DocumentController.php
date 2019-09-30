<?php

namespace App\Http\Controllers;

use App\Document;
use App\Person;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    public function getAll()
    {
        $documentos = Document::all();
        return $documentos;
    }

    public function index()
    {
        //
    }

    public function check_document(Request $request)
    {
        $person = Person::with('document','types','user')
                    ->where('nro_document',$request->nro)
                    ->first();
        return (!is_null($person))?$person:0;

    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Document $document)
    {
        //
    }

    public function destroy(Document $document)
    {
        //
    }
}
