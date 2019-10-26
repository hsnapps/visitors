<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'wetlab_id',
        'start_time',
        'end_time',
        'seats_available',
        'seats_taken',
    ];

    public function wetlab()
    {
        return $this->belongsTo(WetLab::class, 'wetlab_id', 'id');
    }
}
