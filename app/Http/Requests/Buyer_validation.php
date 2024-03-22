<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class Buyer_validation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'teamname' => 'required|string|max:255',
            'coach_name' => 'required|max:255',
            'state' => 'required|max:255',
            'contact' => 'required|unique:buyers|max:10', 
            'networth' => 'required|numeric|min:1500000',
            'password' => 'required|min:8|confirmed', 
            'password_confirmation' =>'required|min:8'
        ];
    }

    public function messages():array{
        return [
            'contact.required' => 'The :attribute must be a valid phone number with max 10 digits.',
            'contact.unique' => 'The :attribute has already been taken.',
            'networth.min' => 'The :attribute must mroe then equal to 1500000 .',
            'password.confirmed' => 'The password should match confirm password field',
            'password_confirmation'=>'password should be confirmed'
        ];
    }

}
