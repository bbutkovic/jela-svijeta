<?php

namespace App\Helpers;

use App\Language;
use Faker\Factory;

class FakerLocales {
    static $fakerLocales = [
        'en' => 'en_US',
        'hr' => 'hr_HR',
        'fr' => 'fr_FR',
    ];

    static function getLocales($locales = null, $all = false) {
        $fakerLocales = collect($locales ?: static::$fakerLocales);
        if($all) {
            return $fakerLocales;
        }

        $codes = Language::whereIn('code', $fakerLocales->keys())->get()->pluck('code');
        return $fakerLocales->intersectByKeys($codes->flip());
    }

    static function format($locales, \Closure $valueFunc, $format = 'title:') {
        $locales = collect($locales);
        return $locales->flatMap(function($locale, $code) use($valueFunc, $format) {
            $faker = Factory::create($locale);
            $value = $valueFunc($faker);
            $key = ($format instanceof Closure) ? $format($code) : $format . $code;
            return [$key => $value];
        });
    }
}