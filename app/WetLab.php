<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WetLab extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
    'name',
    'seats',
    'starts_on',
    'days',
    'price',
    ];
     
    protected $dates = [
        'starts_on',
    ];
    
    public function visitors()
    {
        return $this->belongsToMany(Passport::class, 'passport_wetlab', 'wetlab_id', 'passport_id');
    }

    public function categories()
    {
        return $this->belongsToMany(PassportTitle::class, 'category_wet_lab', 'wet_lab_id', 'category_id');
    }
}
