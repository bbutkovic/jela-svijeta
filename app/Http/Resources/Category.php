<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Traits\AcceptsLanguage;


class Category extends JsonResource
{
    use AcceptsLanguage;
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $translation = $this->getTranslation($this->lang);
        $title = $translation ? $translation->title : '';
        return [
            'id' => $this->id,
            'title' => $title,
            'slug' => $this->slug,
        ];
    }
}
