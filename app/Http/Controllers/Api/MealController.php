<?php

namespace App\Http\Controllers\Api;

use App\Meal;
use App\Http\Resources\MealCollection;
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
        $with = [];
        if($request->has('with')) {
            //For each selected object also fetch its translations
            $with = $request->input('with');
            foreach($with as $object) {
                $with[] = $object . '.translations';
            }
        }
        //Always include translations for meals
        $with[] = 'translations';
        $mq->with($with);

        //Filter search by category ID
        if($request->has('category')) {
            $mq->byCategory($request->input('category'));
        }

        //Filter search by tags, every record must have every requested tag
        if($request->has('tags')) {
            $mq->byTags($request->input('tags'));
        }

        //Filter search by touched after timestamp
        if($request->has('diff_time')) {
            $mq->touchedAfter(Carbon::parse(strtotime($request->input('diff_time'))));
        }

        //Limit the search to per_page results, keeping the default at 5. Pass the query string into the paginator
        $perPage = 5;
        if($request->has('per_page')) {
            $perPage = $request->input('per_page');
        }
        $paginator = $mq->paginate($perPage);
        $paginator->appends($request->except('path'));

        return (new MealCollection($paginator))->setLanguage($lang);
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
