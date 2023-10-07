<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ForgotPasswordRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

      public function rules(): array
    {
        return [

            'email'=>['required','email','exists:users,email']
        ];
    }

   public function messages()
   {
    return [
            'email.exists'=>'The email does not exist in the system!',
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
