<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Ingredient;
use Faker\Generator as Faker;
use App\Helpers\FakerLocales;

$factory->define(Ingredient::class, function (Faker $faker) {
    $locales = FakerLocales::getLocales();
    $titles = FakerLocales::format($locales, function($f) {
        return $f->word();
    });
    return $titles->merge([
        'slug' => $faker->slug()
    ])->toArray();
});
