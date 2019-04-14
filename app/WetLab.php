<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WetLab extends Model
{
    use SoftDeletes;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
     protected $fillable = [
        'name',
        'seats',
        'starts_on',
        'days',
        'price',
     ];

     /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'starts_on',
    ];

    /**
     * The visitors that belong to the course.
     */
    public function visitors()
    {
        return $this->belongsToMany(Passport::class, 'passport_wetlab', 'wetlab_id', 'passport_id');
    }
}
