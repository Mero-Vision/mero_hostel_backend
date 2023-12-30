<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserRoomResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
            'room_id'=>$this->room_id,
            'check_in_date'=>$this->check_in_date,
            'check_out_date'=>$this->check_out_date,
            'status'=>$this->status,
            'created_at'=>$this->created_at,
           
        ];
    }
}