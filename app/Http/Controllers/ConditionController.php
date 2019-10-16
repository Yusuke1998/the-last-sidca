<?php

namespace App\Http\Controllers;

use App\Condition;
use Illuminate\Http\Request;

class ConditionController extends Controller
{
    public function getAll()
    {
        $condiciones = Condition::all();
        return $condiciones;
    }
}
