<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Meal;
use Faker\Generator as Faker;
use App\Helpers\FakerLocales;


$factory->define(Meal::class, function (Faker $faker) {
    $locales = FakerLocales::getLocales();
    $titles = FakerLocales::format($locales, function($f) {
        return $f->firstName();
    });

    $created = $faker->dateTimeBetween('-3 days', '-1 days');
    $updated = $faker->dateTimeBetween($created, '-1 days');
    $deleted = null;
    if($faker->boolean()) {
        $deleted = $faker->dateTimeBetween($updated, '-1 days');
    }

    $meal = $titles->merge([
        'created_at' => $created,
        'updated_at' => $updated,
        'deleted_at' => $deleted
    ]);
    return $meal->toArray();
});
