<?php

namespace App\Http\Requests\RoomRequest;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRoomRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

      public function rules(): array
    {
        return [
            'room_number' => ['required', Rule::unique('rooms','room_number')],
            'room_type' => ['required'],
            'capacity' => ['required'],
            'availability' => ['required'],
            'price' => ['required', 'numeric'],
            'features' => ['required'],
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
