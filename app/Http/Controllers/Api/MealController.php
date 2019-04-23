<?php

namespace App\Http\Controllers\Api;

use App\Meal;
use App\Language;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests\MealListingRequest;
use App\Http\Controllers\Controller;

class MealController extends Controller
{
    /**
     * Display the list of meals filtered by entered query parameters.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MealListingRequest $request, Language $lang)
    {
        $mq = (new Meal)->newQuery();

        //Select which data to include in the response
        if($request->has('with')) {
            $mq->with($request->input('with'));
        }

        //Filter search by category ID
        if($request->has('category')) {
            $mq->byCategory($request->input('category'));
        }

        //Filter search by tags, every record must have every requested tag
        if($request->has('tags')) {
            $mq->byTags($request->input('tags'));
        }

        //Filter search by touched after timestamp
        $diffTime = null;
        if($request->has('diff_time')) {
            $diffTime = Carbon::parse($request->input('diff_time'));
            $mq->touchedAfter($diffTime);
        }

        $meals = $mq->get();
        
        //In case we filtered the request by diff_time also check status
        if($diffTime) {
            $meals->each(function($meal) use($diffTime) {
                $meal->setStatusAfter($diffTime);
            });
        }

        return $meals;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function show(Meal $meal)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function edit(Meal $meal)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Meal $meal)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Meal  $meal
     * @return \Illuminate\Http\Response
     */
    public function destroy(Meal $meal)
    {
        //
    }
}
