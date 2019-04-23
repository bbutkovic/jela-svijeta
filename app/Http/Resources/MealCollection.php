<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Language;
use App\Traits\AcceptsLanguage;

class MealCollection extends ResourceCollection
{
    use AcceptsLanguage;

    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return $this->passLanguage($this->collection);
    }
}
