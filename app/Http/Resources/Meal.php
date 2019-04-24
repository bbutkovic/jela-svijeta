<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Carbon\Carbon;
use App\Language;
use App\Http\Resources\Category;
use App\Traits\AcceptsLanguage;

class Meal extends JsonResource
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
        $status = 'created';
        if($request->has('diff_time')) {
            $dt = Carbon::createFromTimestamp($request->input('diff_time'));
            if($this->deleted_at && $this->deleted_at->gt($dt)) {
                $status = 'deleted';
            } else if(!$this->created_at->eq($this->updated_at) && $this->updated_at->gt($dt)) {
                $status = 'updated';
            }
        }
        $translation = $this->getTranslation($this->lang);
        $title = $translation ? $translation->title : '';
        $category = $this->whenLoaded('category');
        $tags = $this->whenLoaded('tags');
        $ingredients = $this->whenLoaded('ingredients');
        return [
            'id' => $this->id,
            'title' => $title,
            'status' => $status,
            'category' => $category ? (new Category($category))->setLanguage($this->lang) : null,
            'tags' => $tags ? (new TagCollection($tags))->setLanguage($this->lang) : [],
            'ingredients' => $ingredients ? (new IngredientCollection($ingredients))->setLanguage($this->lang) : [],
        ];
    }
}
