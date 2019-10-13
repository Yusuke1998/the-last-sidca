<?php

namespace App\Http\Controllers;

use App\Postgraduate;
use Illuminate\Http\Request;

class PostgraduateController extends Controller
{
    public function getAll($id)
    {
        $posgrados = Postgraduate::with('university','title','teacher')->where('teacher_id',$id)->get();
        return $posgrados;
    }
}
