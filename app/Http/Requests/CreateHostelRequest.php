<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateHostelRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

      public function rules(): array
    {
        return [

            'hostel_name'=>['required'],
            'address'=>['required'],
            'phone_number'=>['required'],
            'email'=>['nullable','email'],
            'website'=>['required'],
            'user_id'=>['required']

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