<?php

namespace App\Http\Controllers;

use App\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    /**
     * Display a list of the meals
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('meals');
    }
}
