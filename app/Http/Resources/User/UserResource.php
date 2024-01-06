<?php

namespace App\Http\Resources\User;

use App\Http\Resources\UserRoomResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'hostel_id'=>$this->hostel_id,
            'name' => $this->name,
            'email' => $this->email,
            'email_verified_at'=>$this->email_verified_at,
            'status' => $this->status,
            'profile_image' => $this->getFirstMediaUrl('profile_image'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'user_room'=>new UserRoomResource($this->whenLoaded('userRoom')),
        ];
    }
}
