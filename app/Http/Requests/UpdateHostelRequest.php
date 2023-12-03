<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHostelRequest extends ApiRequest
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
            'user_id'=>['required'],
            'hostel_image'=>['nullable', 'array'],
            'hostel_image.*'=>['image'],

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
