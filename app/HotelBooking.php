<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HotelBooking extends Model
{
    protected $fillable = [
        'days',
        'price',
    ];

    protected $casts = [
        'available' => 'boolean',
    ];

    protected $dates = [
        'starts_on',
    ];

    public function passport() {
        return $this->belongsTo(Passport::class);
    }
}
