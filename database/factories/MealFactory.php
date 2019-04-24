<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use App\Meal;
use App\Language;
use Faker\Generator as Faker;
use Faker\Factory as FakerFactory;

$factory->define(Meal::class, function (Faker $faker) {
    $fakerLocales = [
        'en' => 'en_US',
        'hr' => 'hr_HR'
    ];
    $codes = Language::pluck('code');

    $meal = [];
    $type = $faker->randomElement(['soup', 'cake', 'pasta']);
    foreach($codes as $code) {
        if(isset($fakerLocales[$code])) {
            $languageFaker = FakerFactory::create($fakerLocales[$code]);
            $meal['title:' . $code] = $languageFaker->firstName() . ' ' . $type;
        }
    }
    $created = $faker->dateTimeBetween('-3 days', '-1 days');
    $updated = $faker->dateTimeBetween($created, '-1 days');
    $deleted = null;
    if($faker->boolean()) {
        $deleted = $faker->dateTimeBetween($updated, '-1 days');
    }

    $meal['created_at'] = $created;
    $meal['updated_at'] = $updated;
    $meal['deleted_at'] = $deleted;

    return $meal;
});
