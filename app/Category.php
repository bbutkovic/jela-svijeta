<?php

namespace App;

use \App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

}
