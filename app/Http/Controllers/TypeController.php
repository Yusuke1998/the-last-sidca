<?php

namespace App\Http\Controllers;

use App\Type;
use Illuminate\Http\Request;

class TypeController extends Controller
{
    public function getAll()
    {
        $tipos = Type::all();
        return $tipos;
    }

    public function index()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function update(Request $request, Type $type)
    {
        //
    }

    public function destroy(Type $type)
    {
        //
    }
}
