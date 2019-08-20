<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public $timestamps = false;
    protected $fillable = ['category', 'count'];
    
    public function bookings() {
        return $this->hasMany(HotelBooking::class);
    }
}
