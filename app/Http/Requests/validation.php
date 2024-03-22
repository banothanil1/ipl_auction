<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use  App\Http\Controllers\usercontroller;

class validation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'jersey_number' => 'required|integer|unique:players,jersey_number',
            'place' => 'required|max:255',
            'age' => 'required|integer|min:18|max:50', // Assuming players must be between 18 and 50 years old
            'base_price' => 'required|numeric|min:200000',
            //'sold_price' => 'nullable|numeric|min:20000',
        ];
    }
    

    public function messages(): array
    {
        return [
            'name.required'=>'the name should be properly entered',
            'jersey_number.unique' => 'The jersey number has already been taken.',
            'place'=>'need enter in a way proper way ',
            'age.min' => 'The player must be at least 18 years old.',
            'age.max' => 'The player must be at most 50 years old.',
            'base_price.min'=>'base price should be min 200000 '
        ];
    }
}
