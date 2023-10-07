<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest as LaravelFormRequest;

abstract class ApiRequest extends LaravelFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    abstract public function rules();

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    abstract public function authorize();

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator $validator
     * @return void
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()->json([
                'status' => 'error',
                'message' => __("Invalid form data"),
                'type' => 'validation',
                'errors' => $this->dataResopnsewithKey($validator)
            ], 422)
        );
    }

    public function dataResopnsewithKey($validator)
    {
        $errors = [];
        foreach ($validator->errors()->messages() as $key => $value) {
            $errors[$key] = is_array($value) ? implode(',', $value) : $value;
        }
        return $errors;
    }
}
