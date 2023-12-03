<?php

namespace App\Http\Requests\RoomRequest;

use App\Http\Requests\ApiRequest;
use Illuminate\Foundation\Http\FormRequest;

class CreateRoomRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */

    public function rules(): array
    {
        return [
            'room_number' => ['required'],
            'room_type' => ['required'],
            'capacity' => ['required'],
            'availability' => ['required'],
            'price' => ['required'],
            'features' => ['required'],
            'hostel_id' => ['required'],
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
