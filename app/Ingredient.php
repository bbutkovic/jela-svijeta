<?php

namespace App;

use \App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Ingredient extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

}
