<?php

namespace App\Http\Controllers;
use App\AcademicTraining;
use Illuminate\Http\Request;

class AcademicTrainingController extends Controller
{
    public function getAll($id)
    {
        $formacionesAcademicas = AcademicTraining::with('teacher')->where('teacher_id',$id)->get();
        return $formacionesAcademicas;
    }
}
