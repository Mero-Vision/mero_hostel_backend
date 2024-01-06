<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Room extends BaseModel implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    public function userRooms(){
        
        return $this->hasMany(UserRoom::class);
    }
}