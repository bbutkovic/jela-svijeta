<?php

namespace App\Http\Requests;

use App\Rules\CategoryRule;

class MealListingRequest extends ApiRequest
{

    public function prepareForValidation() {
        $toPrepare = ['tags', 'with'];
        $prepared = [];
        foreach($toPrepare as $field) {
            $input = $this->input($field);
            if($input) {
                $prepared[$field] = preg_split('/\s*,\s*/', trim($input));
            }
        }
        $this->merge($prepared);
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
            'tags.*' => 'required|integer',
            'with' => 'sometimes|array',
            'with.*' => 'required|in:ingredients,category,tags|distinct',
            'diff_time' => 'sometimes|integer',
        ];
    }
}
