<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateHostelRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

      public function rules(): array
    {
        return [

            'hostel_name'=>['required'],
            'hostel_type'=>['required',Rule::in('Boys hostel', 'Girls hostel')],
            'address'=>['required'],
            'phone_number'=>['required'],
            'email'=>['nullable','email'],
            'website'=>['required'],
            'hostel_image'=>['nullable','image'],


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
