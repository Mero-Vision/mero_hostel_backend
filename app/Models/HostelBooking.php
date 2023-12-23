<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HostelBooking extends BaseModel
{
    use HasFactory;

    public function hostel(){
        return $this->belongsTo(Hostel::class);
    }

    public function users(){
        return $this->belongsTo(User::class);
    }

    
}