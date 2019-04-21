<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Language;
use App\Http\Controllers\Api\MealController as ApiMealController;
use App\Http\Controllers\Api\MealController;

class MealsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(Language::class, function($app) {
            $code = $app->request->get('lang') ?? config('app.fallback_locale', 'en');
            return Language::where('code', $code)->first() ?? abort(404);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
