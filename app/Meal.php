<?php

namespace App;

use \App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

}
