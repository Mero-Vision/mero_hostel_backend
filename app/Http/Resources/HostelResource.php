<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class HostelResource extends JsonResource
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
            'hostel_name'=>$this->hostel_name,
            'slug'=>$this->slug,
            'address'=>$this->address,
            'phone_number'=>$this->phone_number,
            'email'=>$this->email,
            'website'=>$this->website,
            'user_id'=>$this->user_id,
            'created_at'=>$this->created_at,
            'updated_at'=>$this->updated_at,
            'hostel_images'=>$this->getFirstMediaUrl('hostel_image'),
        ];
    }
}
