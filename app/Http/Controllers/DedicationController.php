<?php

namespace App\Http\Controllers;

use App\Dedication;
use Illuminate\Http\Request;

class DedicationController extends Controller
{
    public function getAll()
    {
        $dedicaciones = Dedication::all();
        return $dedicaciones;
    }
}
