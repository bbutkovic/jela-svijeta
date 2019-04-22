<?php

namespace App;

use \App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public function category() {
        return $this->belongsTo('App\\Category');
    }

    public function tags() {
        return $this->belongsToMany('App\\Tag');
    }

    public function ingredients() {
        return $this->belongsToMany('App\\Ingredient');
    }
}
