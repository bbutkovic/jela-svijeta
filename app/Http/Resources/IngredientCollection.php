<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;
use App\Traits\AcceptsLanguage;

class IngredientCollection extends ResourceCollection
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
