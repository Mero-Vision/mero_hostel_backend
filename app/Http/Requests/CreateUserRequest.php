<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

      public function rules(): array
    {
        return [

            'name'=>['required','string','min:3','max:255'],
            'email'=>['required','string','email',Rule::unique('users','email')],
            'password'=>['required','min:8','confirmed'],
            'status'=>['required','in:Hostel_Owner,Hostel_Searcher'],
        ];
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */


    public function authorize(): bool
    {
        return true;
    }
}
