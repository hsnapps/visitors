<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'name',
     ];

     public $timestamps = false;

    public function passports()
    {
        return $this->hasMany(Passport::class);
    }

    public function wetLabs()
    {
        return $this->belongsToMany(WetLab::class, 'category_wet_lab', 'category_id', 'wet_lab_id');
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'category_course', 'category_id', 'course_id');
    }
}
