<?php

namespace App\Http\Requests;

use App\Rules\CategoryRule;

class MealListingRequest extends ApiRequest
{

    public function prepareForValidation() {    
        $this->merge([
            'tags' => explode(',', $this->input('tags')),
            'with' => explode(',', $this->input('with')),
            ]);
    }


    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'lang' => 'required|exists:languages,code',
            'per_page' => 'sometimes|integer',
            'page' => 'sometimes|integer',
            'category' => [
                'sometimes',
                new CategoryRule
            ],
            'tags' => 'sometimes|array',
            'tags.*' => 'sometimes|integer',
            'with' => 'sometimes|array',
            'with.*' => 'sometimes|in:ingredients,category,tags|distinct',
            'diff_time' => 'sometimes|integer',
        ];
    }
}
