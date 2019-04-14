<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Passport extends Authenticatable
{
    use Notifiable;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'event_id',
        'admin_id',
        'title',
        'first_name',
        'middle_name',
        'last_name',
        'work_place',
        'country',
        'bar_code',
        'code',
        'amount',
        'mobile_no',
        'profession',
        'specialist',
        'sfch_number',
        'sfch_image',
        'bank_recipt',
        'email',
        'expire_date',
        'approve',
        'payment',
        'conference_reg',
        'wet_lab_reg',
        'type_of_payment',
        'status',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
        'password', 'remember_token',
    ];

    public function fullName()
    {
        return sprintf('%s %s', $this->first_name, $this->last_name);
    }

    public function avatar()
    {
        $path = storage_path('app/public/avatars/'.$this->id.'.png');
        if(file_exists($path)) {
            return url('storage/avatars/'.$this->id.'.png');
        }
        return url('storage/avatars/empty.png');
    }

    /**
     * The courses that belong to the user.
     */
     public function courses()
     {
         return $this->belongsToMany(Course::class);
     }

     /**
     * The wetlabs that belong to the user.
     */
     public function wetlabs()
     {
         return $this->belongsToMany(WetLab::class, 'passport_wetlab', 'passport_id', 'wetlab_id');
     }

     /**
     * Get the comments for the blog post.
     */
    public function cart()
    {
        return $this->hasMany(Cart::class);
    }
}
