<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Session extends Model
{
    protected $fillable = [
        'wetlab_id',
        'start_time',
        'end_time',
        'seats'
    ];

    public function wetlab()
    {
        return $this->belongsTo(WetLab::class);
    }
}
