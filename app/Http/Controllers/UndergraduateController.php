<?php

namespace App\Http\Controllers;

use App\Undergraduate;
use Illuminate\Http\Request;

class UndergraduateController extends Controller
{
    public function getAll($id)
    {
        $pregrados = Undergraduate::with('university','title','teacher')->where('teacher_id',$id)->get();
        return $pregrados;
    }
}
