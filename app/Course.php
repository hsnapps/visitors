<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
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
        return $this->belongsToMany(Passport::class);
    }

    public function categories()
    {
        return $this->belongsToMany(PassportTitle::class, 'category_course', 'course_id', 'category_id');
    }
}
