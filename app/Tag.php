<?php

namespace App;

use \App\Traits\Translatable;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use Translatable;

    public $translatedAttributes = ['title'];

    public $fillable = ['slug'];
}
