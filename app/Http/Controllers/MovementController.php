<?php

namespace App\Http\Controllers;

use App\Ascent;
use App\Movement;
use Illuminate\Http\Request;

class MovementController extends Controller
{
    public function ascent_index()
    {
        return view('movement.ascent');
    }
}
