<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
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
        'fees',
    ];

    /**
    * The attributes that should be mutated to dates.
    *
    * @var array
    */
    protected $dates = [
        'starts_on',
    ];
}
