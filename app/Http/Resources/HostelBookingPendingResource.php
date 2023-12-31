<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HostelBookingPendingResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = $this->users;
        return [
            'id'=>$this->id,
            'user_id'=>$this->user_id,
           'name'=>$this->name,
           'email'=>$this->email,
           'requested'=>$this->created_at->diffForHumans(),
           
        ];
    }
}