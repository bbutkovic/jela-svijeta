<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule as BaseRule;
use Illuminate\Support\Facades\Validator;


class CategoryRule implements BaseRule
{
    /**
     * Determines if the validation failed due to not being found in DB
     * 
     * @var bool
     */
    private $notFound;
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->notFound = false;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if($value == 'NULL' || $value == '!NULL') {
            return true;
        }

        $validator = Validator::make([
            'category' => $value
        ],[
            'category' => 'exists:categories,id'
        ]);
        if(! $validator->passes()) {
            $this->notFound = true;
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return $this->notFound ? 'Category not found.' : 'Category must be NULL, !NULL or a valid category ID.';
    }
}
