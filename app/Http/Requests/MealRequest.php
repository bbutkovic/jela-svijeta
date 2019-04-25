<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MealRequest extends ApiRequest
{
    public function prepareForValidation() {
        $with = $this->input('with');
        if($with && !is_array($with)) {
            $this->merge([
                'with' => preg_split('/\s*,\s*/', trim($with))
            ]);
        }
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
            'with' => 'sometimes|array',
            'with.*' => 'required|in:ingredients,category,tags|distinct',
        ];
    }
}
